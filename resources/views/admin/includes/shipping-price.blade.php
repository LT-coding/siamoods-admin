<div class="rate-item">
    <h5>Առաքման գումար <i class="fas fa-plus-square add-rate ml-3"  data-url="{{ route('admin.shipping.range','') }}"></i></h5>
    <table class="mt-3">
        <thead>
            <tr>
                <th class="pr-3">Գնման արժեքը մեծ է․․․</th>
                <th class="pr-3">Առաքման արժեքը</th>
            </tr>
        </thead>
        <tbody class="py-3 shipping-option">
            @if($record)
                @foreach($record->areas[$k]->rates as $rate)
                    @include('admin.includes.shipping-option',['k' => $k,'rate' => $rate])
                @endforeach
            @endif
        </tbody>
    </table>
</div>
