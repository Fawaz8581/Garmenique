<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class BlogController extends Controller
{
    /**
     * Display the blog page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get blog page settings
        $blogSettings = PageSetting::where('page_name', 'blog')->get();
        
        // Format settings for easier access in the view
        $settings = [
            'blog' => [
                'hero' => [
                    'enabled' => true,
                    'title' => 'GARMENIQUE BLOG',
                    'subtitle' => 'Discover the latest trends, sustainability initiatives, and behind-the-scenes stories from our team.',
                    'backgroundImage' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'
                ],
                'latestArticles' => [
                    'enabled' => true,
                    'title' => 'Latest Articles',
                    'articles' => [
                        [
                            'title' => 'How To Style Winter Whites',
                            'category' => 'Style',
                            'image' => 'images/blog/winter-white.jpg',
                            'link' => '#'
                        ],
                        [
                            'title' => 'We Won A Glossy Award',
                            'category' => 'Transparency',
                            'image' => 'images/blog/glossy-award.jpg',
                            'link' => '#'
                        ],
                        [
                            'title' => 'Coordinate Your Style: Matching Outfits for Everyone',
                            'category' => 'Style',
                            'image' => 'images/blog/matching-outfits.jpg',
                            'link' => '#'
                        ]
                    ]
                ],
                'regularArticles' => [
                    'enabled' => false,
                    'articles' => []
                ],
                'progressInitiatives' => [
                    'enabled' => true,
                    'title' => 'Our Progress Initiatives',
                    'initiatives' => [
                        [
                            'title' => 'Carbon Commitment',
                            'image' => 'images/blog/carbon-commitment.jpg'
                        ],
                        [
                            'title' => 'Environmental Initiatives',
                            'image' => 'images/blog/environmental.jpg'
                        ],
                        [
                            'title' => 'Better Factories',
                            'image' => 'images/blog/factories.jpg'
                        ]
                    ]
                ]
            ]
        ];
        
        // Override with saved settings if available
        foreach ($blogSettings as $setting) {
            if (strpos($setting->section_name, 'blog.') === 0) {
                $section = str_replace('blog.', '', $setting->section_name);
                
                // Set enabled status
                $settings['blog'][$section]['enabled'] = $setting->is_enabled;
                
                // Override settings based on section
                if (!empty($setting->settings)) {
                    switch ($section) {
                        case 'hero':
                            if (!empty($setting->settings['title'])) {
                                $settings['blog']['hero']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['subtitle'])) {
                                $settings['blog']['hero']['subtitle'] = $setting->settings['subtitle'];
                            }
                            if (!empty($setting->settings['backgroundImage'])) {
                                $settings['blog']['hero']['backgroundImage'] = $setting->settings['backgroundImage'];
                            }
                            break;
                            
                        case 'latestArticles':
                            if (!empty($setting->settings['title'])) {
                                $settings['blog']['latestArticles']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['articles'])) {
                                $settings['blog']['latestArticles']['articles'] = $setting->settings['articles'];
                            }
                            break;
                            
                        case 'regularArticles':
                            if (!empty($setting->settings['articles'])) {
                                $settings['blog']['regularArticles']['articles'] = $setting->settings['articles'];
                            }
                            break;
                            
                        case 'progressInitiatives':
                            if (!empty($setting->settings['title'])) {
                                $settings['blog']['progressInitiatives']['title'] = $setting->settings['title'];
                            }
                            if (!empty($setting->settings['initiatives'])) {
                                $settings['blog']['progressInitiatives']['initiatives'] = $setting->settings['initiatives'];
                            }
                            break;
                    }
                }
            }
        }
        
        // Filter out the specific articles mentioned by the user
        $articlesToRemove = [
            'Black Friday Fund 2023',
            'What to Wear this Season: Holiday Outfits & Ideas',
            'Thanksgiving Outfit Ideas'
        ];
        
        // Filter latest articles
        if (isset($settings['blog']['latestArticles']['articles']) && is_array($settings['blog']['latestArticles']['articles'])) {
            $settings['blog']['latestArticles']['articles'] = array_filter(
                $settings['blog']['latestArticles']['articles'],
                function($article) use ($articlesToRemove) {
                    return !in_array($article['title'], $articlesToRemove);
                }
            );
            // Re-index array
            $settings['blog']['latestArticles']['articles'] = array_values($settings['blog']['latestArticles']['articles']);
        }
        
        // Filter regular articles
        if (isset($settings['blog']['regularArticles']['articles']) && is_array($settings['blog']['regularArticles']['articles'])) {
            $settings['blog']['regularArticles']['articles'] = array_filter(
                $settings['blog']['regularArticles']['articles'],
                function($article) use ($articlesToRemove) {
                    return !in_array($article['title'], $articlesToRemove);
                }
            );
            // Re-index array
            $settings['blog']['regularArticles']['articles'] = array_values($settings['blog']['regularArticles']['articles']);
        }
        
        return view('blog', [
            'pageSettings' => $settings
        ]);
    }
} 