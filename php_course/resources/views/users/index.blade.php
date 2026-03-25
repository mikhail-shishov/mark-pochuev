@extends('layouts.bootstrap')

@section('content')
<h1>Управление пользователями</h1>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Текущая роль</th>
                <th>Изменить роль</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    {{-- <td>{{ $user->last_name }}</td>--}}
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin() ? 'bg-danger' : ($user->isModerator() ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('users.update-role', $user) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="form-select form-select-sm" style="width: auto;">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Модератор</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Обновить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
