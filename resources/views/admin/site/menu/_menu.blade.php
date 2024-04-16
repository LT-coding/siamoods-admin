<li class="d-flex justify-content-between align-items-center py-2 level-item" data-id="{{$data_id}}" style="--i:{{ $level*4+1 }}0px">
    <div class="d-flex justify-content-between align-items-center gap-2 item-text">
        @if($next)
            <i class="fas fa-chevron-circle-down sub-open"></i>
        @else
            <i class="fas fa-minus-circle sub-item"></i>
        @endif
        <p class="mb-0">{{$menu->name_hy}}</p>
    </div>
    <div class="d-flex justify-content-between align-items-center gap-2">
        <x-adminlte-select name="status_{{$menu->id}}">
            <x-adminlte-options :options="\App\Enums\StatusTypes::statusList()" :selected="$menu->status"/>
        </x-adminlte-select>
        <div style="width: 75px">
            <x-adminlte-input type="number" name="position_{{$menu->id}}" value="{{ $menu->position }}"/>
        </div>
    </div>
</li>
