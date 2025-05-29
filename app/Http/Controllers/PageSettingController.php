<?php

namespace App\Http\Controllers;

use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingController extends Controller
{
    /**
     * Get page settings for the specified page
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings(Request $request)
    {
        $page = $request->query('page', 'homepage');
        $settings = PageSetting::getPageSettings($page);
        
        // Format settings for the frontend
        $formattedSettings = [];
        
        foreach ($settings as $setting) {
            $formattedSettings[$setting->section_name] = [
                'enabled' => $setting->is_enabled,
                'settings' => $setting->settings
            ];
        }
        
        return response()->json([
            'success' => true,
            'settings' => $formattedSettings
        ]);
    }
    
    /**
     * Save page settings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSettings(Request $request)
    {
        $page = $request->input('page', 'homepage');
        $settings = $request->input('settings', []);
        
        try {
            // Process hero section
            if (isset($settings['hero'])) {
                $heroSettings = null;
                
                if (isset($settings['hero']['settings'])) {
                    $heroSettings = [
                        'title' => $settings['hero']['settings']['title'] ?? '',
                        'subtitle' => $settings['hero']['settings']['subtitle'] ?? '',
                        'backgroundImage' => $settings['hero']['settings']['backgroundImage'] ?? '',
                        'buttonText' => $settings['hero']['settings']['buttonText'] ?? '',
                        'buttonLink' => $settings['hero']['settings']['buttonLink'] ?? ''
                    ];
                }
                
                PageSetting::updateOrCreate(
                    [
                        'page_name' => $page,
                        'section_name' => 'hero'
                    ],
                    [
                        'is_enabled' => $settings['hero']['enabled'] ?? true,
                        'settings' => $heroSettings
                    ]
                );
            }
            
            // Process categories section
            if (isset($settings['categories'])) {
                $categorySettings = null;
                
                if (isset($settings['categories']['settings'])) {
                    $categorySettings = [
                        'title' => $settings['categories']['settings']['title'] ?? 'SHOP BY CATEGORY',
                        'items' => $settings['categories']['settings']['items'] ?? []
                    ];
                }
                
                PageSetting::updateOrCreate(
                    [
                        'page_name' => $page,
                        'section_name' => 'categories'
                    ],
                    [
                        'is_enabled' => $settings['categories']['enabled'] ?? true,
                        'settings' => $categorySettings
                    ]
                );
            }
            
            // Process featured section
            if (isset($settings['featured'])) {
                $featuredSettings = null;
                
                if (isset($settings['featured']['settings'])) {
                    $featuredSettings = [
                        'items' => $settings['featured']['settings']['items'] ?? []
                    ];
                }
                
                PageSetting::updateOrCreate(
                    [
                        'page_name' => $page,
                        'section_name' => 'featured'
                    ],
                    [
                        'is_enabled' => $settings['featured']['enabled'] ?? true,
                        'settings' => $featuredSettings
                    ]
                );
            }
            
            // Process mission section
            if (isset($settings['mission'])) {
                $missionSettings = null;
                
                if (isset($settings['mission']['settings'])) {
                    $missionSettings = [
                        'title' => $settings['mission']['settings']['title'] ?? '',
                        'backgroundImage' => $settings['mission']['settings']['backgroundImage'] ?? '',
                        'buttonText' => $settings['mission']['settings']['buttonText'] ?? '',
                        'buttonLink' => $settings['mission']['settings']['buttonLink'] ?? ''
                    ];
                }
                
                PageSetting::updateOrCreate(
                    [
                        'page_name' => $page,
                        'section_name' => 'mission'
                    ],
                    [
                        'is_enabled' => $settings['mission']['enabled'] ?? true,
                        'settings' => $missionSettings
                    ]
                );
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Settings saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving settings: ' . $e->getMessage()
            ], 500);
        }
    }
} 