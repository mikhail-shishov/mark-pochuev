@extends('layouts.bootstrap')

@section('content')
<h1>Управление пользователями</h1>

<div class="mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-success">Добавить пользователя</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin() ? 'bg-danger' : ($user->isModerator() ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ $user->role?->name ?? 'Нет роли' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Редактировать</a>

                            <form action="{{ route('users.update-role', $user) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role_id" class="form-select form-select-sm" style="width: auto;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Роль</button>
                            </form>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" data-confirm-message="Вы точно хотите удалить пользователя {{ $user->name }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
