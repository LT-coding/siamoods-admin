@extends('adminlte::page')

@section('title', $record ? __('Update User') . ' | ' . $record->display_name : __('Create User') )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? __('Update User') .  ' | ' . $record->display_name : __('Create User') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update User') : __('Create User') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.users.update',['user'=>$record->id]) : route('admin.users.store') }}" method="post">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="name" label="First Name" value="{{ old('name') ?? ($record ? $record->name : '') }}"/>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="lastname" label="Last Name" value="{{ old('lastname') ?? ($record ? $record->lastname : '') }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="phone_number" label="Phone Number" value="{{ old('phone_number') ?? ($record ? $record->phone_number : '') }}"/>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="email" label="Email" value="{{ old('email') ?? ($record ? $record->email : '') }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-select name="role" label="Role">
                                    <x-adminlte-options :options="$roles" :selected="old('role') ? [old('role')] : ($record ? [$record->role_name] : [])" empty-option="Select a role"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="password" type="password" label="Password" autocomplete="new-password"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="password_confirmation" type="password" label="Password Confirmation"/>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Save" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

