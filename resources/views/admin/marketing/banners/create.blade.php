@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <div>
        <div class="mb-4">
            <h2>Ավելացնել նոր բաններ</h2>
        </div>
        <form action="{{route('admin.banners.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9 col-sm-12">
                <div class="card p-4">
                    <div class="mb-3">
                        <div class="row">
                            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Անուն<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{old('name')}}" type="text" name="name">
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
                            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Տեսակ<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-4">
                                <select class="form-select banner-type-select" name="type">
                                    <option value='0' selected>{{\App\Enums\BannerType::graph}}</option>
                                    <option value='1'>{{\App\Enums\BannerType::text}}</option>
                                </select>
                            </div>
                            @if ($errors->has('type'))
                                <span class="text-danger offset-md-3">
                                {{$errors->first('type') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label class="col-sm-3 form-label align-self-start mb-lg-0 text-end">Բովանդակություն<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-9">
                                <div class="image_preview banner-type">
                                    <input type="file" name="media" class="form-control img_with_preview">
                                    <div class="preview" style="display: none">
                                        <img src="#" class="img_preview">
                                    </div>
                                </div>
                                <div class="banner-type" style="display: none">
                                    <textarea name="" id="banner-tiny" class="tinymce"></textarea>
                                </div>
                                @if ($errors->has('media'))
                                    <span class="text-danger">
                                {{$errors->first('media') }}
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Կարգավիճակ<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-4">
                                <select class="form-select" name="status">
                                    <option value=0>{{\App\Enums\Status::inActive}}</option>
                                    <option value=1>{{\App\Enums\Status::active}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Բացել նոր էջում</label>
                            <div class="col-sm-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="new_tab" type="checkbox" role="switch" id="banner_swich" value=1>
                                    <label class="form-check-label" for="banner_swich"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">URL</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="{{old('url')}}" type="text" name="url">
                            </div>
                            </div>
                        </div>
                        @if ($errors->has('url'))
                            <span class="text-danger offset-md-2">
                                {{$errors->first('url') }}
                            </span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center offset-md-2 mt-4">
                        <a class="btn btn-secondary" href="{{route('admin.banners.index')}}">Չեղարկել</a>
                        <button type="submit" class="btn btn-primary">Հաստատել</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
