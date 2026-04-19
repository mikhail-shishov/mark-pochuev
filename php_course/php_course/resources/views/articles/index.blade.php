@extends('layouts.bootstrap')

@section('content')
    <h1>Все статьи</h1>

    @if($articles->isEmpty())
        <p>Статей пока нет.</p>
    @else
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Читать</a>

                            @auth
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
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
