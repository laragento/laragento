@extends('admin::layouts.master')

@section('meta')
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ trans('admin::admin.admin_register') }}"/>
    <title>{{ trans('admin::admin.admin_register') }} </title>
@endsection

@section('content')
    <div class="site-container">
        <header>

        </header>
        <main>
        <section class="login-section content">


            <form novalidate class="login-form" method="POST" action="{{ route('admin.register') }}">
                <div class="form-title">
                    <h1>{{trans('admin::admin.admin_register')}}</h1>
                </div>
                @csrf
                <div class="form-row">
                    <label>{{ trans('customer::auth.email_address') }}
                        <input type="email" name="email" required autofocus placeholder=""
                               value="{{ old('email') }}">
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
                    <label>{{ trans('customer::auth.password_confirmation') }}
                        <input type="password" name="password_confirmation" required placeholder="">
                        @if ($errors->has('password'))
                            <span class="form-error is-visible">{{ $errors->first('password') }}</span>
                        @endif
                    </label>
                </div>
                <div class="form-row action-row">
                    <span class="text-left">
                    <button class="button" type="submit">{{ trans('customer::auth.register') }}</button>
                    </span>
                </div>
            </form>
        </section>
        </main>
        <footer>Footertext</footer>
    </div>
@endsection
