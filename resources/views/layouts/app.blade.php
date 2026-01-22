<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- UX FIX #8: Eliminar título duplicado --}}
    <title>@yield('titulo', 'ColdMarket')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/coldmarket.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>

    <header class="header-coldmarket">
        <nav class="navbar navbar-dark">
            <div class="container-fluid d-flex align-items-center justify-content-between">

                <!-- Logo y navegación principal -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('portada.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('images/cold_tech_logo.png') }}" alt="coldmarket Logo" class="header-logo">
                    </a>

                    <ul class="navbar-nav flex-row align-items-center mb-0">
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
                                    Carrito
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Usuario / Login -->
                <div class="d-flex align-items-center">
                    @if(session('autenticado'))
                        <!-- Usuario autenticado -->
                        <div class="dropdown">
                            <a class="nav-link nav-link-coldmarket dropdown-toggle d-flex align-items-center gap-2" href="#"
                                role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ session('nombreCliente') }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end admin-dropdown" aria-labelledby="userDropdown">
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
                        <!-- Usuario NO autenticado -->
                        <a href="{{ route('auth.login') }}" class="btn btn-login-header">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Iniciar sesión</span>
                        </a>
                    @endif
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

    @if(session('autenticado'))
        <script src="{{ asset('js/carrito.js') }}"></script>
    @endif

    @stack('scripts')
</body>


</html>