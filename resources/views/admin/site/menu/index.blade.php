@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Մենյուներ</h2>
    </div>
    <ul class="nav nav-pills mb-3" id="pills-menu" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-0-tab" data-bs-toggle="pill" data-bs-target="#pills-0" type="button" role="tab" aria-controls="pills-0" aria-selected="true">Header</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="false">Footer</button>
        </li>
    </ul>

    <div class="tab-content card p-3 col-md-8" id="pills-menu-content">
        <div class="tab-pane fade show active" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab">
            <div class="mb-3">
                <div class="col-12">
                    <form action="{{route('admin.menus.update')}}" method="POST">
                        @csrf()
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Header Menu</h2>
                            <button type="submit" class=" btn btn-xl btn-soft-primary">Պահպանել</button>
{{--                            <a href="{{route('admin.menus.create')}}" class=" btn btn-xl btn-soft-primary">--}}
{{--                                <i class="fa-solid fa-plus"></i>--}}
{{--                                <span class="hide_mobile">Ավելացնել</span>--}}
{{--                            </a>--}}
                        </div>
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
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
            <div class="mb-3">
                <div class="col-12">
                    <form action="{{route('admin.menus.update')}}" method="POST">
                        @csrf()
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Footer Menu</h2>
                            <button type="submit" class=" btn btn-xl btn-soft-primary">Պահպանել</button>
{{--                        <a href="{{route('admin.menus.create')}}" class=" btn btn-xl btn-soft-primary">--}}
{{--                            <i class="fa-solid fa-plus"></i>--}}
{{--                            <span class="hide_mobile">Ավելացնել</span>--}}
{{--                        </a>--}}
                        </div>
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
                    </form>
            </div>
        </div>
    </div>

@endsection
