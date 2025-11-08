<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsPage extends Component
{
    public $emailReminderEnabled;
    public $deletePassword;
    public $deleteConfirmation = '';

    public function mount()
    {
        $user = Auth::user();
        // Pastikan default true jika null (untuk kompatibilitas dengan user lama)
        $this->emailReminderEnabled = $user->email_ttd_reminder_enabled !== null 
            ? (bool) $user->email_ttd_reminder_enabled 
            : true;
        
        // Jika null, set ke true di database
        if ($user->email_ttd_reminder_enabled === null) {
            $user->update(['email_ttd_reminder_enabled' => true]);
            $this->emailReminderEnabled = true;
        }
    }

    public function toggleEmailReminder()
    {
        $user = Auth::user();
        $user->update([
            'email_ttd_reminder_enabled' => !$this->emailReminderEnabled
        ]);
        
        $this->emailReminderEnabled = $user->email_ttd_reminder_enabled;
        
        $message = $this->emailReminderEnabled 
            ? 'Notifikasi email reminder TTD telah diaktifkan!' 
            : 'Notifikasi email reminder TTD telah dinonaktifkan. Anda tidak akan menerima email reminder lagi.';
        
        session()->flash('message', $message);
    }

    public function deleteAccount()
    {
        $this->validate([
            'deletePassword' => 'required',
            'deleteConfirmation' => 'required|in:HAPUS AKUN SAYA',
        ], [
            'deletePassword.required' => 'Password wajib diisi untuk menghapus akun.',
            'deleteConfirmation.required' => 'Anda harus mengetik konfirmasi untuk menghapus akun.',
            'deleteConfirmation.in' => 'Konfirmasi tidak sesuai. Ketik "HAPUS AKUN SAYA" dengan huruf kapital.',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->deletePassword, $user->password)) {
            $this->addError('deletePassword', 'Password salah. Akun tidak dapat dihapus.');
            return;
        }

        // Logout user before deletion
        Auth::logout();

        // Delete user and related data (cascade will handle related records)
        $user->delete();

        session()->flash('message', 'Akun Anda telah dihapus. Terima kasih telah menggunakan SiDarku!');
        
        return redirect()->route('landing');
    }

    public function render()
    {
        return view('livewire.settings-page')->layout('layouts.app');
    }
}
