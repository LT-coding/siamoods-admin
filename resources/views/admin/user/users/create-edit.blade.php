@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել օգտատիրոջ տվյալները' : 'Ավելացնել նոր օգտատեր' )

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $record ? 'Խմբագրել օգտատիրոջ տվյալները' : 'Ավելացնել նոր օգտատեր' }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Ադմինիստրացիա</a></li>
                <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել օգտատիրոջ տվյալները' : 'Ավելացնել նոր օգտատեր' }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <form action="{{ $record ? route('admin.users.update',['user'=>$record->id]) : route('admin.users.store') }}" method="post">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="name" label="Անուն" value="{{ old('name') ?? ($record ? $record->name : '') }}" data-required="true"/>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="email" label="Էլ․ հասցե" value="{{ old('email') ?? ($record ? $record->email : '') }}" data-required="true"/>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <x-adminlte-select name="role" label="Դեր" data-required="true">
                                    <x-adminlte-options :options="$roles" :selected="old('role') ? [old('role')] : ($record ? [$record->getRoleNames()[0]] : [])"/>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-3">
                                <x-adminlte-select name="status" label="Կարգավիճակ" data-required="true">
                                    <x-adminlte-options :options="\App\Enums\Status::statusNames()" :selected="old('status') ? [old('status')] : ($record ? [$record->status] : [])"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="password" type="password" label="Գաղտնաբառ" autocomplete="new-password"/>
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="password_confirmation" type="password" label="Գաղտնաբառի հաստատում"/>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

