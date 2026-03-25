@extends('layouts.bootstrap')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <article>
            <h1 class="mb-3">{{ $article->title }}</h1>
            <div class="text-muted mb-4">
                {{ $article->created_at->format('d.m.Y H:i') }}
            </div>

            @if($article->image)
                <img src="{{ $article->image }}" class="img-fluid rounded mb-4" alt="{{ $article->title }}">
            @endif

            <div class="article-content" style="white-space: pre-wrap;">{{ $article->content }}</div>

            <hr class="my-5">

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">Назад к списку</a>
                <div class="btn-group">
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning">Редактировать</a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Вы уверены?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    @endcan
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
