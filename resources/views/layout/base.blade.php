<!DOCTYPE html>
<!--
Template Name: Rocketman - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ asset('build/assets/images/logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The best selection of unique and handcrafted jewellery from the World’s best designers.">
    <meta name="keywords" content="admin template, Rocketman Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- END: CSS Assets-->

    <script  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Pusher from a CDN -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Include Laravel Echo from a CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.iife.min.js" integrity="sha512-aPAh2oRUr3ALz2MwVWkd6lmdgBQC0wSr0R++zclNjXZreT/JrwDPZQwA/p6R3wOCTcXKIHgA9pQGEQBWQmdLaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<!-- END: Head -->

@yield('body')

</html>
