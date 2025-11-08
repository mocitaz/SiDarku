<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\TTDLog;
use App\Models\Cycle;

class ProfilePage extends Component
{
    public $activeTab = 'profile';
    
    // Profile fields
    public $name;
    public $email;
    public $date_of_birth;
    public $phone;
    public $phone_country_code = '+62';
    public $occupation;
    public $occupation_other;
    public $marital_status;
    
    // Password fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    
    // Statistics
    public $totalCheckins;
    public $currentStreak;
    public $totalCycles;
    public $lastCheckin;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->date_of_birth = $user->date_of_birth;
        
        // Parse phone number
        if ($user->phone) {
            // Extract country code and number
            if (preg_match('/^(\+\d{1,3})(.+)$/', $user->phone, $matches)) {
                $this->phone_country_code = $matches[1];
                $this->phone = $matches[2];
            } else {
                $this->phone = $user->phone;
            }
        }
        
        // Parse occupation
        $occupations = $this->getOccupationsList();
        if ($user->occupation && in_array($user->occupation, $occupations)) {
            $this->occupation = $user->occupation;
        } else if ($user->occupation) {
            $this->occupation = 'Other';
            $this->occupation_other = $user->occupation;
        }
        
        $this->marital_status = $user->marital_status;
        
        // Calculate statistics
        $this->calculateStatistics();
    }

    public function calculateStatistics()
    {
        $userId = auth()->id();
        
        // Total check-ins
        $this->totalCheckins = TTDLog::where('user_id', $userId)->count();
        
        // Current streak
        $this->currentStreak = $this->calculateStreak();
        
        // Total cycles tracked
        $this->totalCycles = Cycle::where('user_id', $userId)->count();
        
        // Last check-in
        $lastLog = TTDLog::where('user_id', $userId)
            ->latest('log_date')
            ->first();
        $this->lastCheckin = $lastLog ? $lastLog->log_date : null;
    }

    private function calculateStreak()
    {
        $logs = TTDLog::where('user_id', auth()->id())
            ->orderBy('log_date', 'desc')
            ->get()
            ->pluck('log_date')
            ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->values();

        if ($logs->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $expectedDate = \Carbon\Carbon::today();

        foreach ($logs as $logDate) {
            $checkDate = \Carbon\Carbon::parse($logDate);
            
            if ($checkDate->equalTo($expectedDate) || $checkDate->equalTo($expectedDate->copy()->subDay())) {
                $streak++;
                $expectedDate = $checkDate->copy()->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }

    public function updateProfile()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'date_of_birth' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'phone_country_code' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
        ];
        
        // If occupation is "Other", validate the custom field
        if ($this->occupation === 'Other') {
            $rules['occupation_other'] = 'required|string|max:255';
        }

        $validated = $this->validate($rules, [
            'date_of_birth.before' => 'Anda harus berusia minimal 10 tahun.',
            'phone.max' => 'Nomor telepon terlalu panjang.',
            'occupation_other.required' => 'Silakan isi pekerjaan Anda.',
            'marital_status.in' => 'Status pernikahan tidak valid.',
        ]);

        // Combine country code and phone number
        $fullPhone = null;
        if ($this->phone) {
            $fullPhone = $this->phone_country_code . $this->phone;
        }
        
        // Determine final occupation value
        $finalOccupation = $this->occupation === 'Other' ? $this->occupation_other : $this->occupation;

        auth()->user()->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'phone' => $fullPhone,
            'occupation' => $finalOccupation,
            'marital_status' => $validated['marital_status'] ?? null,
        ]);

        session()->flash('message', 'Profil berhasil diperbarui! ✨');
        
        $this->dispatch('profile-updated');
    }
    
    private function getOccupationsList()
    {
        return [
            'Pelajar',
            'Mahasiswa',
            'Guru',
            'Dosen',
            'Dokter',
            'Perawat',
            'Bidan',
            'PNS',
            'Karyawan Swasta',
            'Wiraswasta',
            'Ibu Rumah Tangga',
            'Freelancer',
            'Petani',
            'Pedagang',
            'Buruh',
            'Profesional',
            'Pengusaha',
            'Belum Bekerja',
        ];
    }

    public function updatePassword()
    {
        $validated = $this->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($this->current_password, auth()->user()->password)) {
            $this->addError('current_password', 'Password saat ini salah.');
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        // Reset password fields
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('message', 'Password berhasil diubah! 🔒');
    }

    public function render()
    {
        return view('livewire.profile-page')->layout('layouts.app');
    }
}
