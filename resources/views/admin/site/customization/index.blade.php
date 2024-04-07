@extends('adminlte::page')

@section('title', 'Կարգավորումներ')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item active">Կարգավորումներ</li>
    </ol>
    <h1 class="mb-2">Կարգավորումներ</h1>
@stop

@section('content')
    <div class="card card-danger card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs customization-tabs" id="tab" role="tablist">
                @foreach(\App\Enums\CustomizationPosition::positions() as  $k=>$position)
                    <li class="nav-item">
                        <a class="nav-link{{ $k == 0 ? ' active' : '' }}" id="{{$k}}-tab" data-toggle="pill" href="#tab-{{$k}}" role="tab">{{ $position }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="tabContent">
                <form action="{{route('admin.customization.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="page" id="page" type="hidden" value="0"/>

                    <div class="tab-content card p-3 col-md-8" id="tab-customization-content">
                        <div class="tab-pane fade show active" id="tab-0" role="tabpanel" aria-labelledby="tab-0-tab">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="col-sm-2 form-label align-self-start mb-lg-0 text-end">Լոգո</label>
                                    <div class="col-sm-10">
                                        <div class="image_preview">
                                            <x-adminlte-input type="file" name="0[logo][logo]"/>
                                            @php
                                                $logo=\App\Models\Customization::query()->where('name','logo')->first()
                                            @endphp
                                            <div class="preview" style="{{!($logo&&$logo?->value)?'display: none;':''}} width:200px">
                                                <img src="{{$logo?$logo?->value:''}}" class="img_preview" alt="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="tab-1-tab">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="col-sm-3 form-label align-self-center mb-lg-0 text-end">Հեղինակային իրավունք</label>
                                    <div class="col-sm-9">
                                        @php
                                            $copyright=\App\Models\Customization::query()->where('name','copyright')->first()
                                        @endphp
                                        <x-adminlte-input name="1[copyright][copyright]" value="{{ $copyright?->value }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-4">
                                <h4>Սոցիալական ցանցեր <i class="ml-2 fa-solid fa-square-plus add-social" data-url="{{route('admin.customization.socials','')}}"></i></h4>
                                <div class="col-md-9 offset-md-3">
                                    <div class="socials">
                                        @if($socials)
                                            @foreach($socials as $i => $social)
                                                @include('admin.site.customization.social',[$social,$i])
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2-tab">
                            @for($i=0; $i<3; $i++)
                                @include('admin.site.customization.item',['i'=>$i])
                            @endfor
                        </div>
                        <div class="text-right">
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
