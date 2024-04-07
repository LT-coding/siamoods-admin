@extends('adminlte::page')

@section('title', 'Պրոֆիլ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Պրոֆիլ</li>
    </ol>
    <h1 class="mb-2">Պրոֆիլ</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    @include('admin.profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    @include('admin.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@stop

