@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել ' . $types[$record->type] . ' ծանուցումը' : 'Ավելացնել նոր ծանուցում')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Ծանուցումներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել' : 'Ավելացնել' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել ' . $types[$record->type]  . ' ծանուցումը' : 'Ավելացնել նոր ծանուցում' }}</h1>
@stop

@section('content')
    @php $statuses = \App\Enums\StatusTypes::statusList() @endphp
    <form action="{{ $record ? route('admin.notifications.update',['notification'=>$record->id]) : route('admin.notifications.store') }}" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <x-adminlte-input name="title" label="Վերնագիր" value="{{ old('title') ?? ($record ? $record->title : '') }}"/>
                        <x-adminlte-textarea name="text" label="Նամակ">{{ old('text') ?? ($record ? $record->text : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                            @if($record->type ==\App\Models\Notification::CUSTOM)
                                <x-adminlte-button class="btn-sm ml-2" type="submit" name="send" value="1" label="Ուղարկել" theme="outline-secondary" icon="fas fa-lg fa-envelope"/>
                            @endif
                        </div>
                        <p class="mt-2" style="margin-left: auto">%id% -> Պատվերի id <br>%name% ->Օգտատիրոջ անունը <br> %product_name%֊> Ապրանքի անուն</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
