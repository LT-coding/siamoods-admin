@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել պատվերը' : 'Ավելացնել պատվեր')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Պատվերներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել պատվերը' : 'Ավելացնել պատվեր' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել պատվերը' : 'Ավելացնել պատվեր' }}</h1>
@stop

@section('content')
    <form action="{{ $record ? route('admin.orders.update',['order' => $record->id]) : route('admin.orders.store') }}" method="post">
        @csrf
        @if($record)
            @method('PUT')
            <input name="id" type="hidden" value="{{ $record->id }}"/>
        @endif
        <div class="row">
            <div class="col-sm-4">
                <div class="card card-body card-outline p-2">
                    <h5><i class="fas fa-user"></i> Հաճախորդի ինֆորմացիա</h5>
                    <p class="text-bold mb-0">{{ $record->user?->display_name }}</p>
                    <p class="text-bold mb-0">{{ $record->user?->email }}</p>
                    <p>Հեռ․ {{ $record->user?->phone }}</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card card-body card-outline p-2">
                    <h5><i class="fas fa-truck"></i> Առաքման հասցե</h5>
                    <p class="text-bold mb-0">{{ $record->user?->shippingAddress?->full_name }}</p>
                    <p class="mb-0">{!! $record->user?->shippingAddress?->full_address !!}</p>
                    <p>Հեռ․ {{ $record->user?->shippingAddress?->phone }}</p>
                </div>
            </div>
            @if($record->user?->paymentAddress)
                <div class="col-sm-4">
                    <div class="card card-body card-outline p-2">
                        <h5><i class="far fa-credit-card"></i> Վճարողի հասցե</h5>
                        <p class="text-bold mb-0">{{ $record->user?->paymentAddress?->full_name }}</p>
                        <p class="mb-0">{!! $record->user?->paymentAddress?->full_address !!}</p>
                        <p>Հեռ․ {{ $record->user?->paymentAddress?->phone }}</p>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @include('admin.includes.order-items')
                                <x-adminlte-textarea name="comment" label="Հաճախորդի նշումներ">{{ old('comment') ?? ($record ? $record->comment : '') }}</x-adminlte-textarea>
                                <x-adminlte-textarea name="staff_notes" label="Նշումներ աշխատակիցների համար">{{ old('staff_notes') ?? ($record ? $record->staff_notes : '') }}</x-adminlte-textarea>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-body card-outline p-2">
                                    <h4 class="text-right">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at)->format('d.m.Y H:i') }}</h4>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-5">Կարգավիճակ</dt>
                                        <dd class="col-sm-7">
                                            <x-adminlte-select name="status">
                                                <x-adminlte-options :options="App\Models\Order::STATUS_SHOW" :selected="old('status') ? [old('status')] : ($record ? [$record->status] : [])"/>
                                            </x-adminlte-select>
                                        </dd>
                                        <dt class="col-sm-5">Վճարման մեթոդ</dt>
                                        <dd class="col-sm-7">{{ $record->payment->title }}</dd>
                                        <dt class="col-sm-5">Առաքման մեթոդ</dt>
                                        <dd class="col-sm-7">{{ $record->shipping->name }}</dd>
                                        <dt class="col-sm-5">Tracking number</dt>
                                        <dd class="col-sm-7">
                                            <x-adminlte-input name="tracking_number" value="{{ old('tracking_number') ?? ($record ? $record->tracking_number : '') }}"/>
                                        </dd>
                                    </dl>
                                    <div class="text-right">
                                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                                        <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

