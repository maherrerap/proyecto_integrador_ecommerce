<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo','ColdMarket')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/coldtech.css') }}">
</head>
<body>
<header class="header-coldtech">
    <nav class="navbar navbar-dark">
        <div class="container-fluid d-flex align-items-center justify-content-between px-4">

            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('portada.index') }}" class="d-flex align-items-center">
                    <img src="{{ asset('images/cold_tech_logo.png') }}" alt="ColdTech Logo" class="header-logo">
                </a>

                <ul class="navbar-nav flex-row align-items-center mb-0 gap-4">
                    <li class="nav-item">
                        <a class="nav-link nav-link-coldtech fw-semibold" href="{{ route('portada.index') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-coldtech fw-semibold" href="{{ route('producto.index') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-coldtech fw-semibold" href="{{ route('contacto.index') }}">Contáctanos</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('carrito.index') }}" class="nav-link text-light fw-semibold d-flex align-items-center" style="font-size:14px;">
                            <img src="{{ asset('images/carrito.png') }}" alt="Carrito" style="height:22px; width:22px; margin-right:6px;">
                            Carrito
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form class="search-container" role="search">
                    <input type="text" class="search-input" placeholder="Buscar producto, categoría o marca..." aria-label="Buscar producto">
                    <button type="submit" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <a href="{{ route('login.index') }}" class="btn btn-login-header fw-semibold">Iniciar sesión</a>
            </div>
        </div>
    </nav>
</header>



<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
    @yield('contenido')
</div>
<!-- FOOTER -->
<footer class="footer-coldtech">
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
</body>
</html>
