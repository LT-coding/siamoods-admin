<div class="table-responsive">
    <table class="table text-center">
        <thead class="text-nowrap text-sm">
            <tr>
                <th class="text-left">Ապրանք</th>
                <th>Գին</th>
                <th>Զեղչված Գին</th>
                <th>Քանակ</th>
                <th>Չափս</th>
                <th>&nbsp Ընդհանուր</th>
            </tr>
        </thead>
        <tbody>
        @foreach($record->items as $item)
            <tr>
                <td class="text-left">
                    <a target="_blank" href="{{ $item->product->url }}">
                        <img src="{{ $item->product->general_image?->image_link }}" style="width: 50px" alt="{{ $item->product->item_name }}"/>
                        <span>{{ $item->product->item_name }}</span>
                    </a>
                </td>
                <td>{{ App\Models\Product::formatPrice($item->price) }}</td>
                <td>{{ App\Models\Product::formatPrice($item->discount_price) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->variation_haysell_id ? $item->product->variations()->where('variation_haysell_id',$item->variation_haysell_id)->first()?->variation?->title : '' }}</td>
                <td class="text-right">{{ App\Models\Product::formatPrice($item->quantity * $item->discount_price) }}</td>
            </tr>
        @endforeach
        @if($record->giftCard)
            <tr>
                <td class="text-left">Օնլայն Նվեր Քարտ ({{ $record->giftCard->unique_id }})</td>
                <td>{{ App\Models\Product::formatPrice($record->giftCard->amount) }}</td>
                <td>-</td>
                <td>1</td>
                <td>-</td>
                <td>{{ App\Models\Product::formatPrice($record->giftCard->amount) }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-5 offset-7">
        <table class="table text-right no-border">
            <tbody>
                <tr>
                    <td>Ընդհանուր:</td>
                    <td>{{ $record->giftCard ? App\Models\Product::formatPrice($record->giftCard->amount) : App\Models\Product::formatPrice($record->total) }}</td>
                </tr>
                <tr>
                    <td>Առաքում:</td>
                    <td>{{ $record->delivery_price > 0 ? App\Models\Product::formatPrice($record->delivery_price) : ' - '}}</td>
                </tr>
{{--                @if($orderData['gift_card'])--}}
{{--                    <tr>--}}
{{--                        <td>Նվեր քարտ ({{ $orderData['gift_card_code'] }}):</td>--}}
{{--                        <td class="right" data-ct-totals="shipping_cost"><span>{{number_format($orderData['gift_card'])}}</span>&nbsp;֏</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}
                <tr>
                    <td><h5>Ընդամենը:</h5></td>
                    <td class="text-success text-bold">{{ $record->giftCard ? App\Models\Product::formatPrice($record->giftCard->amount) : App\Models\Product::formatPrice($record->total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
