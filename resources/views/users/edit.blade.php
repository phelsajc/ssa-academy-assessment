@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="prefixname">Prefix:</label>
            <select name="prefixname" id="prefixname" class="form-control" required>
                <option value="" disabled selected>Select a prefix</option>
                <option value="Mr." {{ old('prefixname', $user->prefixname) == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                <option value="Mrs." {{ old('prefixname', $user->prefixname) == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                <option value="Ms." {{ old('prefixname', $user->prefixname) == 'Ms.' ? 'selected' : '' }}>Ms.</option>
            </select>            
        </div>

        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
        </div>

        <div class="form-group">
            <label for="middlename">Middle Name:</label>
            <input type="text" name="middlename" id="middlename" class="form-control" value="{{ old('middlename', $user->middlename) }}" required>
        </div>
        
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
        </div>

        <div class="form-group">
            <label for="suffixname">Suffix Name:</label>
            <input type="text" name="suffixname" id="suffixname" class="form-control" value="{{ old('suffixname', $user->suffixname) }}" required>
        </div>

        <div class="form-group">
            <label for="username">User Name:</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="photo">Upload Photo:</label>
            @if ($user->photo)
                <img src="{{ asset($user->photo) }}" alt="Current Photo" width="100">
                <br>
            @endif
            <input type="file" name="photo" id="photo" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
