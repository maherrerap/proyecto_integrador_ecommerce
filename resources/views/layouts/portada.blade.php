<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'ColdMarket')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/coldmarket.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <header class="header-coldmarket">
        <nav class="navbar navbar-dark">
            <div class="container-fluid d-flex align-items-center justify-content-between px-4">

                <div class="d-flex align-items-center gap-4">
                    <a href="{{ route('portada.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('images/cold_tech_logo.png') }}" alt="coldmarket Logo" class="header-logo">
                    </a>

                    <ul class="navbar-nav flex-row align-items-center mb-0 gap-4">
                        <li class="nav-item">
                            <a class="nav-link nav-link-coldmarket fw-semibold"
                                href="{{ route('portada.index') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-coldmarket fw-semibold"
                                href="{{ route('producto.index') }}">Productos</a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link nav-link-coldmarket fw-semibold" href="{{ route('carrito.index') }}">
                                <i class="bi bi-cart3 fs-5"></i>
                                <span id="cart-count"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.65rem; display: none;">
                                    0
                                </span>
                                Carrito
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('login.index') }}" class="btn btn-login-header fw-semibold">Iniciar sesión</a>
                </div>
            </div>
        </nav>
    </header>

    {{-- Full-width content for landing page --}}
    @if(session('success'))
        <div class="alert alert-success container mt-4">{{session('success')}}</div>
    @endif
    @yield('contenido')

    <!-- FOOTER -->
    <footer class="footer-coldmarket">
        <div class="footer-container">
            <div class="footer-left">
                <p id="texto_footer">
                    © 2025 ColdMarket Inc. | Todos los Derechos Reservados
                </p>
            </div>

            <div class="footer-right">
                <a href="#" class="footer-social">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" height="30">
                    <span>cuenta_facebook</span>
                </a>

                <a href="#" class="footer-social">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram" height="30">
                    <span>cuenta_instagram</span>
                </a>

                <a href="#" class="footer-social">
                    <img src="{{ asset('images/X_logo.png') }}" alt="X" height="30">
                    <span>cuenta_X</span>
                </a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/carrito.js') }}"></script>
</body>

</html>