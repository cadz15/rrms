@extends('layout.contentLayoutStudent')

@section('title', 'Create Request')

@section('page-styles')
    <style>
        .loading-livewire {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        border: 1px solid black;
        margin: 0;
        padding: 0;
        left: 0;
        text-align: center;
        display: flex;
        align-items: center;
        background-color: #000;
        opacity: 0.5;
    }
    </style>
@endsection

@section('content')

    <h5 class="py-3">
        <span class="text-muted fw-light"> Create Request </span>
    </h5>

    <livewire:create-request :majors="$majors" :requestableItems="$requestableItems" :userId="auth()->user()->id" :mode="'create'" />

@endsection