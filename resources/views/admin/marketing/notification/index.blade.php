@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Ծանուցումներ</h2>
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
                            Տեսակ
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Վերնագիր
                        </th>
                        <th
                            class="sorting"
                            tabindex="0"
                            aria-controls="datatable"
                            rowspan="1"
                            colspan="1"
                        >
                            Նամակ
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td><a style="display: block;width: max-content" href="{{route('admin.notifications.edit',$notification->id)}}">{{$notification->id}}</a></td>
                            <td>{{$types[$notification->type]}}</td>
                            <td>{{$notification->title}}</td>
                            <td>{{$notification->text}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
