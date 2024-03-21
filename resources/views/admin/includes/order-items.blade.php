@foreach($record->items as $item)
    <div class="card card-body card-outline p-2">
        <input name="item_id[]" type="hidden" value="{{ $item->id }}"/>
        <div class="row mb-0">
            <div class="col-sm-12">
                <h5 class="text-bold">{{ $item->variant->title }}</h5>
                <div class="row">
                    <div class="col-md-5">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Size</dt>
                            <dd class="col-sm-8">{{ $item->size->sizeName }}</dd>
                            @if($item->color)
                                <dt class="col-sm-4">Color</dt>
                                <dd class="col-sm-8">{{ $item->colorOption->value }}</dd>
                            @endif
                            @if($item->relatedProduct)
                                <dd class="col-md-12">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Related Product</dt>
                                        <dd class="col-sm-8 d-flex justify-center"><img src="{{ $item->relatedProduct->image_link }}" alt="{{ $item->relatedProduct->title }}"
                                                                  style="max-height:70px;display:inline-block;margin-right:5px;">{{ $item->relatedProduct->title }}</dd>
                                    </dl>
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <h5>Shipping Information</h5>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Shipping Method</dt>
                            <dd class="col-sm-7">{{ $item->shipping->title }}</dd>
                        </dl>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Rush Service</dt>
                            <dd class="col-sm-7">{{ $item->rushService ? $item->rushService->service_days . ' Days ('.$item->rush_date.')' : '-' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-select name="status_{{ $item->id }}" label="Order Item Status">
                            <x-adminlte-options :options="$itemStatuses" :selected="old('status_'.$item->id) ?? [$item->status]"/>
                        </x-adminlte-select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if($item->options)
                    <a href="#view_options_{{ $item->id }}" class="btn btn-secondary btn-sm mb-2" title="View Options" data-toggle="collapse" data-target="#view_options_{{ $item->id }}">View Options</a>
                    <dl class="row mb-0 collapse" id="view_options_{{ $item->id }}">
                        @foreach(json_decode($item->options) as $val)
                            @php $value = \App\Models\OptionValue::query()->find($val->id) @endphp
                            <dt class="col-sm-4">{{ $value->variantOption->option->title }}</dt>
                            <dd class="col-sm-8">{{ $value->value . ' (' .$record->currency.\App\Models\Product::formatPrice($val->additional_price) . ')' }}</dd>
                        @endforeach
                    </dl>
                @endif
                <div class="table table-responsive">
                    <table>
                        <tr>
                            <th>Quantity</th>
                            <th>Item Price</th>
                            <th>Discount (%)</th>
                            <th>Discount Price</th>
                            <th>Shipping</th>
                            <th>Rush Service</th>
                            <th>Related Product</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->item_price) }}</td>
                            <td>{{ $item->discount_percent ?? 0 }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->discount_price) }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->shipping_price) }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->rush_service_price) }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->related_price) }}</td>
                            <td>{{ $record->currency.\App\Models\Product::formatPrice($item->total) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <a href="#view_images_{{ $item->id }}" class="btn btn-secondary btn-sm" title="View Images" data-toggle="collapse" data-target="#view_images_{{ $item->id }}">View Images</a>
        <div class="row mb-0 collapse" id="view_images_{{ $item->id }}">
            @foreach($item->variant->images as $image)
                <div class="col-md-2">
                    <img src="{{ $image->image_link }}" alt="{{ $item->variant->title }}" />
                </div>
            @endforeach
        </div>
    </div>
@endforeach
