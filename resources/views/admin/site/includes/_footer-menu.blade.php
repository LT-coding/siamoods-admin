@php $statuses = \App\Enums\StatusTypes::statusList() @endphp
<h4>Footer Menus <a href="#add_menu" class="btn btn-primary btn-sm" title="Add" data-toggle="collapse" data-target="#add_menu"><i class="fa fa-lg fa-fw fa-plus"></i></a></h4>
<div class="row mt-3">
    <div class="col-md-6{{ count($footerMenus) == 0 ? ' d-none' : '' }}">
        @foreach($footerMenus as $menu)
            <form method="post" action="{{ route('admin.footer-menu.update') }}">
                @csrf
                <input name="id" value="{{ $menu->id }}" type="hidden"/>
                <div class="card card-olive card-outline{{ $errors->has($menu->id.'_menu_title') ? '' : ' collapsed-card' }}">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ $menu->menu_title }}</h3>
                        <span class="float-right">
                            {!! \App\Enums\StatusTypes::statusText($menu->status) !!}
                            <button type="button" class="btn btn-tool text-olive ml-4 mx-1 p-0" title="Edit" data-card-widget="collapse"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                            <button type="button" class="btn btn-tool text-danger btn-remove p-0" title="Delete" data-action="{{ route('admin.footer-menu.destroy',['id'=>$menu->id]) }}"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </span>
                    </div>
                    <div class="card-body" style="{{ $errors->has($menu->id.'_menu_title') ? 'display: block;' : 'display: none;' }}">
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="{{ $menu->id }}_menu_title" label="{{ __('Menu Title') }}" value="{{ old($menu->id.'_menu_title') ?? $menu->menu_title }}"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="{{ $menu->id }}_order" label="{{ __('Menu Order') }}" value="{{ old($menu->id.'_order') ?? $menu->order }}" type="number" min="0"/>
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-select name="{{ $menu->id }}_status" label="Status">
                                    <x-adminlte-options :options="$statuses" :selected="old($menu->id.'_status') ?? [$menu->status]"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <hr>
                        <h6>{{ __('Menu Items') }}</h6>
                        @for($k=0; $k<5; $k++)
                            @if(isset($menu->items[$k]))
                                <input name="{{ $menu->id }}_item_id" value="{{ $menu->items[$k]->id }}" type="hidden"/>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input name="{{ $menu->id }}_item_text[]" placeholder="Item Text"
                                                      value="{{ old($menu->id.'_item_text')[$k] ?? (isset($menu->items[$k]) ? $menu->items[$k]->item_text : null) }}"/>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="{{ $menu->id }}_item_link[]" placeholder="Item Link"
                                                      value="{{ old($menu->id.'_item_link')[$k] ?? (isset($menu->items[$k]) ? $menu->items[$k]->item_link : null) }}"/>
                                </div>
                                <div class="col-md-2">
                                    <x-adminlte-input name="{{ $menu->id }}_item_order[]" placeholder="Order"
                                                      value="{{ old($menu->id.'_order')[$k] ?? (isset($menu->items[$k]) ? $menu->items[$k]->order : null) }}" type="number" min="0"/>
                                </div>
                            </div>
                        @endfor
                        <div class="text-right">
                            <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
    <div class="col-md-6 mt-6 space-y-6">
        <div id="add_menu" class="collapse">
            <form method="post" action="{{ route('admin.footer-menu.store') }}">
                @csrf
                <div class="card card-olive card-outline">
                    <div class="card-header">
                        <h5>Add new menu</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="menu_title" label="{{ __('Menu Title') }}" value="{{ old('menu_title') }}"/>
                            </div>
                            <div class="col-md-4">
                                <x-adminlte-input name="order" label="{{ __('Menu Order') }}" value="{{ old('order') ?? 0 }}" type="number" min="0"/>
                            </div>
                            <div class="col-md-2">
                                <x-adminlte-select name="status" label="Status">
                                    <x-adminlte-options :options="$statuses" :selected="old('status')"/>
                                </x-adminlte-select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>{{ __('Menu Items') }}</h6>
                        @for($j=0; $j<5; $j++)
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-input name="item_text[]" placeholder="Item Text" value="{{ old('item_text')[$j] ?? null }}"/>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-input name="item_link[]" placeholder="Item Link" value="{{ old('item_link')[$j] ?? null }}"/>
                                </div>
                                <div class="col-md-2">
                                    <x-adminlte-input name="item_order[]" placeholder="Order" value="{{ old('order')[$j] ?? null }}" type="number" min="0"/>
                                </div>
                            </div>
                        @endfor
                        <div class="text-right">
                            <x-adminlte-button class="btn btn-success btn-flat" type="submit" label="Save" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
