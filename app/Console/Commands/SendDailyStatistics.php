<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyStatistics extends Command
{
    protected $signature = 'statistics:send-daily';

    protected $description = 'Send daily statistics to moderators';

    public function handle()
    {
        $today = Carbon::today();

        $articleViewsCount = ArticleView::whereDate('created_at', $today)->count();

        $newCommentsCount = Comment::whereDate('created_at', $today)->count();

        $recentComments = Comment::whereDate('created_at', $today)
            ->with(['user', 'article'])
            ->get();

        $moderators = User::whereHas('roles', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        if ($moderators->isEmpty()) {
            $this->warn('Нет пользователей с ролью модератор');
            return 1;
        }

        $emailContent = "Ежедневная статистика за " . $today->format('d.m.Y') . "\n\n" .
                        "Количество просмотров статей: " . $articleViewsCount . "\n" .
                        "Количество новых комментариев: " . $newCommentsCount . "\n\n";

        if ($recentComments->isNotEmpty()) {
            $emailContent .= "Новые комментарии:\n" .
                $recentComments->map(function ($comment) {
                    return "- " . $comment->user->name . " к статье \"" . $comment->article->title . "\": " .
                           substr($comment->content, 0, 50) . "...";
                })->implode("\n");
        } else {
            $emailContent .= "Новых комментариев нет.";
        }

        foreach ($moderators as $moderator) {
            try {
                Mail::raw(
                    $emailContent,
                    function ($message) use ($moderator) {
                        $message->to($moderator->email)
                                ->subject('Ежедневная статистика сайта');
                    }
                );
                $this->info("Отправлено на {$moderator->email}");
            } catch (\Exception $e) {
                $this->error("Ошибка отправки на {$moderator->email}: " . $e->getMessage());
            }
        }

        $this->info('Статистика обработана для ' . $moderators->count() . ' модераторов');

        return 0;
    }
}
