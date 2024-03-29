<li class="d-flex justify-content-between align-items-center py-2 level-item" data-id="{{$data_id}}" style="--i:{{$level*4+1}}0px">
    @if($next)
        <i class="fa-solid fa-circle-chevron-right cat-open cat-closed"></i>
    @else
        <i class="fa-solid fa-circle-minus"></i>
    @endif
    <div class="col-sm-8">
        <p class="mb-0">{{$menu->name_hy}}</p>
    </div>
    <div class="col-sm-2">
        <select class="form-select" name="status_{{$menu->id}}">
            <option @if($menu->status == '0') selected @endif value=0>{{\App\Enums\Status::inActive}}</option>
            <option @if($menu->status == '1') selected @endif value=1>{{\App\Enums\Status::active}}</option>
        </select>
    </div>
    <div class="col-sm-1">
        <input class="form-control" value="{{$menu->position}}" type="number" name="position_{{$menu->id}}">
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
