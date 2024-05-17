@extends('adminlte::page')

@section('title',  'Ադմինիստրացիա')

@section('content_header')
    <h1>Ադմինիստրացիա</h1>
@stop

@section('content')
    <div class="row">
        @foreach($payments as $payment)
            <div class="col">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col">
                                <p class="text-dark mb-0 fw-semibold">{{ $payment->id == 1 ? 'Կանխիկ' : $payment->title }}</p>
                                <h3 class="m-0">{{ $orders->where('payment_id',$payment->id)->first()?->total }}</h3>
                            </div>
                            <div class="col-auto align-self-center">
                                <div class="report-main-icon bg-light-alt">
                                    @if(!$payment->image)
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-briefcase align-self-center text-muted icon-sm"
                                        >
                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                        </svg>
                                    @else
                                        <img width="60" src="{{$payment->image}}" alt="payment" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-6 col-lg-2">
            <div class="card report-card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-0 fw-semibold">Ընդամենը</p>
                            <h3 class="m-0">{{$sum}}</h3>
                        </div>
                        <div class="col-auto align-self-center">
                            <div class="report-main-icon bg-light-alt">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-briefcase align-self-center text-muted icon-sm"
                                >
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col"></div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <select id="yearSelect" name="year">
                                    @for ($year = 2023; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="position: relative;">
                        <div id="chart" class="apex-charts" style="min-height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title float-none">Վերջին Պատվերները <a class="text-danger float-right" href="{{route('admin.orders.index')}}">տեսնել բոլորը</a></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-sm">
                        <table class="table table-bordered">
                            <thead>
                                <tr role="row">
                                    <th class="text-center">#</th>
                                    <th>Կարգավիճակ</th>
                                    <th>Ամսաթիվ</th>
                                    <th>Հաճախորդ</th>
                                    <th>Հեռ.</th>
                                    <th>Ընդամենը</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lastOrders as $order)
                                    <tr class="order-status order-status-{{$order->status}}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ \App\Models\Order::STATUS_SHOW[$order->status] }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->user?->name ? $order?->user->full_name : $order->user?->shippingAddress?->full_name }}</td>
                                        <td>{{ $order->user?->phone?:$order->user?->shippingAddress?->phone }}</td>
                                        <td>{{ $order->paid }}</td>
                                        <td><a href="#" data-action="{{ route('admin.orders.destroy', ['order' => $order->id]) }}" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--$products10, $categoriesBest, $regionStatistics, $waiting--}}
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Թոփ 10 ապրանքները</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group custom-list-group mb-n3">
                        @foreach($products10 as $product)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{ $product->item_name }}</h6>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    {{ $product->quantity }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Ըստ դասակարգիչների</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group custom-list-group mb-n3">
                        @foreach($categoriesBest as $category)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{ $category->name }}</h6>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    {{ $category->quantity }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Ըստ մարզերի</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group custom-list-group mb-n3">
                        @foreach($regionStatistics as $region)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{ constant('App\Enums\State::' . $region->state) }}</h6>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    {{ $region->quantity }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Սպասվող ապրանքներ</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            @foreach($waiting as $key => $wait)
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapseBtn" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            {{ $wait['product']->item_name }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse{{$key}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        @foreach($wait['email'] as $email)
                                            {{ $email }}<br />
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
