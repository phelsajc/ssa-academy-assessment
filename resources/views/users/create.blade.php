@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"> <!-- Note the enctype -->
        @csrf

        <div class="form-group">
            <label for="prefixname">Prefix:</label>
            <select name="prefixname" id="prefixname" class="form-control" required>
                <option value="" disabled selected>Select a prefix</option>
                <option value="Mr.">Mr.</option>
                <option value="Mrs.">Mrs.</option>
                <option value="Ms.">Ms.</option>
            </select>            
        </div>

        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname') }}" required>
        </div>

        <div class="form-group">
            <label for="middlename">Middle Name:</label>
            <input type="text" name="middlename" id="middlename" class="form-control" value="{{ old('middlename') }}" required>
        </div>
        
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname') }}" required>
        </div>

        <div class="form-group">
            <label for="suffixname">Suffix Name:</label>
            <input type="text" name="suffixname" id="suffixname" class="form-control" value="{{ old('suffixname') }}" required>
        </div>

        <div class="form-group">
            <label for="username">User Name:</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="photo">Upload Photo:</label>
            <input type="file" name="photo" id="photo" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
