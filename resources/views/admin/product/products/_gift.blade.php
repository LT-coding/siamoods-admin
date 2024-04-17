<div class="card product-gifts">
    @if(count($items) > 0)
        <ul class="mb-0 prod-gift">
            @foreach ($items as $item)
                <li data-id="{{ $item['id'] }}" class="d-flex justify-content-start align-items-center border">
                    <img src="{{ $item['image'] }}" alt="Product Image" width="70px">
                    <p class="mb-0">{{ $item['name'] }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <div class="d-flex justify-content-center align-items-center my-5 text-danger fs-4 product-zero">
            Ապրանքներ չեն գտնվել
        </div>
    @endif
</div>
