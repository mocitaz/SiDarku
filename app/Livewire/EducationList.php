<?php

namespace App\Livewire;

use App\Models\Education;
use Livewire\Component;

class EducationList extends Component
{
    public $search = '';
    public $selectedCategory = 'Semua';
    
    public $categories = [
        'Semua',
        'Anemia',
        'Menstruasi',
        'TTD',
        'Nutrisi',
        'Tips Sehat',
    ];

    public function mount()
    {
        // Check if category parameter exists in URL
        if (request()->has('category')) {
            $category = request()->query('category');
            // Validate category exists in our categories array
            if (in_array($category, $this->categories)) {
                $this->selectedCategory = $category;
            }
        }
    }

    public function updatingSearch()
    {
        // Live search - no need to do anything, Livewire handles it
    }

    public function filterByCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        $query = Education::query();
        
        if ($this->selectedCategory !== 'Semua') {
            $query->where('category', $this->selectedCategory);
        }
        
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }
        
        $educations = $query->orderBy('created_at', 'desc')->get();
        
        // Get featured article (latest one)
        $featuredArticle = $educations->first();
        
        // Get other articles (skip the first one)
        $otherArticles = $educations->skip(1)->take(6);
        
        // Get more articles for grid
        $gridArticles = $educations->skip(7);
        
        return view('livewire.education-list', [
            'educations' => $educations,
            'featuredArticle' => $featuredArticle,
            'otherArticles' => $otherArticles,
            'gridArticles' => $gridArticles,
        ])->layout('layouts.app');
    }
}
