<!DOCTYPE html>
<html lang="{{ \App\Facades\GlobalLanguage::user_lang_slug() }}"
      dir="{{ \App\Facades\GlobalLanguage::user_lang_dir() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    @php
        $theme = '';
        $theme_number = '';
            if (tenant())
            {
                    switch (tenant()->theme_slug){
                    case 'theme-1';
                    $theme = 'theme-01';
                    $theme_number = 'theme_one';
                    break;

                    case 'theme-2';
                    $theme = 'theme-02';
                    $theme_number = 'theme_two';
                    break;

                    case 'theme-3';
                    $theme = 'theme-03';
                    $theme_number = 'theme_three';
                    break;
                }
            }
    @endphp

    {!! load_google_fonts($theme_number) !!}
    {!! render_favicon_by_id(get_static_option('site_favicon')) !!}

    <title>
        @if(!request()->routeIs('tenant.frontend.homepage'))
            @yield('title')
            -
            {{get_static_option('site_title')}}
        @else
            {{get_static_option('site_title')}}
            @if(!empty(get_static_option('site_tag_line')))
                - {{get_static_option('site_tag_line')}}
            @endif
        @endif
    </title>

    {!! render_favicon_by_id(filter_static_option_value('site_favicon', $global_static_field_data)) !!}
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/odometer.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/common.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/themes/css/'.$theme.'/'.$theme.'.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/helpers.css')}}">
    <link rel="stylesheet" href="{{ global_asset('assets/common/css/toastr.css') }}">
    <link rel="stylesheet" href="{{global_asset('assets/common/css/loader-01.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/custom-style.css')}}">

    @if(\App\Facades\GlobalLanguage::user_lang_dir() == 'rtl')
        <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/rtl.css')}}">
    @endif

    @if(request()->routeIs('tenant.frontend.homepage'))
        @include('tenant.frontend.partials.meta-data')
    @else
        @yield('meta-data')
    @endif

    @include('tenant.frontend.partials.css-variable', ['theme_number' => $theme_number])
    <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/shop-order-custom.css')}}">
    @yield('style')

    @if(\App\Enums\LanguageEnums::getdirection(get_user_lang_direction()) == 'rtl')
        <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/rtl.css')}}">
    @endif
    @php
        $file = file_exists('assets/tenant/frontend/css/'.tenant()->id.'/dynamic-style.css');
    @endphp
    @if($file)
        <link rel="stylesheet" href="{{global_asset('assets/tenant/frontend/css/'. tenant()->id .'/dynamic-style.css')}}">
    @endif
</head>

<body class="{{$theme}}">

@include('tenant.frontend.partials.loader')
@include('tenant.frontend.partials.navbar')

<div class="search-suggestion-overlay"></div>
