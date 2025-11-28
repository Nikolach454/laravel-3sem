<?php

namespace App\Jobs;

use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Article $article
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Получаем роль модератора
        $moderatorRole = Role::where('name', 'moderator')->first();

        if ($moderatorRole) {
            $moderators = $moderatorRole->users;

            // Отправляем email каждому модератору
            foreach ($moderators as $moderator) {
                try {
                    Mail::to($moderator->email)->send(new NewArticleNotification($this->article));
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }
        }
    }
}
