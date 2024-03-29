@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <div>
        <div class="mb-4">
            <h2>Խմբագրել {{$types[$notification->type]}}</h2>
        </div>
        <form action="{{route('admin.notifications.update',$notification->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-lg-9 col-sm-12">
                <div class="card p-4">
                    <div class="mb-3">
                        <div class="row">
                            <label for="title" class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անուն<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input id="title" class="form-control" type="text" name="title" value="{{$notification->title}}">
                            </div>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger offset-md-3">
                                {{$errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label for="text" class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անուն<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <textarea id="text" class="form-control tinymce" type="text" name="text" >{{$notification->text}}</textarea>
                            </div>
                            <p  class="col-sm-9 mt-2" style="margin-left: auto">%id% -> Պատվերի id <br>%name% ->Օգտատիրոջ անունը <br> %product_name%֊> Ապրանքի անուն</p>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger offset-md-3">
                                {{$errors->first('name') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Հաստատել</button>
            @if($notification->type ==\App\Models\Notification::CUSTOM)
                <button type="submit" name="send" value="1" class="btn btn-primary">Ուղարկել</button>
            @endif
        </form>
    </div>
@endsection
