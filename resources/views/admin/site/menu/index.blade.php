@extends('adminlte::page')

@section('title', 'Մենյուներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Մենյուներ</li>
    </ol>
    <h1 class="mb-2">Մենյուներ</h1>
@stop

@section('content')
    <div class="card card-danger card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs customization-tabs" id="tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="0-tab" data-toggle="pill" href="#tab-0" role="tab">Header</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="1-tab" data-toggle="pill" href="#tab-1" role="tab">Footer</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="tabContent">
                <div class="tab-pane fade show active" id="tab-0" role="tabpanel" aria-labelledby="tab-0-tab">
                    <form action="{{ route('admin.menus.update') }}" method="POST">
                        @csrf()
                        <input name="page" class="page" type="hidden" value="0"/>
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Header Menu</h4>
                                <div class="text-right">
                                    <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                                </div>
                                {{--                            <a href="{{route('admin.menus.create')}}" class=" btn btn-xl btn-soft-primary">--}}
                                {{--                                <i class="fa-solid fa-plus"></i>--}}
                                {{--                                <span class="hide_mobile">Ավելացնել</span>--}}
                                {{--                            </a>--}}
                            </div>
                            <div class="card pt-2">
                                <ul class="categories-list ">
                                    @foreach($headerMenusAll as $k=>$menu)
                                        @php
                                            $nextLevel = $menu->childrenAll;
                                        @endphp
                                        @include('admin.site.menu._menu',['menu' => $menu,'level' => 0,'next' => $nextLevel,'data_id'=>$k])
                                        @if($nextLevel)
                                            <li data-id="level-{{$k}}" >
                                                <ul>
                                                    @foreach($nextLevel as $j=>$child)
                                                        @php
                                                            $end_cats=$child->childrenAll;
                                                        @endphp
                                                        @include('admin.site.menu._menu',['menu'=>$child,'level'=>1,'next'=> $end_cats,'data_id'=>$k.$j])
                                                        @if($end_cats)
                                                            <li data-id="level-{{$k.$j}}" >
                                                                <ul>
                                                                    @foreach($end_cats as $m=>$item)
                                                                        @include('admin.site.menu._menu',['menu'=>$item,'level'=>2,'next'=>null,'data_id'=>$k.$j.$m])
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="tab-1-tab">
                    <form action="{{ route('admin.menus.update') }}" method="POST">
                        @csrf()
                        <input name="page" class="page" type="hidden" value="1"/>
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4>Footer Menu</h4>
                                <div class="text-right">
                                    <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                                </div>
                                {{--                        <a href="{{route('admin.menus.create')}}" class=" btn btn-xl btn-soft-primary">--}}
                                {{--                            <i class="fa-solid fa-plus"></i>--}}
                                {{--                            <span class="hide_mobile">Ավելացնել</span>--}}
                                {{--                        </a>--}}
                            </div>
                            <div class="card pt-2">
                                <ul class="categories-list ">
                                    @foreach($footerMenusAll as $k=>$menu)
                                        @php
                                            $nextLevel = $menu->childrenAll;
                                        @endphp
                                        @include('admin.site.menu._menu',['menu' => $menu,'level' => 0,'next' => $nextLevel,'data_id'=>$k])
                                        @if($nextLevel)
                                            <li data-id="level-{{$k}}" >
                                                <ul>
                                                    @foreach($nextLevel as $j=>$child)
                                                        @php
                                                            $end_cats=$child->childeren;
                                                        @endphp
                                                        @include('admin.site.menu._menu',['menu'=>$child,'level'=>1,'next'=> $end_cats,'data_id'=>$k.$j])
                                                        @if($end_cats)
                                                            <li data-id="level-{{$k.$j}}" >
                                                                <ul>
                                                                    @foreach($end_cats as $m=>$item)
                                                                        @include('admin.site.menu._menu',['menu'=>$item,'level'=>2,'next'=>null,'data_id'=>$k.$j.$m])
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
