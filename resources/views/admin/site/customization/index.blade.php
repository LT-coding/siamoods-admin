@extends('adminlte::page')
@section('title', 'Ադմինիստրացիա')

@section('content')
    <ul class="nav nav-pills mb-3" id="pills-customization" role="tablist">
        @foreach(\App\Enums\CustomizationPosition::positions() as  $k=>$position)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{$k==0? 'active': ''}}" id="pills-{{$k}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$k}}" type="button" role="tab" aria-controls="pills-{{$k}}" aria-selected="{{$k==0?'true':'false'}}">{{$position}}</button>
            </li>
        @endforeach
    </ul>
    <form action="{{route('admin.customization.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="tab-content card p-3 col-md-8" id="pills-customization-content">
            <div class="tab-pane fade show active" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab">
                <div class="mb-3">
                    <div class="row">
                        <label class="col-sm-2 form-label align-self-start mb-lg-0 text-end">Լոգո</label>
                        <div class="col-sm-10">
                            <div class="image_preview">
                                <div class="input-group ">
                                    <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                    <input type="file" class="form-control img_with_preview"  name="0[logo][logo]" >
                                </div>
                                @php
                                    $logo=\App\Models\Customization::where('name','logo')->first()
                                @endphp
                                <div class="preview" style="{{!($logo&&$logo?->value)?'display: none;':''}} width:200px">
                                    <img src="{{$logo?$logo?->value:''}}" class="img_preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="mb-3">--}}
{{--                    <div class="row">--}}
{{--                        <label class="col-sm-2 form-label align-self-start mb-lg-0 text-end">Favicon</label>--}}
{{--                        <div class="col-sm-10">--}}
{{--                            <div class="image_preview">--}}
{{--                                <div class="input-group ">--}}
{{--                                    <span class="input-group-text"><i class="fa-solid fa-image"></i></span>--}}
{{--                                    <input type="file" class="form-control img_with_preview" name="0[favicon][favicon]" >--}}
{{--                                </div>--}}
{{--                                @php--}}
{{--                                    $favicon=\App\Models\Customization::where('name','favicon')->first()--}}
{{--                                @endphp--}}
{{--                                <div class="preview" style="{{!($favicon&&$favicon?->value)?'display: none;':''}} width:200px">--}}
{{--                                    <img src="{{$favicon?$favicon?->value:''}}" class="img_preview">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="tab-pane fade" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                <div class="mb-3">
                    <div class="row">
                        <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Հեղինակային իրավունք</label>
                        <div class="col-sm-9">
                            @php
                                $copyright=\App\Models\Customization::where('name','copyright')->first()
                            @endphp
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-sharp fa-solid fa-paragraph"></i></span>
                                <input class="form-control" type="text" name="1[copyright][copyright]" value="{{$copyright?->value}}">
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="mb-3 mt-4">--}}
{{--                    <div class="row">--}}
{{--                        <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Գաղտնիության քաղաքականություն</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            @php--}}
{{--                                $privacy=\App\Models\Customization::where('name','privacy')->first()--}}
{{--                            @endphp--}}
{{--                            <div class="input-group">--}}
{{--                                <span class="input-group-text"><i class="fa-solid fa-link"></i></span>--}}
{{--                                <input class="form-control" type="text" name="1[privacy][privacy]" value="{{$privacy?->value}}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="mb-3 mt-4">
                    <h4> Սոցիալական ցանցեր <i class="ml-2 fa-solid fa-square-plus add-social" data-url="{{route('admin.customization.socials','')}}"></i></h4>
                    <div class="col-md-9 offset-md-3">
                        <table class="socials">
                            @if($socials)
                                @foreach($socials as $i=>$social)
                                    @include('admin.site.customization.social',[$social,$i])
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                @for($i=0;$i<3;$i++)
                    @include('admin.site.customization.item',['i'=>$i])
                @endfor
            </div>
            <div class="d-flex justify-content-end align-items-center offset-md-2 mt-4">
                <button type="submit" class="btn btn-primary">Հաստատել</button>
            </div>
        </div>
    </form>
@endsection
