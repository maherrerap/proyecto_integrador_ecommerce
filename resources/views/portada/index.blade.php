@extends('layouts.portada')

@section('contenido')
    <section class="hero-section position-relative"
        style="height: 90vh; overflow: hidden; width: 100%; margin: 0; padding: 0;">
        <div class="hero-image position-absolute w-100 h-100" style="background-image: url('{{ asset('images/hero-background.jpg') }}'); 
                                background-size: cover; 
                                background-position: center; 
                                z-index: 0;">
        </div>

        <div class="hero-overlay position-absolute w-100 h-100"
            style="background: linear-gradient(135deg, rgba(10, 26, 47, 0.85) 0%, rgba(0, 61, 130, 0.75) 100%); z-index: 1;">
        </div>

        <div class="position-absolute top-50 start-50 translate-middle"
            style="z-index: 1; opacity: 0.1; width: 60%; max-width: 600px; pointer-events: none;">
            <img src="{{ asset('images/cold_tech_logo.png') }}" alt="Cold Market Watermark" class="img-fluid"
                style="filter: grayscale(100%) brightness(200%); width: 100%;">
        </div>

        <div class="position-absolute" style="top: 3rem; left: 3rem; z-index: 3;">
            <img src="{{ asset('images/cold_tech_logo.png') }}" alt="Cold Market Logo" class="hero-logo"
                style="height: clamp(60px, 8vw, 100px); opacity: 0.95; filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));">
        </div>

        <div class="container-fluid position-relative h-100 d-flex align-items-center px-4 px-md-5" style="z-index: 2;">
            <div class="row w-100 justify-content-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="glass-card p-5 rounded-5" style="background: rgba(255, 255, 255, 0.05); 
                                            backdrop-filter: blur(20px); 
                                            -webkit-backdrop-filter: blur(20px);
                                            border: 1px solid rgba(255, 255, 255, 0.1);
                                            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                        <h1 class="display-3 fw-bold mb-4 text-white" style="font-size: clamp(2.5rem, 5vw, 4rem); 
                                               letter-spacing: -1px; 
                                               line-height: 1.1;
                                               text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                            Calidad y Frescura<br>
                            <span style="color: #00E0FF; text-shadow: 0 0 20px rgba(0, 224, 255, 0.3);">Para Tu Hogar</span>
                        </h1>

                        <p class="lead mb-5 text-white-50" style="font-weight: 300; 
                                              line-height: 1.8; 
                                              font-size: clamp(1.1rem, 2vw, 1.4rem);
                                              max-width: 800px;
                                              margin: 0 auto;">
                            Descubre la diferencia de los productos seleccionados con los más altos estándares.
                            Directamente a tu mesa con la garantía de <strong>Cold Market</strong>.
                        </p>

                        <div class="d-flex gap-3 justify-content-center flex-column flex-sm-row">
                            <a href="{{ route('producto.index') }}"
                                class="btn btn-lg px-5 py-3 rounded-pill btn-hero fw-bold" style="background: linear-gradient(90deg, #00C6FF 0%, #0072FF 100%); 
                                                  color: white; 
                                                  border: none; 
                                                  box-shadow: 0 10px 30px rgba(0, 114, 255, 0.4);">
                                Explorar Catálogo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white" style="width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <div class="row">
                <div class="col-lg-10 col-xl-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4" style="color: #0A1A2F; font-size: clamp(1.8rem, 4vw, 2.5rem);">
                        Quiénes Somos</h2>
                    <p class="lead text-muted mb-4" style="line-height: 1.9; font-size: clamp(1rem, 2vw, 1.2rem);">
                        En <strong style="color: #007BFF;">Cold Market</strong>, nos dedicamos a ofrecerte los mejores
                        productos frescos y de consumo diario. Somos tu aliado confiable para mantener tu hogar
                        abastecido con alimentos de calidad, garantizando frescura y los mejores precios del mercado.
                        Trabajamos con proveedores locales y nacionales para traerte productos que cumplen con
                        los más altos estándares.
                    </p>
                    <a href="#categorias" class="btn btn-outline-primary btn-lg px-4 px-md-5 rounded-pill">
                        Más información
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" style="width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/why-choose-us.jpg') }}" alt="Por qué elegirnos"
                        class="img-fluid rounded shadow-lg"
                        style="object-fit: cover; height: auto; min-height: 300px; max-height: 500px; width: 100%;">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4" style="color: #0A1A2F; font-size: clamp(1.5rem, 3vw, 2rem);">
                        Te proporcionamos un espacio confiable para tu compra diaria
                    </h2>
                    <p class="text-muted mb-4" style="line-height: 1.8; font-size: clamp(0.95rem, 1.8vw, 1.1rem);">
                        Todas nuestras compras se realizan en un entorno seguro, con productos verificados,
                        precios transparentes y atención personalizada. Nuestra tienda está ubicada en una zona
                        accesible con estacionamiento disponible, y también ofrecemos servicio de entrega a domicilio.
                    </p>
                    <p class="text-muted mb-4" style="line-height: 1.8; font-size: clamp(0.95rem, 1.8vw, 1.1rem);">
                        ¿No puedes venir a la tienda? No te preocupes; realizamos entregas rápidas y seguras
                        directamente a tu hogar.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="categorias" class="py-5 bg-white" style="width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <h2 class="text-center fw-bold mb-5" style="color: #0A1A2F; font-size: clamp(1.8rem, 4vw, 2.5rem);">Nuestras
                Categorías</h2>

            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center category-card"
                        style="border-radius: 15px; transition: all 0.3s ease; cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="category-icon mb-4" style="font-size: clamp(2.5rem, 5vw, 4rem);">
                                🍽️
                            </div>
                            <h4 class="card-title fw-bold mb-3"
                                style="color: #0A1A2F; font-size: clamp(1.1rem, 2vw, 1.3rem);">Alimentos</h4>
                            <p class="card-text text-muted"
                                style="line-height: 1.7; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                Productos frescos y de despensa, frutas, carnes, lácteos y víveres de primera calidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center category-card"
                        style="border-radius: 15px; transition: all 0.3s ease; cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="category-icon mb-4" style="font-size: clamp(2.5rem, 5vw, 4rem);">
                                👕
                            </div>
                            <h4 class="card-title fw-bold mb-3"
                                style="color: #0A1A2F; font-size: clamp(1.1rem, 2vw, 1.3rem);">Ropa</h4>
                            <p class="card-text text-muted"
                                style="line-height: 1.7; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                Prendas de vestir para toda la familia, con variedad de estilos y tallas disponibles.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center category-card"
                        style="border-radius: 15px; transition: all 0.3s ease; cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="category-icon mb-4" style="font-size: clamp(2.5rem, 5vw, 4rem);">
                                🔌
                            </div>
                            <h4 class="card-title fw-bold mb-3"
                                style="color: #0A1A2F; font-size: clamp(1.1rem, 2vw, 1.3rem);">Electrodomésticos</h4>
                            <p class="card-text text-muted"
                                style="line-height: 1.7; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                Equipos para el hogar, desde pequeños electrodomésticos hasta línea blanca de calidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center category-card"
                        style="border-radius: 15px; transition: all 0.3s ease; cursor: pointer;">
                        <div class="card-body p-4">
                            <div class="category-icon mb-4" style="font-size: clamp(2.5rem, 5vw, 4rem);">
                                🔧
                            </div>
                            <h4 class="card-title fw-bold mb-3"
                                style="color: #0A1A2F; font-size: clamp(1.1rem, 2vw, 1.3rem);">Ferretería</h4>
                            <p class="card-text text-muted"
                                style="line-height: 1.7; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                Herramientas, materiales de construcción y todo lo necesario para tus proyectos del hogar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('producto.index') }}" class="btn btn-lg px-4 px-md-5 rounded-pill"
                    style="background-color: #007BFF; color: white; border: none; font-size: clamp(0.9rem, 1.8vw, 1.1rem);">
                    Ver todos los productos
                </a>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" style="width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <h2 class="text-center fw-bold mb-5" style="color: #0A1A2F; font-size: clamp(1.8rem, 4vw, 2.5rem);">Productos
                Destacados</h2>

            <div class="row g-4 mb-5 justify-content-center">
                @forelse($productosDestacados as $producto)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm product-card"
                            style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                            <div class="product-image" style="height: 250px; overflow: hidden; background-color: #f8f9fa;">
                                @php
                                    $imagenPath = 'images/productos/' . $producto->id_producto . '.jpg';
                                @endphp
                                @if(file_exists(public_path($imagenPath)))
                                    <img src="{{ asset($imagenPath) }}" 
                                         alt="{{ $producto->pro_descripcion }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image" style="font-size: 3rem; color: white; opacity: 0.5;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body text-center p-4">
                                <h5 class="card-title fw-bold mb-2"
                                    style="color: #0A1A2F; font-size: clamp(1rem, 1.8vw, 1.2rem);">
                                    {{ $producto->pro_descripcion }}
                                </h5>
                                <p class="text-muted mb-3" style="font-size: clamp(0.85rem, 1.5vw, 0.95rem);">
                                    {{ $producto->categoria->cat_descripcion ?? 'Producto' }}
                                </p>
                                <p class="fw-bold" style="color: #007BFF; font-size: clamp(1.1rem, 2vw, 1.3rem);">
                                    ${{ number_format($producto->pro_precio_venta, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No hay productos disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('producto.index') }}" class="btn btn-outline-primary btn-lg px-4 px-md-5 rounded-pill"
                    style="font-size: clamp(0.9rem, 1.8vw, 1.1rem);">
                    Explorar más productos
                </a>
            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #f8f9fa; width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4 py-md-5">
            <div class="row">
                <div class="col-lg-10 col-xl-8 mx-auto">
                    <div class="text-center">
                        <blockquote class="blockquote mb-4">
                            <p class="fw-light mb-4"
                                style="line-height: 1.8; color: #0A1A2F; font-style: italic; font-size: clamp(1.1rem, 2.5vw, 1.5rem);">
                                "Gracias a Cold Market, encontré productos frescos de excelente calidad
                                a precios justos. El servicio de entrega es rápido y confiable.
                                Cold Market me ayudó a mantener mi hogar bien abastecido."
                            </p>
                        </blockquote>
                        <footer class="blockquote-footer mt-3">
                            <cite style="font-size: clamp(0.95rem, 1.8vw, 1.1rem); color: #6c757d;">
                                MARÍA G., CLIENTA DE COLD MARKET
                            </cite>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" style="width: 100%;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <h2 class="text-center fw-bold mb-3" style="color: #0A1A2F; font-size: clamp(1.8rem, 4vw, 2.5rem);">Sobre
                Nosotros</h2>
            <p class="text-center text-muted mb-5"
                style="font-size: clamp(1rem, 2vw, 1.2rem); max-width: 800px; margin-left: auto; margin-right: auto;">
                Somos un equipo apasionado dedicado a brindarte la mejor experiencia de compra
            </p>

            <div class="row g-4 justify-content-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm team-card"
                        style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="team-photo"
                            style="height: 280px; position: relative; overflow: hidden;">
                            <img src="{{ asset('images/jose.jpeg') }}" alt="Jose Zumarraga"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="fw-bold mb-3" style="color: #0A1A2F; font-size: clamp(1.2rem, 2vw, 1.4rem);">Jose
                                Zumarraga</h4>
                            <p class="text-muted mb-0"
                                style="font-style: italic; line-height: 1.6; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                "La innovación es la clave del éxito"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm team-card"
                        style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="team-photo"
                            style="height: 280px; position: relative; overflow: hidden;">
                            <img src="{{ asset('images/maria.jpeg') }}" alt="Maria Astudillo"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="fw-bold mb-3" style="color: #0A1A2F; font-size: clamp(1.2rem, 2vw, 1.4rem);">Maria
                                Astudillo</h4>
                            <p class="text-muted mb-0"
                                style="font-style: italic; line-height: 1.6; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                "La excelencia no es un acto, es un hábito"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm team-card"
                        style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="team-photo"
                            style="height: 280px; position: relative; overflow: hidden;">
                            <img src="{{ asset('images/martin.jpeg') }}" alt="Martin Herrera"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="fw-bold mb-3" style="color: #0A1A2F; font-size: clamp(1.2rem, 2vw, 1.4rem);">Martin
                                Herrera</h4>
                            <p class="text-muted mb-0"
                                style="font-style: italic; line-height: 1.6; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                "El trabajo en equipo hace que el sueño funcione"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm team-card"
                        style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                        <div class="team-photo"
                            style="height: 280px; position: relative; overflow: hidden;">
                            <img src="{{ asset('images/matheo.jpeg') }}" alt="Matheo Iza"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="fw-bold mb-3" style="color: #0A1A2F; font-size: clamp(1.2rem, 2vw, 1.4rem);">Matheo
                                Iza</h4>
                            <p class="text-muted mb-0"
                                style="font-style: italic; line-height: 1.6; font-size: clamp(0.9rem, 1.5vw, 1rem);">
                                "La pasión impulsa el progreso"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white" style="width: 100%; padding-bottom: 10rem !important;">
        <div class="container-fluid px-4 px-md-5 py-4">
            <h2 class="text-center fw-bold mb-5" style="color: #0A1A2F; font-size: clamp(1.8rem, 4vw, 2.5rem);">Nuestros
                Principios</h2>

            <div class="row g-4 justify-content-center">
                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm principle-card"
                        style="border-radius: 15px; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4 p-lg-5">
                            <div class="mb-4">
                                <i class="bi bi-bullseye"
                                    style="font-size: clamp(2.5rem, 5vw, 3.5rem); color: #007BFF;"></i>
                            </div>
                            <h3 class="card-title mb-4"
                                style="color: #0A1A2F; font-weight: 700; font-size: clamp(1.2rem, 2.5vw, 1.5rem);">Misión
                            </h3>
                            <p class="card-text text-muted"
                                style="line-height: 1.8; font-size: clamp(0.95rem, 1.8vw, 1.05rem);">
                                Proveer alimentos frescos y productos de consumo diario con altos estándares de calidad,
                                ofreciendo un servicio confiable y accesible para todas las familias.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm principle-card"
                        style="border-radius: 15px; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4 p-lg-5">
                            <div class="mb-4">
                                <i class="bi bi-eye" style="font-size: clamp(2.5rem, 5vw, 3.5rem); color: #28a745;"></i>
                            </div>
                            <h3 class="card-title mb-4"
                                style="color: #0A1A2F; font-weight: 700; font-size: clamp(1.2rem, 2.5vw, 1.5rem);">Visión
                            </h3>
                            <p class="card-text text-muted"
                                style="line-height: 1.8; font-size: clamp(0.95rem, 1.8vw, 1.05rem);">
                                Ser un mercado líder a nivel local y nacional, reconocido por la frescura de nuestros
                                productos, la excelencia en el servicio al cliente y el compromiso con la comunidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm principle-card"
                        style="border-radius: 15px; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4 p-lg-5">
                            <div class="mb-4">
                                <i class="bi bi-heart" style="font-size: clamp(2.5rem, 5vw, 3.5rem); color: #dc3545;"></i>
                            </div>
                            <h3 class="card-title mb-4"
                                style="color: #0A1A2F; font-weight: 700; font-size: clamp(1.2rem, 2.5vw, 1.5rem);">Valores
                            </h3>
                            <p class="card-text text-muted"
                                style="line-height: 1.8; font-size: clamp(0.95rem, 1.8vw, 1.05rem);">
                                Calidad en cada producto que ofrecemos, responsabilidad con nuestros clientes,
                                honestidad en nuestras prácticas y compromiso con el bienestar de nuestra comunidad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Reset de márgenes para evitar espacios en blanco */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Hero Section Animations */
        .hero-section {
            position: relative;
        }

        .hero-image {
            animation: subtle-zoom 20s ease-in-out infinite alternate;
        }

        @keyframes subtle-zoom {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.05);
            }
        }

        /* NUEVOS ESTILOS PARA LA GLASS CARD */
        .glass-card {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Logo Animation */
        .hero-logo {
            animation: logoFadeIn 1.5s ease-out;
        }

        @keyframes logoFadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 0.95;
                transform: translateX(0);
            }
        }

        /* Hero Button Hover */
        .btn-hero:hover {
            background-color: #00c8e0 !important;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 224, 255, 0.5) !important;
        }

        /* Glassmorphism responsive */
        @media (max-width: 768px) {
            .glass-card {
                background: rgba(255, 255, 255, 0.2) !important;
                backdrop-filter: blur(8px) !important;
            }

            .hero-logo {
                height: 50px !important;
            }
        }

        /* Category Cards Hover */
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.2) !important;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Product Cards Hover */
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15) !important;
        }

        /* Principle Cards Hover */
        .principle-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.2) !important;
        }

        /* Footer Links Hover */
        .footer-link:hover {
            color: #00E0FF !important;
            padding-left: 5px;
            transition: all 0.3s ease;
        }

        /* Social Icons Hover */
        .social-icon:hover {
            color: #00E0FF !important;
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Button Hover Effects */
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        /* Team Cards Hover */
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.25) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                height: 70vh !important;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                height: 60vh !important;
            }
        }
    </style>
@endsection