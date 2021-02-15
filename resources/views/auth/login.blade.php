@extends('page')

@section('content')
    <div class="container mx-auto pt-8 px-4">
        <div class="md:w-1/2 mx-auto bg-gray-200 p-4 shadow-lg rounded border border-gray-300">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="label text-gray-800" for="email">{{ __('Email') }}</label>
                    <input input type="email" class="input" id="email" name="email" value="{{ old('email', '') }}" required autofocus>
                    @if ($errors->has('email'))
                        <small class="mt-1 text-xs text-red-400">{{ $errors->first('email') }}</small>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="label text-gray-800" for="password">Password</label>
                    <input type="password" class="input" id="password" name="password" required>
                    @if ($errors->has('password'))
                        <small class="mt-1 text-xs text-red-400">{{ $errors->first('password') }}</small>
                    @endif

                    <a href="{{ route('password.request') }}" class="mt-1 text-sm text-indigo-700 block">
                        Forgot password?
                    </a>
                </div>

                <div class="mb-4">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" class="text-sm text-gray-800">Stay logged in</label>
                </div>

                <button type="submit" class="bg-gray-800 w-full py-3 text-gray-100 rounded font-bold test-sm">Login</button>

                <a href="{{ route('register') }}" class="mt-2 text-sm text-indigo-700 text-center block">
                    Or create a new account
                </a>
            </form>
        </div>
    </div>
@endsection
