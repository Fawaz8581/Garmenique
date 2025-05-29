<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_name',
        'section_name',
        'settings',
        'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'json',
        'is_enabled' => 'boolean',
    ];

    /**
     * Get settings for a specific page
     *
     * @param string $pageName
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPageSettings($pageName)
    {
        return self::where('page_name', $pageName)
                   ->where('is_enabled', true)
                   ->get();
    }

    /**
     * Get a specific section settings
     *
     * @param string $pageName
     * @param string $sectionName
     * @return \App\Models\PageSetting|null
     */
    public static function getSectionSettings($pageName, $sectionName)
    {
        return self::where('page_name', $pageName)
                   ->where('section_name', $sectionName)
                   ->first();
    }
}
