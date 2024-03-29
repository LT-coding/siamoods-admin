@extends('adminlte::page')

@section('title', $record ? __('Update Order') . ' | ' . $record->code : __('Create Order'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="mb-2">{{ $record ? __('Update Order') . ' | ' . $record->code : __('Create Order') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
                <li class="breadcrumb-item active">{{ $record ? __('Update Order') : __('Create Order') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ $record ? route('admin.orders.update',['order' => $record->id]) : route('admin.orders.store') }}" method="post">
        <div class="row">
            <div class="col-sm-5">
                <div class="card card-body card-outline p-2">
                    <h4>Personal Information</h4>
                    <p class="text-bold">{{ $personal['name'] . ' ' . $personal['lastname'] . ' (' . $personal['email'] . ')' }}</p>
                    <p>{{ $personal['phone'] }}</p>
                    <p>{{ isset($personal['date_of_birth']) ? Carbon\Carbon::parse($personal['date_of_birth'])->format('d F, Y') : '' }}</p>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card card-body card-outline p-2">
                    <h4>Shipping Information</h4>
                    @php $first = $shipping['name'] ?? $personal['name']; $last = $shipping['lastname'] ?? $personal['lastname']; @endphp
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Full name</dt>
                        <dd class="col-sm-8">{{ $first . ' ' . $last }}</dd>
                        <dt class="col-sm-4">Phone Number</dt>
                        <dd class="col-sm-8">{{ $shipping['phone'] ?? $personal['phone'] }}</dd>
                        <dt class="col-sm-4">Address line 1</dt>
                        <dd class="col-sm-8">{{ $shipping['address_line_1'] }}</dd>
                        <dt class="col-sm-4">Address line 2</dt>
                        <dd class="col-sm-8">{{ $shipping['address_line_2'] ?? ''}}</dd>
                        <dt class="col-sm-4">Country, City, State, Postal code</dt>
                        <dd class="col-sm-8">{{ $shipping['full_address'] ?? $shipping['country'] . ', ' . $shipping['city'] . ', ' . $shipping['state'] . ', ' . $shipping['zip_code'] }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                @include('admin.includes.order-items')
                            </div>
                            <div class="col-md-4">
                                <div class="card card-body card-outline p-2">
                                    <p class="text-bold">{{ Carbon\Carbon::parse($record->paid_at)->format('d F, Y h:i') }}</p>
                                    <p class="text-bold">Order Status <span class="text-lg d-inline-block ml-3">{{ \App\Enums\OrderStatuses::getConstants()[$record->status] }}</span></p>
                                    <h4>Payment Information</h4>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Payment Method</dt>
                                        <dd class="col-sm-8">{{ $record->payment_method }}</dd>
                                        <dt class="col-sm-4">Transaction ID</dt>
                                        <dd class="col-sm-8">{{ $record->transaction_id }}</dd>
                                        <dt class="col-sm-4">Subtotal</dt>
                                        <dd class="col-sm-8">{{ $record->currency.\App\Models\Product::formatPrice($record->subtotal) }}</dd>
                                        <dt class="col-sm-4">Delivery</dt>
                                        <dd class="col-sm-8">{{ $record->currency.\App\Models\Product::formatPrice($record->delivery) }}</dd>
                                        <dt class="col-sm-4">Total</dt>
                                        <dd class="col-sm-8">{{ $record->currency.\App\Models\Product::formatPrice($record->total) }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

