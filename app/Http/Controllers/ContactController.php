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
                
                if ($section === 'hero' && !empty($setting->settings)) {
                    if (!empty($setting->settings['title'])) {
                        $settings['hero']['title'] = $setting->settings['title'];
                    }
                    if (!empty($setting->settings['subtitle'])) {
                        $settings['hero']['subtitle'] = $setting->settings['subtitle'];
                    }
                    if (!empty($setting->settings['description'])) {
                        $settings['hero']['description'] = $setting->settings['description'];
                    }
                }
                
                if ($section === 'form' && !empty($setting->settings)) {
                    if (!empty($setting->settings['messagePlaceholder'])) {
                        $settings['form']['messagePlaceholder'] = $setting->settings['messagePlaceholder'];
                    }
                    if (!empty($setting->settings['buttonText'])) {
                        $settings['form']['buttonText'] = $setting->settings['buttonText'];
                    }
                }
                
                if ($section === 'info' && !empty($setting->settings)) {
                    if (!empty($setting->settings['address'])) {
                        if (!empty($setting->settings['address']['line1'])) {
                            $settings['info']['address']['line1'] = $setting->settings['address']['line1'];
                        }
                        if (!empty($setting->settings['address']['line2'])) {
                            $settings['info']['address']['line2'] = $setting->settings['address']['line2'];
                        }
                    }
                    if (!empty($setting->settings['email'])) {
                        $settings['info']['email'] = $setting->settings['email'];
                    }
                    if (!empty($setting->settings['phone'])) {
                        $settings['info']['phone'] = $setting->settings['phone'];
                    }
                    if (!empty($setting->settings['hours'])) {
                        if (!empty($setting->settings['hours']['weekdays'])) {
                            $settings['info']['hours']['weekdays'] = $setting->settings['hours']['weekdays'];
                        }
                        if (!empty($setting->settings['hours']['weekends'])) {
                            $settings['info']['hours']['weekends'] = $setting->settings['hours']['weekends'];
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
