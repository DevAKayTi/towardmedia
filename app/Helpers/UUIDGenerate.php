<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Support\Str;


class UUIDGenerate
{
    public static function slug($slug)
    {
        $tempSlug = $slug;
        $randomSlug = $tempSlug . '-' . mt_rand(100000, 999999);

        if (Post::where('slug', $randomSlug)->exists()) {
            self::slug($tempSlug);
        }
        return $randomSlug;
    }
}
