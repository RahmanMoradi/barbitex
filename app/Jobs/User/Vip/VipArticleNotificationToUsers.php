<?php

namespace App\Jobs\User\Vip;

use App\Models\Article\Article;
use App\Models\User;
use App\Models\vip\VipUsers;
use App\Notifications\User\SendNotificationToUsers;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VipArticleNotificationToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Article
     */
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        VipUsers::whereDate('expire_at', '>', now())->chunk(1, function ($collect) {
            try {
                $users = User::whereIn('id', $collect->pluck('user_id'))->get();
                Notification::send($users,
                    new SendNotificationToUsers(Str::limit($this->article->title), $this->article->short_body, $this->article->title, '/panel/vip'));
            } catch (\Exception $exception) {
                //
            }
        });
    }
}
