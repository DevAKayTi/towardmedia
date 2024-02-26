<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\LogOptions;


class Post extends Model
{
    use  HasFactory, LogsActivity, CausesActivity;

    protected $guarded = [];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('post')
            ->logOnly(['id', 'title', 'author.name', 'type.name']);
    }

    public function getDescriptionForEvent(string $eventName)
    {
        return "Post has been {$eventName} by :causer.name ";
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, PostTag::class);
    }

    public function incrementViewCount()
    {
        $this->views++;
        return $this->save();
    }

    function photo()
    {
        if (file_exists('storage/uploads/featured/' . $this->post_thumbnail . '')) {
            return asset('storage/uploads/featured/' . $this->post_thumbnail . '');
        } else {
            return asset('assets/logo/default.jpeg');
        }
    }

    function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
}
