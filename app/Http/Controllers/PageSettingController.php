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
            
            // Process about page sections
            if ($page === 'about') {
                // Process about hero section
                if (isset($settings['about']['hero'])) {
                    $heroSettings = null;
                    
                    if (isset($settings['about']['hero']['settings'])) {
                        $heroSettings = [
                            'title' => $settings['about']['hero']['settings']['title'] ?? '',
                            'subtitle' => $settings['about']['hero']['settings']['subtitle'] ?? '',
                            'backgroundImage' => $settings['about']['hero']['settings']['backgroundImage'] ?? ''
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.hero'
                        ],
                        [
                            'is_enabled' => $settings['about']['hero']['enabled'] ?? true,
                            'settings' => $heroSettings
                        ]
                    );
                }
                
                // Process ethical approach section
                if (isset($settings['about']['ethicalApproach'])) {
                    $ethicalSettings = null;
                    
                    if (isset($settings['about']['ethicalApproach']['settings'])) {
                        $ethicalSettings = [
                            'title' => $settings['about']['ethicalApproach']['settings']['title'] ?? '',
                            'description' => $settings['about']['ethicalApproach']['settings']['description'] ?? '',
                            'image' => $settings['about']['ethicalApproach']['settings']['image'] ?? ''
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.ethicalApproach'
                        ],
                        [
                            'is_enabled' => $settings['about']['ethicalApproach']['enabled'] ?? true,
                            'settings' => $ethicalSettings
                        ]
                    );
                }
                
                // Process designed to last section
                if (isset($settings['about']['designedToLast'])) {
                    $designedSettings = null;
                    
                    if (isset($settings['about']['designedToLast']['settings'])) {
                        $designedSettings = [
                            'title' => $settings['about']['designedToLast']['settings']['title'] ?? '',
                            'description' => $settings['about']['designedToLast']['settings']['description'] ?? '',
                            'images' => $settings['about']['designedToLast']['settings']['images'] ?? []
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.designedToLast'
                        ],
                        [
                            'is_enabled' => $settings['about']['designedToLast']['enabled'] ?? true,
                            'settings' => $designedSettings
                        ]
                    );
                }
                
                // Process transparent section
                if (isset($settings['about']['transparent'])) {
                    $transparentSettings = null;
                    
                    if (isset($settings['about']['transparent']['settings'])) {
                        $transparentSettings = [
                            'title' => $settings['about']['transparent']['settings']['title'] ?? '',
                            'description' => $settings['about']['transparent']['settings']['description'] ?? '',
                            'colors' => $settings['about']['transparent']['settings']['colors'] ?? []
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.transparent'
                        ],
                        [
                            'is_enabled' => $settings['about']['transparent']['enabled'] ?? true,
                            'settings' => $transparentSettings
                        ]
                    );
                }
                
                // Process explore section
                if (isset($settings['about']['explore'])) {
                    $exploreSettings = null;
                    
                    if (isset($settings['about']['explore']['settings'])) {
                        $exploreSettings = [
                            'title' => $settings['about']['explore']['settings']['title'] ?? '',
                            'categories' => $settings['about']['explore']['settings']['categories'] ?? []
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.explore'
                        ],
                        [
                            'is_enabled' => $settings['about']['explore']['enabled'] ?? true,
                            'settings' => $exploreSettings ? json_encode($exploreSettings) : null
                        ]
                    );
                }
                
                // Process factory images section
                if (isset($settings['about']['factoryImages'])) {
                    $factoryImagesSettings = null;
                    
                    if (isset($settings['about']['factoryImages']['settings'])) {
                        $factoryImagesSettings = [
                            'title' => $settings['about']['factoryImages']['settings']['title'] ?? '',
                            'description' => $settings['about']['factoryImages']['settings']['description'] ?? '',
                            'images' => $settings['about']['factoryImages']['settings']['images'] ?? []
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'about.factoryImages'
                        ],
                        [
                            'is_enabled' => $settings['about']['factoryImages']['enabled'] ?? true,
                            'settings' => $factoryImagesSettings ? json_encode($factoryImagesSettings) : null
                        ]
                    );
                }
            }
            
            // Contact page settings
            if ($page === 'contact' && isset($settings['contact'])) {
                // Process hero section
                if (isset($settings['contact']['hero'])) {
                    $heroSettings = null;
                    
                    if (isset($settings['contact']['hero']['settings'])) {
                        $heroSettings = [
                            'title' => $settings['contact']['hero']['settings']['title'] ?? '',
                            'subtitle' => $settings['contact']['hero']['settings']['subtitle'] ?? '',
                            'description' => $settings['contact']['hero']['settings']['description'] ?? ''
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'contact.hero'
                        ],
                        [
                            'is_enabled' => $settings['contact']['hero']['enabled'] ?? true,
                            'settings' => $heroSettings ? json_encode($heroSettings) : null
                        ]
                    );
                }
                
                // Process form section
                if (isset($settings['contact']['form'])) {
                    $formSettings = null;
                    
                    if (isset($settings['contact']['form']['settings'])) {
                        $formSettings = [
                            'messagePlaceholder' => $settings['contact']['form']['settings']['messagePlaceholder'] ?? '',
                            'buttonText' => $settings['contact']['form']['settings']['buttonText'] ?? ''
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'contact.form'
                        ],
                        [
                            'is_enabled' => $settings['contact']['form']['enabled'] ?? true,
                            'settings' => $formSettings ? json_encode($formSettings) : null
                        ]
                    );
                }
                
                // Process info section
                if (isset($settings['contact']['info'])) {
                    $infoSettings = null;
                    
                    if (isset($settings['contact']['info']['settings'])) {
                        $infoSettings = [
                            'address' => [
                                'line1' => $settings['contact']['info']['settings']['address']['line1'] ?? '',
                                'line2' => $settings['contact']['info']['settings']['address']['line2'] ?? ''
                            ],
                            'email' => $settings['contact']['info']['settings']['email'] ?? '',
                            'phone' => $settings['contact']['info']['settings']['phone'] ?? '',
                            'hours' => [
                                'weekdays' => $settings['contact']['info']['settings']['hours']['weekdays'] ?? '',
                                'weekends' => $settings['contact']['info']['settings']['hours']['weekends'] ?? ''
                            ]
                        ];
                    }
                    
                    PageSetting::updateOrCreate(
                        [
                            'page_name' => $page,
                            'section_name' => 'contact.info'
                        ],
                        [
                            'is_enabled' => $settings['contact']['info']['enabled'] ?? true,
                            'settings' => $infoSettings ? json_encode($infoSettings) : null
                        ]
                    );
                }
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