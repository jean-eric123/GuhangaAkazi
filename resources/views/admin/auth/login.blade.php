@extends('admin.layouts.guest')

@section('title', 'Admin Login')

@section('content')
    <div class="brand">
        <h1>GuhangaAkazi</h1>
        <p>Admin Panel</p>
    </div>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <label for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            autocomplete="username"
        >

        <label for="password">Password</label>
        <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
        >

        <label class="checkbox-row">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            <span>Remember me</span>
        </label>

        <button type="submit">Sign in</button>
    </form>

    <div class="footer-note">Authorized access only</div>
@endsection
