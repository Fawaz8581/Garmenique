<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('admin.settings');
    }
} 