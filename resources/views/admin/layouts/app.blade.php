<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo','Administracion')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/coldtech.css') }}">
</head>
<body>
<header class="header-coldtech">
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid px-4">

            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center">
                <img src="{{ asset('images/cold_tech_logo.png') }}" alt="ColdTech Logo" class="header-logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#coldtechNavbar"
                    aria-controls="coldtechNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="coldtechNavbar">
                <ul class="navbar-nav ms-lg-4 me-auto mb-2 mb-lg-0 gap-lg-4">
                    <li class="nav-item">
                        <a class="nav-link nav-link-coldtech fw-semibold" href="{{ route('admin.dashboard') }}">Inicio</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-coldtech fw-semibold dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Administración
                        </a>

                        <ul class="dropdown-menu admin-dropdown">
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle" href="#">Bodega</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.productos.index') }}">Productos</a></li>
                                    <li><a class="dropdown-item" href="#">Recepciones</a></li>
                                </ul>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle" href="#">Facturación</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.clientes.index') }}">Clientes</a></li>
                                    <li><a class="dropdown-item" href="#">Facturas</a></li>
                                </ul>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle" href="#">Compras</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Proveedores</a></li>
                                    <li><a class="dropdown-item" href="#">Órdenes de Compra</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-coldtech fw-semibold" href="#">Contáctanos</a>
                    </li>
                </ul>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
