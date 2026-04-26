<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getHtmlContentAttribute(): HtmlString
    {
        return new HtmlString(Str::markdown($this->content));
    }

    public function getWordCountAttribute(): int
    {
        return str_word_count(strip_tags($this->content));
    }

    public function getReadingTimeAttribute(): int
    {
        $words = $this->word_count;
        $minutes = ceil($words / 200);

        return (int) ($minutes > 0 ? $minutes : 1);
    }
}
