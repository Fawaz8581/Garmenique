<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSetting;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get contact page settings
        $contactSettings = PageSetting::where('page_name', 'contact')->get();
        
        // Format settings for easier access in the view
        $settings = [
            'hero' => [
                'title' => 'CONTACT US',
                'subtitle' => "Let's talk about your question",
                'description' => "Drop us a line through the form below and we'll get back to you"
            ],
            'form' => [
                'messagePlaceholder' => "Your message...",
                'buttonText' => "SEND"
            ],
            'info' => [
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
            ]
        ];
        
        // Override with saved settings if available
        foreach ($contactSettings as $setting) {
            if (strpos($setting->section_name, 'contact.') === 0) {
                $section = str_replace('contact.', '', $setting->section_name);
                
                // Decode JSON settings if needed
                $settingData = $setting->settings;
                if (is_string($settingData)) {
                    $settingData = json_decode($settingData, true);
                }
                
                if ($section === 'hero' && !empty($settingData)) {
                    if (!empty($settingData['title'])) {
                        $settings['hero']['title'] = $settingData['title'];
                    }
                    if (!empty($settingData['subtitle'])) {
                        $settings['hero']['subtitle'] = $settingData['subtitle'];
                    }
                    if (!empty($settingData['description'])) {
                        $settings['hero']['description'] = $settingData['description'];
                    }
                }
                
                if ($section === 'form' && !empty($settingData)) {
                    if (!empty($settingData['messagePlaceholder'])) {
                        $settings['form']['messagePlaceholder'] = $settingData['messagePlaceholder'];
                    }
                    if (!empty($settingData['buttonText'])) {
                        $settings['form']['buttonText'] = $settingData['buttonText'];
                    }
                }
                
                if ($section === 'info' && !empty($settingData)) {
                    if (!empty($settingData['address'])) {
                        if (!empty($settingData['address']['line1'])) {
                            $settings['info']['address']['line1'] = $settingData['address']['line1'];
                        }
                        if (!empty($settingData['address']['line2'])) {
                            $settings['info']['address']['line2'] = $settingData['address']['line2'];
                        }
                    }
                    if (!empty($settingData['email'])) {
                        $settings['info']['email'] = $settingData['email'];
                    }
                    if (!empty($settingData['phone'])) {
                        $settings['info']['phone'] = $settingData['phone'];
                    }
                    if (!empty($settingData['hours'])) {
                        if (!empty($settingData['hours']['weekdays'])) {
                            $settings['info']['hours']['weekdays'] = $settingData['hours']['weekdays'];
                        }
                        if (!empty($settingData['hours']['weekends'])) {
                            $settings['info']['hours']['weekends'] = $settingData['hours']['weekends'];
                        }
                    }
                }
            }
        }
        
        return view('contact', [
            'contactSettings' => $settings
        ]);
    }

    /**
     * Submit the contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);
        
        // Process the contact form submission
        // For now, just return success
        return response()->json(['success' => true]);
    }
}
