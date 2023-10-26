@extends('layout.contentLayoutMaster')

@section('title', 'Add Student | Information Form')

@section('content')


    <h5 class="py-3">
        <span class="text-muted fw-light">Add Student /</span> Information Form
    </h5>

    <div class="row">

    <x-form.information
        :data="[]"
        formURL="#" 
        formTitle="Student Information"
        cancelURL="#"
        cancelText="Decline"
    >
    </x-form.information>

        
    </div>

@endsection