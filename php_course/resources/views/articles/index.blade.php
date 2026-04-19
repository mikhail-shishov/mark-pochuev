@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Статьи</h1>
    <div class="d-flex align-items-center">
        <input type="text" id="article-search" class="form-control me-3" placeholder="Поиск по статьям..." style="width: 250px;">
        @can('create', App\Models\Article::class)
            <a href="{{ route('articles.create') }}" class="btn btn-primary" data-bs-toggle="tooltip" title="Написать новую статью">Создать статью</a>
        @endcan
    </div>
</div>

@if($articles->count() > 0)
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card article-card h-100 shadow-sm">
                    @if($article->image)
                        <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $article->title }}</h5>
                        <p class="card-text text-muted" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $article->content }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between align-items-center">
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-outline-primary">Читать</a>
                        <div class="btn-group">
                            @can('update', $article)
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary">Редактировать</a>
                            @endcan
                            @can('delete', $article)
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" data-confirm-message="Удалить статью «{{ $article->title }}»?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Внимание! Это действие необратимо">Удалить</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">Пока нет ни одной статьи.</div>
@endif

@if(isset($pokemon))
    <div class="mt-5 p-4 border rounded shadow-sm bg-body-tertiary">
        <h3 class="mb-3">Случайный покемон из внешнего PokeAPI</h3>
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ $pokemon['sprites']['front_default'] ?? '' }}" alt="{{ $pokemon['name'] }}" style="width: 150px;">
            </div>
            <div class="col">
                <h4 class="text-capitalize">{{ $pokemon['name'] }}</h4>
                <p class="mb-1"><strong>Тип:</strong>
                    @foreach($pokemon['types'] as $type)
                        <span class="badge bg-primary">{{ $type['type']['name'] }}</span>
                    @endforeach
                </p>
                <p class="mb-1"><strong>Вес:</strong> {{ $pokemon['weight'] / 10 }} кг</p>
                <p class="mb-0"><strong>Рост:</strong> {{ $pokemon['height'] / 10 }} м</p>
            </div>
        </div>
    </div>
@endif
@endsection
