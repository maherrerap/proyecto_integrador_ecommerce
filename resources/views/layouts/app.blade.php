<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- UX FIX #8: Eliminar título duplicado --}}
    <title>@yield('titulo', 'ColdMarket')</title>
    {{-- Favicon - Logo de Cold Market en la pestaña del navegador --}}
    <link rel="icon" type="image/png" href="{{ asset('images/cold_tech_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/coldmarket.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>

    <header class="header-coldmarket">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="{{ route('portada.index') }}" class="navbar-brand">
                    <img src="{{ asset('images/cold_tech_logo.png') }}" alt="coldmarket Logo" class="header-logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link nav-link-coldmarket" href="{{ route('portada.index') }}">
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-coldmarket" href="{{ route('producto.index') }}">
                                Productos
                            </a>
                        </li>

                        @if(session('autenticado'))
                            <li class="nav-item position-relative">
                                <a class="nav-link nav-link-coldmarket" href="{{ route('carrito.index') }}">
                                    <i class="bi bi-cart3"></i>
                                    <span id="cart-count"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="display: none;">
                                        0
                                    </span>
                                    <span class="d-lg-inline">Carrito</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            @if(session('autenticado'))
                                <div class="dropdown">
                                    <a class="nav-link nav-link-coldmarket dropdown-toggle d-flex align-items-center gap-2"
                                        href="#" role="button" id="userDropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-person-circle"></i>
                                        <span class="d-none d-lg-inline">{{ session('nombreCliente') }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end admin-dropdown"
                                        aria-labelledby="userDropdown">
                                        <li>
                                            <form action="{{ route('auth.logout') }}" method="POST" id="logoutForm">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('auth.login') }}" class="btn btn-login-header btn-sm">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    <span class="d-lg-inline">Iniciar sesión</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('contenido')
    </div>

    <!-- FOOTER -->
    <footer class="footer-coldmarket">
        <div class="footer-container">
            <div class="footer-left">
                <p id="texto_footer">
                    © 2026 ColdMarket Inc. | Todos los Derechos Reservados
                </p>
            </div>

            <div class="footer-right">
                {{-- UX FIX #11: Remover texto técnico de placeholder --}}
                <a href="#" class="footer-social" aria-label="Facebook">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" height="30">
                </a>

                <a href="#" class="footer-social" aria-label="Instagram">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram" height="30">
                </a>

                <a href="#" class="footer-social" aria-label="Twitter/X">
                    <img src="{{ asset('images/X_logo.png') }}" alt="X" height="30">
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- FIX: Cargar carrito.js SIEMPRE para que el botón añadir funcione incluso sin login --}}
    <script src="{{ asset('js/carrito.js') }}?v={{ time() }}"></script>

    @stack('scripts')
</body>


</html>