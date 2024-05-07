<div class="rate-item">
    <h5>Առաքման գումար <i class="fas fa-plus-square add-rate" data-url=""></i></h5>
    <table class="mt-3">
        <thead>
            <tr>
                <th class="pr-3">
                    Գնման արժեքը մեծ է․․․
                </th>
                <th class="pr-3">
                    Առաքման արժեքը
                </th>
            </tr>
        </thead>
        <tbody class="py-3 shipping-option">
            @if(!is_null($record))
                @foreach($record->areas[$k]->rates as $rate)
                    @include('admin.includes.option',['k' => $k,'rate' => $rate])
                @endforeach
            @endif
        </tbody>
    </table>
</div>
