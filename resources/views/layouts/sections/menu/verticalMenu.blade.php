@php
    $userRoles = auth()->user()->roles->pluck('name')->toArray(); // Obtener roles del usuario
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Oleo+Script:wght@400;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<style>
  .trash{
    font-family: "Oleo Script", system-ui;
  }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span style="margin-top:2rem;" class="app-brand-text demo menu-text fw-bold ms-2">
                    <p class="trash" style>Trash2cash</p>
                </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
                <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
            </a>
        </div>
    @endif

    @if (!isset($navbarFull))
        <div class="menu-divider mt-0 "></div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            @if (isset($menu->roles) && !empty(array_intersect($menu->roles, $userRoles)))
                {{-- adding active and open class if child is active --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();

                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        } else {
                            if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                    </a>

                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>
</aside>
