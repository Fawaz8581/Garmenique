<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageSettingController extends Controller
{
    /**
     * Display the page customization interface.
     *
     * @param  string  $page
     * @return \Illuminate\View\View
     */
    public function index($page = 'homepage')
    {
        // Get all settings for the specified page
        $settings = PageSetting::getPageSettings($page);
        
        // Convert settings to a more usable format
        $formattedSettings = [];
        foreach ($settings as $setting) {
            $formattedSettings[$setting->section_name] = [
                'enabled' => $setting->is_enabled,
                'settings' => $setting->settings
            ];
        }
        
        return view('admin.customizes', [
            'page' => $page,
            'settings' => $formattedSettings
        ]);
    }

    /**
     * Save the page settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string',
            'settings' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->input('page');
        $settings = $request->input('settings');

        try {
            foreach ($settings as $sectionName => $sectionData) {
                // Process settings based on section
                $processedSettings = null;
                
                if ($sectionName === 'hero' && isset($sectionData['settings'])) {
                    $processedSettings = [
                        'title' => $sectionData['settings']['title'] ?? '',
                        'subtitle' => $sectionData['settings']['subtitle'] ?? '',
                        'backgroundImage' => $sectionData['settings']['backgroundImage'] ?? '',
                        'buttonText' => $sectionData['settings']['buttonText'] ?? '',
                        'buttonLink' => $sectionData['settings']['buttonLink'] ?? ''
                    ];
                } elseif ($sectionName === 'categories' && isset($sectionData['settings'])) {
                    $processedSettings = [
                        'title' => $sectionData['settings']['title'] ?? 'SHOP BY CATEGORY',
                        'items' => $sectionData['settings']['items'] ?? []
                    ];
                } elseif ($sectionName === 'featured' && isset($sectionData['settings'])) {
                    $processedSettings = [
                        'items' => $sectionData['settings']['items'] ?? []
                    ];
                } elseif ($sectionName === 'mission' && isset($sectionData['settings'])) {
                    $processedSettings = [
                        'title' => $sectionData['settings']['title'] ?? '',
                        'backgroundImage' => $sectionData['settings']['backgroundImage'] ?? '',
                        'buttonText' => $sectionData['settings']['buttonText'] ?? '',
                        'buttonLink' => $sectionData['settings']['buttonLink'] ?? ''
                    ];
                } elseif ($sectionName === 'blog' && isset($sectionData)) {
                    // Handle blog settings which have a nested structure
                    $processedSettings = [];
                    
                    // Process blog hero section
                    if (isset($sectionData['hero'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'blog.hero'
                            ],
                            [
                                'settings' => $sectionData['hero']['settings'] ?? null,
                                'is_enabled' => $sectionData['hero']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process blog latest articles section
                    if (isset($sectionData['latestArticles'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'blog.latestArticles'
                            ],
                            [
                                'settings' => $sectionData['latestArticles']['settings'] ?? null,
                                'is_enabled' => $sectionData['latestArticles']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process blog values section
                    if (isset($sectionData['values'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'blog.values'
                            ],
                            [
                                'settings' => $sectionData['values']['settings'] ?? null,
                                'is_enabled' => $sectionData['values']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process blog progress section
                    if (isset($sectionData['progress'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'blog.progress'
                            ],
                            [
                                'settings' => $sectionData['progress']['settings'] ?? null,
                                'is_enabled' => $sectionData['progress']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process blog social section
                    if (isset($sectionData['social'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'blog.social'
                            ],
                            [
                                'settings' => $sectionData['social']['settings'] ?? null,
                                'is_enabled' => $sectionData['social']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Skip the main foreach loop's PageSetting::updateOrCreate for 'blog'
                    continue;
                } else {
                    $processedSettings = $sectionData['settings'] ?? null;
                }
                
                PageSetting::updateOrCreate(
                    [
                        'page_name' => $page,
                        'section_name' => $sectionName
                    ],
                    [
                        'settings' => $processedSettings,
                        'is_enabled' => $sectionData['enabled'] ?? true
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Settings saved successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error saving settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the settings for a specific page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings(Request $request)
    {
        $page = $request->input('page', 'homepage');
        $settings = PageSetting::where('page_name', $page)->get();
        
        $formattedSettings = [];
        foreach ($settings as $setting) {
            // Handle nested blog settings
            if (strpos($setting->section_name, 'blog.') === 0) {
                $blogSection = str_replace('blog.', '', $setting->section_name);
                if (!isset($formattedSettings['blog'])) {
                    $formattedSettings['blog'] = [];
                }
                $formattedSettings['blog'][$blogSection] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
            } else {
                $formattedSettings[$setting->section_name] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
            }
        }
        
        return response()->json(['success' => true, 'settings' => $formattedSettings]);
    }
}
