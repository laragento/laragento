@extends('admin::layouts.master')

@section('meta')
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ trans('admin::admin.dashboard') }}"/>
    <title>{{ trans('admin::admin.dashboard') }}</title>
@endsection

@section('content')
    <h1>{{ trans('admin::admin.dashboard') }}</h1>
    <br/>
    <p class="lead">
        {{ trans('admin::admin.dashboard_lead_text') }}
    </p>
@endsection
