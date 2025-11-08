<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function show($slug)
    {
        $education = Education::where('slug', $slug)->firstOrFail();
        return view('education.show', compact('education'));
    }
}
