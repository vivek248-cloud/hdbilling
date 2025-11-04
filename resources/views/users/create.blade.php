@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<h2>Add User</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="text" name="mobile" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password (mobile number)</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="admin">Admin</option>
            <option value="client">Client</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Create User</button>
</form>
@endsection
