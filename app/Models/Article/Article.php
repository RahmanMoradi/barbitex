<?php

namespace App\Models\Article;

use App\Models\Admin\Admin;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class Article extends Model
{
    use HasFactory, Sluggable, ArticleEvent;

    protected $guarded = ['id'];
    protected $appends = ['image_url', 'short_body', 'created_at_fa'];

    public function user()
    {
        return $this->belongsTo(Admin::class);
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }

    public function getShortBodyAttribute()
    {
        return Str::limit(str_replace('&nbsp;', '', strip_tags($this->body)));
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->created_at)->ago();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
