@extends('adminlte::page')

@section('title', 'Պրոֆիլ' )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Պրոֆիլ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item active">Պրոֆիլ</li>
            </ol>
        </div>
    </div>
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

