@extends('adminlte::page')

@section('title', __('Account') . ' | ' . $record->display_name)

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.accounts.index') }}">{{ __('Accounts') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Account') }}</li>
    </ol>
    <h1 class="mb-2">{{ __('Account') . ' | ' . $record->display_name }}</h1>
@stop

@section('content')
    <div class="card card-danger card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Account Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-addresses-tab" data-toggle="pill" href="#custom-tabs-four-addresses" role="tab" aria-controls="custom-tabs-four-addresses" aria-selected="false">Addresses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-orders-tab" data-toggle="pill" href="#custom-tabs-four-orders" role="tab" aria-controls="custom-tabs-four-orders" aria-selected="false">Orders</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                    <div class="table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <tbody>
                                <tr>
                                    <td class="text-bold">Full Name</td>
                                    <td>{{ $record->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Phone Number</td>
                                    <td>{{ $record->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Email</td>
                                    <td>{{ $record->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Date of Birth</td>
                                    <td>{{ $record->date_of_birth }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-addresses" role="tabpanel" aria-labelledby="custom-tabs-four-addresses-tab">
                    @foreach($record->addresses as $address)
                        <div class="card{{ $address->is_main ? ' card-secondary' : '' }}">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-text-width"></i> Shipping Address
                                </h3>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Full name</dt>
                                    <dd class="col-sm-8">{{ $address->full_name }}</dd>
                                    <dt class="col-sm-4">Phone Number</dt>
                                    <dd class="col-sm-8">{{ $address->phone }}</dd>
                                    <dt class="col-sm-4">Address line 1</dt>
                                    <dd class="col-sm-8">{{ $address->address_line_1 }}</dd>
                                    <dt class="col-sm-4">Address line 2</dt>
                                    <dd class="col-sm-8">{{ $address->address_line_2 }}</dd>
                                    <dt class="col-sm-4">Country, City, State, Postal code</dt>
                                    <dd class="col-sm-8">{{ $address->full_address }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-orders" role="tabpanel" aria-labelledby="custom-tabs-four-orders-tab">
                    Orders
                </div>
            </div>
        </div>
    </div>
@stop
