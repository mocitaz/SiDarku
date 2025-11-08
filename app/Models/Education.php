<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Education extends Model
{
    protected $table = 'educations';
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'image',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($education) {
            if (empty($education->slug)) {
                $education->slug = Str::slug($education->title);
            }
        });
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Check if file exists in storage
        if (!Storage::disk('public')->exists($this->image)) {
            \Log::warning('Education image not found in storage: ' . $this->image . ' (Education ID: ' . $this->id . ')');
            return null;
        }

        // Always use route to serve image (more reliable, especially in production)
        // This works whether symlink exists or not
        // Extract just the filename from the path
        $path = str_replace('educations/', '', $this->image);
        
        // Ensure we're only passing the filename, not the full path
        $filename = basename($path);
        
        try {
            $url = route('education.image', ['path' => $filename]);
            \Log::debug('Generated image URL for ' . $this->image . ': ' . $url);
            return $url;
        } catch (\Exception $e) {
            \Log::error('Error generating image URL: ' . $e->getMessage());
            // Fallback to direct storage URL
            return Storage::disk('public')->url($this->image);
        }
    }
}
