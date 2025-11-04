@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<h2>Edit User</h2>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>


    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep current)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update User</button>
</form>
@endsection
