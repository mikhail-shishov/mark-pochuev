<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Collection;

class ArticleService
{
    public function getRelatedArticles(Article $article, int $limit = 3): Collection
    {
        return Article::where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    public function getArticleStats(Article $article): array
    {
        $content = strip_tags($article->content);
        $wordCount = str_word_count($content);
        $charCount = mb_strlen($content);

        return [
            'word_count' => $wordCount,
            'char_count' => $charCount,
            'reading_time' => ceil($wordCount / 200),
        ];
    }
}
