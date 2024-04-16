<li class="d-flex justify-content-between align-items-center py-2 level-item" data-id="{{$data_id}}" style="--i:{{ $level*4+1 }}0px">
    <div class="d-flex justify-content-between align-items-center gap-2 item-text">
        @if($next)
            <i class="fas fa-chevron-circle-down sub-open"></i>
        @else
            <i class="fas fa-minus-circle sub-item"></i>
        @endif
        <p class="mb-0">{{$category->name}}</p>
    </div>
   <div class="d-flex justify-content-between align-items-center">
       <a href="{{ route('admin.categories.edit',['category'=>$category->id]) }}" class="text-info mx-1" title="Խմբագրել"><i class="fa fa-lg fa-fw fa-pen"></i></a>
       <a href="#" data-action="{{ route('admin.categories.destroy',['category'=>$category->id]) }}" class="text-danger btn-remove" title="Հեռացնել"><i class="fa fa-lg fa-fw fa-trash"></i></a>
   </div>
</li>
