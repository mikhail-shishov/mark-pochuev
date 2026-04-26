<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\ActivityLog;

class ArticleObserver
{
    public function created(Article $article): void
    {
        ActivityLog::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'description' => 'Статья была создана',
        ]);
    }

    public function updated(Article $article): void
    {
        $changes = $article->getChanges();
        unset($changes['updated_at']);

        if (empty($changes)) {
            return;
        }

        $description = 'Обновлены поля: ' . implode(', ', array_keys($changes));

        ActivityLog::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'description' => $description,
        ]);
    }
}
