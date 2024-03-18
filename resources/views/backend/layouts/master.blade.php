<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | Complejo Deportivo</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/app.css?v=2') }}">
    @yield('css')
</head>

<body>
    <div class="lds-roller" style="display: none;">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('favicon.png') }}" alt="Logo {{ config('app.name') }}"
                height="80" width="80">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        Mi Cuenta
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('change_password_view') }}" class="dropdown-item">
                            <i class="fas fa-lock"></i>
                            Cambiar contraseña
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="fas fa-power-off"></i>
                            Cerrar sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="{{ route('admin.home') }}" class="brand-link">
                <img src="{{ asset('favicon.png') }}" alt="Logo {{ config('app.name') }}"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/backend/img/user.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <p class="d-block" style="color: #c2c7d0;">{{ request()->user()->name }}</p>
                    </div>
                </div>

                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.home') }}" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @foreach ($permissionMenus as $permissionMenu)
                            @if ($permissionMenu->id != 1)
                                <li
                                    class="nav-item {{ $permissionMenu->permissions->contains('route_name', Route::currentRouteName()) ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-bars"></i>
                                        <p>
                                            {{ $permissionMenu->name }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($permissionMenu->permissions as $permission)
                                            @if ($permission->menu_item)
                                                @if (request()->user()->hasPermission($permission->route_name))
                                                    <li class="nav-item">
                                                        <a href="{{ route($permission->route_name) }}"
                                                            class="nav-link {{ Route::is(strtok($permission->route_name, '.') . '.*') ? 'active' : '' }}">
                                                            <i class="{{ $permission->icon }} nav-icon"></i>
                                                            <p>{{ $permission->label }}</p>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            <strong>© {{ Carbon\Carbon::now()->year }} El Calccio.</strong>
            Todos los derechos reservados.
        </footer>
    </div>

    <!-- Scripts -->
    @routes
    <script src="{{ asset('assets/backend/js/app.js?v=2') }}"></script>
    @yield('scripts')
</body>

</html>
