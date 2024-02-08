<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Bulletin extends Model
{
    use  HasFactory, LogsActivity, CausesActivity;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Post::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id', 'title'])
            ->useLogName('bulletin');
        // Chain fluent methods for configuration options
    }

    public function getDescriptionForEvent(string $eventName)
    {
        return "Bulletin has been {$eventName} by :causer.name ";
    }

    function photo(): string
    {
        if ($this->articles->last() != null && file_exists('storage/uploads/featured/' . $this->articles->last()->post_thumbnail) ) {
            return asset('storage/uploads/featured/' . $this->articles->last()->post_thumbnail);
        } else {
            return asset('assets/logo/default.jpeg');
        }
    }
}
