@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@php( $def_container_class = 'container-fluid' )

{{-- Default Content Wrapper --}}
<div class="content-wrapper {{ config('adminlte.classes_content_wrapper', '') }}">

    <div class="default-wrapper">
        {{-- Content Header --}}
        @hasSection('content_header')
            <div class="content-header">
                <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                    @yield('content_header')
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <div class="content">
            <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                @stack('content')
                @yield('content')
            </div>
        </div>
    </div>

</div>
