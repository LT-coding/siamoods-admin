@extends('adminlte::page')

@section('title', __('Site Customization'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('Site Customization') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Site Customization') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="footer-menu-tab" data-toggle="pill" href="#footer-menu" role="tab">Footer Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="pill" href="#contact" role="tab">Contact Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="social-tab" data-toggle="pill" href="#social" role="tab">Social Links</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade active show" id="footer-menu" role="tabpanel">
                    @include('admin.site.includes._footer-menu')
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel">
                    @include('admin.site.includes._contact')
                </div>
                <div class="tab-pane fade" id="social" role="tabpanel">
                    @include('admin.site.includes._social')
                </div>
            </div>
        </div>
    </div>
@stop
