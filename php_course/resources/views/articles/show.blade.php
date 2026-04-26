@extends('layouts.bootstrap')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <article>
            <h1 class="mb-3">{{ $article->title }}</h1>
            <div class="text-muted mb-2">
                Автор: {{ $article->user->name ?? 'Неизвестен' }} |
                {{ $article->created_at->format('d.m.Y H:i') }} |
                <span title="Примерное время чтения">{{ $article->reading_time }} мин.</span>
                <span title="Количество слов">({{ $article->word_count }} слов)</span>
            </div>
            <div class="mb-4">
                @foreach($article->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                @endforeach
            </div>

            @if($article->image)
                <img src="{{ $article->image }}" class="img-fluid rounded mb-4" alt="{{ $article->title }}">
            @endif

            <div class="article-content">{{ $article->html_content }}</div>

            @if($relatedArticles->count() > 0)
                <div class="mt-5 p-4 bg-light rounded shadow-sm">
                    <h4 class="mb-3">Читайте также</h4>
                    <div class="list-group list-group-flush">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('articles.show', $related) }}" class="list-group-item list-group-item-action bg-transparent px-0 d-flex justify-content-between align-items-center">
                                <span>{{ $related->title }}</span>
                                <small class="text-muted">{{ $related->created_at->format('d.m.Y') }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr class="my-5">

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">Назад к списку</a>
                <div class="btn-group">
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning">Редактировать</a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline" data-confirm-message="Удалить статью «{{ $article->title }}»?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Внимание! Это действие необратимо">Удалить</button>
                        </form>
                    @endcan
                </div>
            </div>

            @if(auth()->user()->canManageArticles())
                <div class="mt-5">
                    <h3>История изменений</h3>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Пользователь</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($article->activityLogs as $log)
                                    <tr>
                                        <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $log->user->name ?? 'Система' }}</td>
                                        <td>{{ $log->description }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Истории изменений пока нет</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </article>
    </div>
</div>
@endsection
