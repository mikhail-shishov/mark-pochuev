@extends('layouts.bootstrap')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Редактировать статью</div>
                <div class="card-body">
                    <form action="{{ route('articles.update', $article) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Контент</label>
                            <textarea name="content" id="content" class="form-control" rows="10" required>{{ $article->content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
