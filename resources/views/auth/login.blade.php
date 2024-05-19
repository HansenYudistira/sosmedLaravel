@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 class="mb-4">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->has('email'))
                    <div class="alert alert-danger mb-3" role="alert">
                        Username atau Password Salah.
                    </div>
                @endif
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></p>
        </div>
    </div>
</div>
@endsection
