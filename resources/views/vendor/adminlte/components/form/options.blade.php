{{-- Empty option --}}
@if(isset($emptyOption))

    <option value>
        {{ is_string($emptyOption) ? $emptyOption : '' }}
    </option>

{{-- Placeholder option --}}
@elseif(isset($placeholder))

    <option class="d-none" value>
        {{ is_string($placeholder) ? $placeholder : '' }}
    </option>

@endif

{{-- Other options --}}
@foreach($options as $key => $value)
    <option value="{{ $key }}"
        @if($isSelected($key)) selected @endif
        @if($isDisabled($key)) disabled @endif
        @if($attributes->get('data-s'))
            @php $s = $attributes->get('data-s'); @endphp
            @if(
                ($s != 5 && $key == '5')
                || ($s == 2 && ($key == '1' || $key == '4'))
                || ($s == 3 && ($key == '1' || $key == '2' || $key == '4'))
                || ($s == 4 && ($key == '1' || $key == '2' || $key == '3'))
            )
                disabled
            @endif
        @endif
    >
        {{ $value }}
    </option>

@endforeach
