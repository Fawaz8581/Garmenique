<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class AboutController extends Controller
{
    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get about page settings
        $aboutSettings = PageSetting::where('page_name', 'about')->get();
        
        // Format settings for easier access in the view
        $settings = [
            'about' => [
                'hero' => [
                    'enabled' => true,
                    'title' => 'WE BELIEVE WE CAN ALL MAKE A DIFFERENCE',
                    'subtitle' => 'We\'re on a mission to create beautiful, durable clothing while minimizing our environmental impact and maximizing our positive social impact. We believe in transparency, ethical practices, and creating garments that stand the test of time.',
                    'backgroundImage' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80'
                ],
                'ethicalApproach' => [
                    'enabled' => true,
                    'title' => 'Our ethical approach',
                    'description' => 'We partner with ethical factories around the world, ensuring safe working conditions and fair wages for all workers involved in creating our garments. We believe that quality clothing starts with quality treatment of the people who make it.',
                    'image' => 'https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80'
                ],
                'factoryImages' => [
                    'enabled' => true,
                    'images' => [
                        [
                            'url' => 'https://images.unsplash.com/photo-1525171254930-643fc658b64e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                            'alt' => 'Factory detail'
                        ],
                        [
                            'url' => 'https://images.unsplash.com/photo-1675176785803-bffbbb0cd2f4?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Z2FybWVudCUyMGZhY3Rvcnl8ZW58MHx8MHx8fDA%3D',
                            'alt' => 'Worker closeup'
                        ]
                    ]
                ],
                'designedToLast' => [
                    'enabled' => true,
                    'title' => 'Designed to last',
                    'description' => 'We design our garments with longevity in mind, using high-quality materials and timeless designs. Our products are meant to be worn for years, not seasons, reducing the need for constant replacement and minimizing waste.',
                    'images' => [
                        [
                            'url' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'alt' => 'Clothing Rack'
                        ],
                        [
                            'url' => 'https://images.unsplash.com/photo-1523380677598-64d85d015339?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                            'alt' => 'Colorful Textile'
                        ]
                    ]
                ],
                'transparent' => [
                    'enabled' => true,
                    'title' => 'Radically Transparent',
                    'description' => 'We believe in full transparency about our materials, costs, and manufacturing processes. We want you to know exactly what goes into making your clothes and why they cost what they do.',
                    'colors' => [
                        ['hex' => '#E6D9B8'],
                        ['hex' => '#999999']
                    ]
                ],
                'explore' => [
                    'enabled' => true,
                    'title' => 'Meet our Explore',
                    'categories' => [
                        [
                            'title' => 'Fabric Selection',
                            'image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                        ],
                        [
                            'title' => 'Design Process',
                            'image' => 'https://images.unsplash.com/photo-1604881988758-f76ad2f7aac1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                        ],
                        [
                            'title' => 'Production',
                            'image' => 'https://images.unsplash.com/photo-1581873372796-635b67ca2008?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                        ],
                        [
                            'title' => 'Quality Control',
                            'image' => 'https://images.unsplash.com/photo-1617419250411-98aa962b070f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                        ]
                    ]
                ]
            ]
        ];
        
        // Override with saved settings if available
        foreach ($aboutSettings as $setting) {
            if (strpos($setting->section_name, 'about.') === 0) {
                $section = str_replace('about.', '', $setting->section_name);
                
                // Set enabled status
                $settings['about'][$section]['enabled'] = $setting->is_enabled;
                
                // Override settings based on section
                if (!empty($setting->settings)) {
                    switch ($section) {
                        case 'hero':
                            if (!empty($setting->settings['title'])) {
                                $settings['about']['hero']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['subtitle'])) {
                                $settings['about']['hero']['subtitle'] = $setting->settings['subtitle'];
                            }
                            if (!empty($setting->settings['backgroundImage'])) {
                                $settings['about']['hero']['backgroundImage'] = $setting->settings['backgroundImage'];
                            }
                            break;
                            
                        case 'ethicalApproach':
                            if (!empty($setting->settings['title'])) {
                                $settings['about']['ethicalApproach']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['description'])) {
                                $settings['about']['ethicalApproach']['description'] = $setting->settings['description'];
                            }
                            if (!empty($setting->settings['image'])) {
                                $settings['about']['ethicalApproach']['image'] = $setting->settings['image'];
                            }
                            break;
                            
                        case 'factoryImages':
                            if (!empty($setting->settings['images'])) {
                                $settings['about']['factoryImages']['images'] = $setting->settings['images'];
                            }
                            break;
                            
                        case 'designedToLast':
                            if (!empty($setting->settings['title'])) {
                                $settings['about']['designedToLast']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['description'])) {
                                $settings['about']['designedToLast']['description'] = $setting->settings['description'];
                            }
                            if (!empty($setting->settings['images'])) {
                                $settings['about']['designedToLast']['images'] = $setting->settings['images'];
                            }
                            break;
                            
                        case 'transparent':
                            if (!empty($setting->settings['title'])) {
                                $settings['about']['transparent']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['description'])) {
                                $settings['about']['transparent']['description'] = $setting->settings['description'];
                            }
                            if (!empty($setting->settings['colors'])) {
                                $settings['about']['transparent']['colors'] = $setting->settings['colors'];
                            }
                            break;
                            
                        case 'explore':
                            if (!empty($setting->settings['title'])) {
                                $settings['about']['explore']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['categories'])) {
                                $settings['about']['explore']['categories'] = $setting->settings['categories'];
                            }
                            break;
                    }
                }
            }
        }
        
        return view('about', [
            'pageSettings' => $settings
        ]);
    }
} 