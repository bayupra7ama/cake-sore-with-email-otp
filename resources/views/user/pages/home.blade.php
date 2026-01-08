@extends('user.layouts.app')

@section('title', 'Home')

@section('content')

    @include('user.partials.sections.hero')
    @include('user.partials.sections.about')
    @include('user.partials.sections.categories', ['categories' => $categories])
    @include('user.partials.sections.product')
    @include('user.partials.sections.instagram')

@endsection
