<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Get all categories as JSON.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
} 