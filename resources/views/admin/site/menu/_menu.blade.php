<li class="d-flex justify-content-between align-items-center py-2 level-item" data-id="{{$data_id}}" style="--i:{{ $level*4+1 }}0px">
    @if($next)
        <i class="fas fa-check-circle"></i>
    @else
        <i class="fas fa-minus-circle"></i>
    @endif
    <div class="col-sm-8">
        <p class="mb-0">{{$menu->name_hy}}</p>
    </div>
    <div class="col-sm-2">
        <x-adminlte-select name="status_{{$menu->id}}">
            <x-adminlte-options :options="\App\Enums\StatusTypes::statusList()" :selected="$menu->status"/>
        </x-adminlte-select>
    </div>
    <div class="col-sm-1">
        <x-adminlte-input type="number" name="position_{{$menu->id}}" value="{{ $menu->position }}"/>
    </div>
{{--   <div class="d-flex justify-content-between align-items-center">--}}
{{--       <a href="{{route('admin.menus.edit',[$menu])}}">--}}
{{--           <i class="fa-solid fa-pen-to-square"></i>--}}
{{--       </a>--}}
{{--       <form action="{{route('admin.menus.destroy',[$menu])}}" method="POST" class="delete-form">--}}
{{--           @csrf()--}}
{{--           @method('DELETE')--}}
{{--           <button type="submit" class="bg-white border-0">--}}
{{--               <i class="fa-solid fa-trash"></i>--}}
{{--           </button>--}}
{{--       </form>--}}
{{--   </div>--}}
</li>
