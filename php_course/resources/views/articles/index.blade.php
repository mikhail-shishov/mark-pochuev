@extends('layouts.bootstrap')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Статьи</h1>
    @can('create', App\Models\Article::class)
        <a href="{{ route('articles.create') }}" class="btn btn-primary">Создать статью</a>
    @endcan
</div>

@if($articles->count() > 0)
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
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
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary">Ред.</a>
                            @endcan
                            @can('delete', $article)
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Вы уверены?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удал.</button>
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
@endsection
