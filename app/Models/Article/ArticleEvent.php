<?php

namespace App\Models\Article;

use App\Jobs\User\Vip\VipArticleNotificationToUsers;

trait ArticleEvent
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($article) {
            if ($article->vip == 1) {
                VipArticleNotificationToUsers::dispatchNow($article);
            }
        });
    }
}
