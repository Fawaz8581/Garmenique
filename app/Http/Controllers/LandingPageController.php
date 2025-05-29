<?php

namespace App\Http\Controllers;

use App\Models\PageSetting;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page with customized settings
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all settings for the homepage
        $settings = PageSetting::getPageSettings('homepage');
        
        // Initialize default settings
        $pageSettings = [
            'hero' => [
                'enabled' => true,
                'title' => 'GARMENIQUE',
                'subtitle' => 'Elegance in every stitch. Premium clothing crafted for those who appreciate quality and style.',
                'backgroundImage' => 'https://images.unsplash.com/photo-1490725263030-1f0521cec8ec?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'buttonText' => 'SHOP NOW',
                'buttonLink' => '/catalog'
            ],
            'categories' => [
                'enabled' => true,
                'title' => 'SHOP BY CATEGORY',
                'items' => [
                    ['name' => 'JACKETS', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', 'link' => '/catalog?category=jackets'],
                    ['name' => 'VESTS', 'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', 'link' => '/catalog?category=vests'],
                    ['name' => 'PANTS', 'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', 'link' => '/catalog?category=pants'],
                    ['name' => 'SWEATERS', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', 'link' => '/catalog?category=sweaters'],
                    ['name' => 'OUTERWEAR', 'image' => 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&h=300&q=80', 'link' => '/catalog?category=outerwear']
                ]
            ],
            'featured' => [
                'enabled' => true,
                'items' => [
                    ['title' => 'NEW ARRIVALS', 'image' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', 'link' => '/catalog?collection=new'],
                    ['title' => 'BEST SELLERS', 'image' => 'https://images.unsplash.com/photo-1485125639709-a60c3a500bf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', 'link' => '/catalog?collection=best'],
                    ['title' => 'THE HOLIDAY OUTFIT', 'image' => 'https://images.unsplash.com/photo-1543076447-215ad9ba6923?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80', 'link' => '/catalog?collection=holiday']
                ]
            ],
            'mission' => [
                'enabled' => true,
                'title' => 'WE\'RE ON A MISSION TO CLEAN UP THE INDUSTRY',
                'backgroundImage' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=70',
                'buttonText' => 'LEARN MORE',
                'buttonLink' => '/about'
            ]
        ];
        
        // Override with saved settings if available
        foreach ($settings as $setting) {
            if ($setting->section_name === 'hero' && $setting->is_enabled) {
                $pageSettings['hero']['enabled'] = true;
                
                if (isset($setting->settings['title'])) {
                    $pageSettings['hero']['title'] = $setting->settings['title'];
                }
                
                if (isset($setting->settings['subtitle'])) {
                    $pageSettings['hero']['subtitle'] = $setting->settings['subtitle'];
                }
                
                if (isset($setting->settings['backgroundImage'])) {
                    $pageSettings['hero']['backgroundImage'] = $setting->settings['backgroundImage'];
                }
                
                if (isset($setting->settings['buttonText'])) {
                    $pageSettings['hero']['buttonText'] = $setting->settings['buttonText'];
                }
                
                if (isset($setting->settings['buttonLink'])) {
                    $pageSettings['hero']['buttonLink'] = $setting->settings['buttonLink'];
                }
            }
            
            if ($setting->section_name === 'categories') {
                $pageSettings['categories']['enabled'] = $setting->is_enabled;
                
                if (isset($setting->settings['title'])) {
                    $pageSettings['categories']['title'] = $setting->settings['title'];
                }
                
                if (isset($setting->settings['items']) && !empty($setting->settings['items'])) {
                    $pageSettings['categories']['items'] = $setting->settings['items'];
                }
            }
            
            if ($setting->section_name === 'featured') {
                $pageSettings['featured']['enabled'] = $setting->is_enabled;
                
                if (isset($setting->settings['items']) && !empty($setting->settings['items'])) {
                    $pageSettings['featured']['items'] = $setting->settings['items'];
                }
            }
            
            if ($setting->section_name === 'mission') {
                $pageSettings['mission']['enabled'] = $setting->is_enabled;
                
                if (isset($setting->settings['title'])) {
                    $pageSettings['mission']['title'] = $setting->settings['title'];
                }
                
                if (isset($setting->settings['backgroundImage'])) {
                    $pageSettings['mission']['backgroundImage'] = $setting->settings['backgroundImage'];
                }
                
                if (isset($setting->settings['buttonText'])) {
                    $pageSettings['mission']['buttonText'] = $setting->settings['buttonText'];
                }
                
                if (isset($setting->settings['buttonLink'])) {
                    $pageSettings['mission']['buttonLink'] = $setting->settings['buttonLink'];
                }
            }
        }
        
        return view('landing_page', ['pageSettings' => $pageSettings]);
    }
} 