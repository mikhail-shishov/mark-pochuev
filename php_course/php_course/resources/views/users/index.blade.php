@extends('layouts.bootstrap')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Управление пользователями</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
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
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $user->role }}</span></td>
                                    <td>
                                        <form action="{{ route('users.update-role', $user) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="form-select form-select-sm me-2" {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-success" {{ auth()->id() == $user->id ? 'disabled' : '' }}>OK</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
