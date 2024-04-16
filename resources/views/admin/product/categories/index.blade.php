@extends('adminlte::page')

@section('title', 'Կատեգորիաներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Կատեգորիաներ</li>
    </ol>
    <h1 class="mb-2">Կատեգորիաներ</h1>
@stop

@section('content')
    <div class="card card-danger card-outline">
        <div class="card-body">
            <div class="col-md-9">
        <div class="card pt-2">
            <ul class="levels-list">
                @foreach ($records as $k => $cat)
                    @php $nextLevel = $cat->childCategories; @endphp
                    @include('admin.product.categories._category',['category' => $cat,'level' => 0,'next' => $nextLevel->count() > 0,'data_id' => $k])
                    @if ($nextLevel->count() > 0)
                        <li data-id="level-{{$k}}" >
                            <ul>
                                @foreach ($nextLevel as $j => $child)
                                    @php $endLevel = $child->childCategories; @endphp
                                    @include('admin.product.categories._category',['category' => $child,'level' => 1,'next' => $endLevel->count() > 0,'data_id' => $k.$j])
                                    @if ($endLevel->count() > 0)
                                        <li data-id="level-{{$k.$j}}">
                                            <ul>
                                                @foreach ($endLevel as $m => $item)
                                                    @php $lastLevel = $item->childCategories; @endphp
                                                    @include('admin.product.categories._category',['category' => $item,'level' => 2,'next' => $lastLevel->count() > 0,'data_id' => $k.$j.$m])
                                                    @if ($lastLevel->count() > 0)
                                                        <li data-id="level-{{$k.$j.$m}}">
                                                            <ul>
                                                                @foreach ($lastLevel as $l => $last)
                                                                    @include('admin.product.categories._category',['category' => $last,'level' => 3,'next' => null,'data_id' => $k.$j.$m.$l])
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
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
        </div>
    </div>
@stop
