@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Բաններ</h2>
                <a href="{{route('admin.banners.create')}}" class=" btn btn-xl btn-soft-primary">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hide_mobile">Ավելացնել</span>
                </a>
            </div>
            <div class="make-responsive-table">
                <table
                    class="table table-bordered dataTable no-footer table_dataTable"
                    role="grid"
                    aria-describedby="datatable_info"
                >
                    <thead>
                    <tr role="row">
                        <th
                            class="sorting sorting_asc text-center"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                            aria-sort="ascending"
                            style="width: 30px"
                        >
                            #
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Անուն
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Տեսակ
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Կարգավիճակ
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Ստեղծման ամսաթիվ
                        </th>
                        <th style="width: 60px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banners as $banner)
                        <tr>
                            <td>{{$banner->id}}</td>
                            <td>{{$banner->name}}</td>
                            <td>
                                {{ $banner->type ? \App\Enums\BannerType::text : \App\Enums\BannerType::graph }}
                            </td>
                            <td class="{{$banner->status ? 'text-success' : 'text-danger'}} status-item">
                                {{ $banner->status ? \App\Enums\Status::active : \App\Enums\Status::inActive }}
                            </td>
                            <td>{{\Carbon\Carbon::createFromDate($banner->created_at)->format('d.m.y').'թ.'}}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <a href="{{route('admin.banners.edit',[$banner])}}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{route('admin.banners.destroy',[$banner])}}" method="POST" class="delete-form">
                                        @csrf()
                                        @method('DELETE')
                                        <button type="submit" class="bg-white border-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
