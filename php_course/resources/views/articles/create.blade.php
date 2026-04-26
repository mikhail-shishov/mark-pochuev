@extends('layouts.bootstrap')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1>Создать статью</h1>
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                <div id="title-avail" class="form-text"></div>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Содержание</label>
                <textarea name="content" id="article-content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                <div class="text-end">
                    Символов: <small class="text-muted" id="char-counter">0</small>
                </div>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Отмена</a>
                <button type="submit" class="btn btn-primary" id="create-btn">Создать</button>
            </div>
        </form>
    </div>
</div>
@endsection
