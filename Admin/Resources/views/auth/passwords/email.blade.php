@extends('admin::layouts.master')

@section('meta')
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ trans('customer::auth.forgot_password') }}"/>
    <title>{{ trans('customer::auth.forgot_password') }}</title>
@endsection

@section('content')
    <div class="site-container">
        <header>

        </header>
        <main>
            <section class="login-section content">
                <form novalidate method="POST" action="{{ route('admin.password.email') }}">
                    <div class="form-title">
                        <h1>{{ trans('customer::auth.forgot_password') }}</h1>
                        <p>{{ trans('admin::auth.forgot_password_text') }}</p>
                    </div>
                    @csrf
                    <div class="form-row">
                        <label>{{ trans('customer::auth.email_address') }}
                            <input type="email" name="email" required placeholder="">
                            @if ($errors->has('email'))
                                <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                            @endif
                        </label>
                    </div>
                    <div class="form-row action-row">
                    <span>
                         <button class="button" type="submit">{{ trans('customer::auth.reset_password') }}</button>
                    </span>
                    </div>
                </form>
            </div>
        </main>
        <footer>
            footertext
        </footer>
    </div>
    <!-- /.site-container -->

@endsection
