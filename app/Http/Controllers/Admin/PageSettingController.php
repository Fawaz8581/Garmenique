<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
                } elseif ($sectionName === 'contact' && isset($sectionData)) {
                    // Handle contact settings which have a nested structure
                    $processedSettings = [];
                    
                    // Process contact hero section
                    if (isset($sectionData['hero'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'contact.hero'
                            ],
                            [
                                'settings' => $sectionData['hero']['settings'] ?? null,
                                'is_enabled' => $sectionData['hero']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process contact form section
                    if (isset($sectionData['form'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'contact.form'
                            ],
                            [
                                'settings' => $sectionData['form']['settings'] ?? null,
                                'is_enabled' => $sectionData['form']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process contact info section
                    if (isset($sectionData['info'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'contact.info'
                            ],
                            [
                                'settings' => $sectionData['info']['settings'] ?? [
                                    'address' => [
                                        'line1' => '123 Main St',
                                        'line2' => 'Suite 404'
                                    ],
                                    'email' => 'info@garmenique.com',
                                    'phone' => '+1 (555) 123-4567',
                                    'hours' => [
                                        'weekdays' => '9:00 AM - 5:00 PM',
                                        'weekends' => '10:00 AM - 3:00 PM'
                                    ]
                                ],
                                'is_enabled' => $sectionData['info']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Skip the main foreach loop's PageSetting::updateOrCreate for 'contact'
                    continue;
                } elseif ($sectionName === 'about' && isset($sectionData)) {
                    // Handle about settings which have a nested structure
                    $processedSettings = [];
                    
                    // Process about hero section
                    if (isset($sectionData['hero'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.hero'
                            ],
                            [
                                'settings' => [
                                    'title' => $sectionData['hero']['settings']['title'] ?? null,
                                    'subtitle' => $sectionData['hero']['settings']['subtitle'] ?? null,
                                    'backgroundImage' => $sectionData['hero']['settings']['backgroundImage'] ?? null
                                ],
                                'is_enabled' => $sectionData['hero']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about ethical approach section
                    if (isset($sectionData['ethicalApproach'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.ethicalApproach'
                            ],
                            [
                                'settings' => $sectionData['ethicalApproach']['settings'] ?? null,
                                'is_enabled' => $sectionData['ethicalApproach']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about designed to last section
                    if (isset($sectionData['designedToLast'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.designedToLast'
                            ],
                            [
                                'settings' => $sectionData['designedToLast']['settings'] ?? [
                                    'title' => 'Designed to last',
                                    'description' => 'We design our garments with longevity in mind, using high-quality materials and timeless designs. Our products are meant to be worn for years, not seasons, reducing the need for constant replacement and minimizing waste.',
                                    'images' => [
                                        [
                                            'url' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                            'alt' => 'Clothing Rack'
                                        ],
                                        [
                                            'url' => 'https://images.unsplash.com/photo-1523380677598-64d85d015339?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80',
                                            'alt' => 'Colorful Textile'
                                        ]
                                    ]
                                ],
                                'is_enabled' => $sectionData['designedToLast']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about transparent section
                    if (isset($sectionData['transparent'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.transparent'
                            ],
                            [
                                'settings' => $sectionData['transparent']['settings'] ?? null,
                                'is_enabled' => $sectionData['transparent']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about experts section
                    if (isset($sectionData['experts'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.experts'
                            ],
                            [
                                'settings' => $sectionData['experts']['settings'] ?? null,
                                'is_enabled' => $sectionData['experts']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about explore section
                    if (isset($sectionData['explore'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.explore'
                            ],
                            [
                                'settings' => $sectionData['explore']['settings'] ?? null,
                                'is_enabled' => $sectionData['explore']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Process about factory images section
                    if (isset($sectionData['factoryImages'])) {
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'about.factoryImages'
                            ],
                            [
                                'settings' => $sectionData['factoryImages']['settings'] ?? null,
                                'is_enabled' => $sectionData['factoryImages']['enabled'] ?? true
                            ]
                        );
                    }
                    
                    // Skip the main foreach loop's PageSetting::updateOrCreate for 'about'
                    continue;
                } elseif ($sectionName === 'products_detailed' && isset($sectionData)) {
                    // Handle products_detailed settings which have a nested structure
                    $processedSettings = [];
                    
                    \Log::debug('Processing products_detailed settings', ['data' => $sectionData]);
                    
                    // Process products_detailed features section
                    if (isset($sectionData['features'])) {
                        \Log::debug('Processing products_detailed features', ['features' => $sectionData['features']]);
                        
                        // Make sure we have the correct structure for the settings
                        $featureSettings = isset($sectionData['features']['settings']) ? $sectionData['features']['settings'] : [];
                        
                        // If items is not set in settings but directly in features, move it to settings
                        if (!isset($featureSettings['items']) && isset($sectionData['features']['items'])) {
                            $featureSettings['items'] = $sectionData['features']['items'];
                        }
                        
                        PageSetting::updateOrCreate(
                            [
                                'page_name' => $page,
                                'section_name' => 'products_detailed.features'
                            ],
                            [
                                'settings' => $featureSettings,
                                'is_enabled' => $sectionData['features']['enabled'] ?? true
                            ]
                        );
                        
                        \Log::debug('Saved products_detailed features', ['settings' => $featureSettings]);
                    }
                    
                    // Skip the main foreach loop's PageSetting::updateOrCreate for 'products_detailed'
                    continue;
                } elseif ($sectionName === 'footer' && isset($sectionData)) {
                    // Handle footer settings
                    $processedSettings = [
                        'columns' => [
                            'shopping' => [
                                'title' => $sectionData['settings']['columns']['shopping']['title'] ?? 'Shopping',
                                'links' => $sectionData['settings']['columns']['shopping']['links'] ?? [
                                    ['text' => 'Shop All', 'url' => '/catalog'],
                                    ['text' => 'T-Shirts', 'url' => '/catalog?category=t-shirts'],
                                    ['text' => 'Jeans', 'url' => '/catalog?category=jeans'],
                                    ['text' => 'Dresses', 'url' => '/catalog?category=dresses'],
                                    ['text' => 'Outerwear', 'url' => '/catalog?category=outerwear'],
                                    ['text' => 'Accessories', 'url' => '/catalog?category=accessories']
                                ]
                            ],
                            'information' => [
                                'title' => $sectionData['settings']['columns']['information']['title'] ?? 'Information',
                                'links' => $sectionData['settings']['columns']['information']['links'] ?? [
                                    ['text' => 'About Us', 'url' => '/about'],
                                    ['text' => 'Contact Us', 'url' => '/contact'],
                                    ['text' => 'Blog', 'url' => '/blog'],
                                    ['text' => 'Shipping & Returns', 'url' => '/shipping'],
                                    ['text' => 'Privacy Policy', 'url' => '/privacy-policy'],
                                    ['text' => 'Terms & Conditions', 'url' => '/terms']
                                ]
                            ],
                            'account' => [
                                'title' => $sectionData['settings']['columns']['account']['title'] ?? 'Account',
                                'links' => $sectionData['settings']['columns']['account']['links'] ?? [
                                    ['text' => 'Login / Register', 'url' => '/login'],
                                    ['text' => 'My Account', 'url' => '/account/settings'],
                                    ['text' => 'Order History', 'url' => '/account/orders'],
                                    ['text' => 'Shopping Cart', 'url' => '/cart']
                                ]
                            ],
                            'contact' => [
                                'title' => $sectionData['settings']['columns']['contact']['title'] ?? 'Get In Touch',
                                'address' => $sectionData['settings']['columns']['contact']['address'] ?? '123 Fashion Street, New York, NY',
                                'phone' => $sectionData['settings']['columns']['contact']['phone'] ?? '+1 (555) 123-4567',
                                'email' => $sectionData['settings']['columns']['contact']['email'] ?? 'contact@garmenique.com'
                            ]
                        ],
                        'social' => [
                            'facebook' => $sectionData['settings']['social']['facebook'] ?? '#',
                            'instagram' => $sectionData['settings']['social']['instagram'] ?? '#',
                            'twitter' => $sectionData['settings']['social']['twitter'] ?? '#',
                            'pinterest' => $sectionData['settings']['social']['pinterest'] ?? '#'
                        ],
                        'copyright' => $sectionData['settings']['copyright'] ?? '© 2025 Garmenique. All Rights Reserved.'
                    ];
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
            } 
            // Handle nested about settings
            else if (strpos($setting->section_name, 'about.') === 0) {
                $aboutSection = str_replace('about.', '', $setting->section_name);
                if (!isset($formattedSettings['about'])) {
                    $formattedSettings['about'] = [];
                }
                $formattedSettings['about'][$aboutSection] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
            }
            // Handle nested contact settings
            else if (strpos($setting->section_name, 'contact.') === 0) {
                $contactSection = str_replace('contact.', '', $setting->section_name);
                if (!isset($formattedSettings['contact'])) {
                    $formattedSettings['contact'] = [];
                }
                $formattedSettings['contact'][$contactSection] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
            }
            // Handle nested products_detailed settings
            else if (strpos($setting->section_name, 'products_detailed.') === 0) {
                $productsDetailedSection = str_replace('products_detailed.', '', $setting->section_name);
                \Log::debug('Found products_detailed setting', [
                    'section' => $productsDetailedSection, 
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ]);
                
                if (!isset($formattedSettings['products_detailed'])) {
                    $formattedSettings['products_detailed'] = [];
                }
                $formattedSettings['products_detailed'][$productsDetailedSection] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
                
                \Log::debug('Formatted products_detailed settings', [
                    'formatted' => $formattedSettings['products_detailed']
                ]);
            }
            else {
                $formattedSettings[$setting->section_name] = [
                    'enabled' => $setting->is_enabled,
                    'settings' => $setting->settings
                ];
            }
        }
        
        return response()->json(['success' => true, 'settings' => $formattedSettings]);
    }
}
