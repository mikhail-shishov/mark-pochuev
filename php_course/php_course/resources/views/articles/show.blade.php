@extends('layouts.bootstrap')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1>{{ $article->title }}</h1>
                    @auth
                        <div>
                            @can('update', $article)
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning">Редактировать</a>
                            @endcan
                            @can('delete', $article)
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                </form>
                            @endcan
                        </div>
                    @endauth
                </div>
                <div class="card-body">
                    <p class="text-muted small">Опубликовано: {{ $article->created_at->format('d.m.Y H:i') }}</p>
                    <hr>
                    <div class="article-content">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Назад к списку</a>
                </div>
            </div>
        </div>
    </div>
@endsection
