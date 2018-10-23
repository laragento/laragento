@extends('admin::layouts.master')

@section('meta')
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ trans('customer::auth.reset_password') }}"/>
    <title>{{ trans('customer::auth.reset_password') }}</title>
@endsection

@section('content')
    <div class="site-container">
        <header>

        </header>
        <main>
            <section class="login-section content">
                <form novalidate method="POST" action="{{ route('admin.password.reset') }}">
                    @csrf
                    <div class="form-titile">
                        <h1>{{ trans('customer::auth.reset_password') }}</h1>
                        <p>{{ trans('admin::auth.reset_password_text') }}</p>
                    </div>
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-row">
                        <label>{{ trans('customer::auth.email_address') }}
                            <input type="email" name="email" required placeholder="">
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                            @endif
                        </label>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('customer::auth.password') }}
                            <input type="password" name="password" required placeholder="">
                            @if ($errors->has('password'))
                                <span class="form-error is-visible">{{ $errors->first('password') }}</span>
                            @endif
                        </label>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('customer::auth.repeat_password') }}
                            <input type="password" name="password_confirmation" required placeholder="">
                            @if ($errors->has('password'))
                                <span class="form-error is-visible">{{ $errors->first('password') }}</span>
                            @endif
                        </label>
                    </div>
                    <div class="form-row action row">
                        <span>
                    <button class="button" type="submit">{{ trans('customer::auth.reset_password') }}</button>
                        </span>
                    </div>
                </form>
            </section>
        </main>
    </div>
@endsection
