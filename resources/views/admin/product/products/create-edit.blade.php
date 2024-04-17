@extends('adminlte::page')

@section('title', $record ? 'Խմբագրել ապրանքը' . ' | ' . $record->item_name : 'Ավելացնել ապրանք')

@section('content_header')
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="/">Գլխավոր</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Ապրանքներ</a></li>
        <li class="breadcrumb-item active">{{ $record ? 'Խմբագրել ապրանքը' : 'Ավելացնել ապրանք' }}</li>
    </ol>
    <h1 class="mb-2">{{ $record ? 'Խմբագրել ապրանքը' . ' | ' . $record->item_name : 'Ավելացնել ապրանք' }}</h1>
@stop

@section('content')
    <form action="{{ $record ? route('admin.products.update',['product'=>$record->id]) : route('admin.products.store') }}" method="post">
        <div class="row">
            <div class="col-md-7">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        @csrf
                        @if($record)
                            @method('PUT')
                            <input name="id" type="hidden" value="{{ $record->id }}"/>
                        @endif
                        <input type="hidden" name="gift" id='gift_val' value="{{ $record?->gift?->product?->haysell_id }}">
                        <dl class="row mb-5">
                            <dt class="col-sm-4">Անուն</dt>
                            <dd class="col-sm-8">{{ $record->item_name }}</dd>
                            <dt class="col-sm-4">Կատեգորիա</dt>
                            <dd class="col-sm-8">{{ $record->category?->name }}</dd>
                            <dt class="col-sm-4">Գին (֏)</dt>
                            <dd class="col-sm-8">{{ $record->price?->price ?? 0 }}</dd>
                            <dt class="col-sm-4">Քանակ</dt>
                            <dd class="col-sm-8">{{ $record->balance?->balance ?? 0 }}</dd>
                        </dl>
                        <h5>Մանրամասն նկարագրություն</h5>
                        <dl class="row mb-5">
                            @foreach(\App\Models\Product::detailsList() as $key=>$detail)
                                <dt class="col-sm-4">{{ $detail['name'] }}</dt>
                                <dd class="col-sm-8">{!! $record->productDetails->where('detail_id',$key)->first()?->value ?? '-' !!}</dd>
                            @endforeach
                        </dl>
                        <h5>Դասակարգիչներ</h5>
                        <dl class="row mb-5">
                            @foreach($generals as $general)
                                @php $cats = $record->categories()->where('categories.general_category_id',$general->id)->orderBy('sort')->pluck('name')->toArray() @endphp
                                @if(count($cats) > 0)
                                    <dt class="col-sm-4">{{ $general->title }}</dt>
                                    <dd class="col-sm-8">{{ implode(', ', $cats) }}</dd>
                                @endif
                            @endforeach
                        </dl>
                        <h5>Վարիացիաներ</h5>
                        <dl class="row mb-5">
                            @foreach($record->variations as $variation)
                                <dt class="col-sm-4"><img src="{{ $variation->image }}" alt="Variant image" style="max-height: 120px;"></dt>
                                <dd class="col-sm-8">Բնութագրիչ - {{ $variation->variation?->variation_type->title }}<br>
                                    Տեսակ - {{ $variation->variation?->title }}<br>
                                    Գին (֏) - {{ $variation->prices?->first()?->price ?? 0 }}<br>
                                    Քանակ - {{ $variation->balance }}
                                </dd>
                            @endforeach
                        </dl>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="text-right">
                            <x-adminlte-input-switch name="liked" label="ՍԻՐՎԱԾ ԶԱՐԴԵՐ" :checked="old('liked') ?? $record && $record->liked == 1"/>
                        </div>
                        <h5>Նվեր <a href="#" class="remove-gift ml-5" title="Հեռացնել նվերը"><i class="fas fa-times"></i></a></h5>
                        <x-adminlte-input name="gift_text" id="gift" value="{{ $record?->gift?->product?->item_name }}" data-url="{{route('admin.product.search','')}}"/>
                        <div id="gift_types" class="mb-3"></div>
                        @if(count($labels) > 0)
                            <h5>Պիտակ <a href="#" class="remove-label ml-5" title="Հեռացնել պիտակը"><i class="fas fa-times"></i></a></h5>
                            <div class="row mb-3 labels-list">
                                @foreach($labels as $label)
                                    <label for="label-{{ $label->id }}" class="col-md-4 d-flex" title="{{ $label->name }}">
                                        <div class="card label-display{{ $record && $record->label && $record->label->label_id == $label->id ? ' active' : '' }}">
                                            <div class="pr-label label-position-{{ $label->position }}">
                                                <div class="preview-label" style="display: {{ $label->type !=0 ? 'none' : 'block' }}">
                                                    <img src="{{ $label->type == 0 && !$label->media_json ? $label->media : '#'}}" class="img_preview-label" alt="label">
                                                </div>
                                                <div class="preview-text" style="display:{{ $label->type == 0 ? 'none' :'block' }}">
                                                    <p class="lb-text" style="color: {{ $label->media_json ? $label->media_json->color:''}}; background-color: {{ $label->media_json ? $label->media_json->background_color : '' }}">{{ $label->media_json ? $label->media_json->text : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <x-adminlte-input type="radio" name="label_id" id="label-{{ $label->id }}" value="{{ $label->id }}" data-required="true" data-checked="{{ $record && $record->label && $record->label->label_id == $label->id ? 'true' : '' }}"/>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        <h5>Մետա տեղեկատվություն</h5>
                        <x-adminlte-input name="meta_url" label="URL" value="{{ old('meta_url') ?? ($record ? $record->meta_url : '') }}" data-readonly="true"/>
                        <x-adminlte-input name="meta_title" label="Մետա վերնագիր" value="{{ old('meta_title') ?? ($record ? $record->meta_title : '') }}"/>
                        <x-adminlte-input name="meta_keywords" label="Մետա բանալի բառեր" value="{{ old('meta_keywords') ?? ($record ? $record->meta_keywords : '') }}"/>
                        <x-adminlte-textarea name="meta_description" label="Մետա նկարագրություն">{{ old('meta_description') ?? ($record ? $record->meta_description : '') }}</x-adminlte-textarea>
                        <div class="text-right">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm mr-3">Չեղարկել</a>
                            <x-adminlte-button class="btn-sm" type="submit" label="Պահպանել" theme="outline-danger" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

