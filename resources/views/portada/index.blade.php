@extends('layouts.portada')

@section('contenido')
    <section class="hero-section">
        <div class="hero-image"></div>
        <div class="hero-overlay"></div>

        <div class="hero-watermark">
            <img src="{{ asset('images/cold_tech_logo.png') }}" alt="Cold Market Watermark" class="img-fluid">
        </div>

        <div class="hero-logo-container">
            <img src="{{ asset('images/cold_tech_logo.png') }}" alt="Cold Market Logo" class="hero-logo">
        </div>

        <div class="container-fluid hero-content-wrapper">
            <div class="row w-100 justify-content-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="glass-card">
                        <h1 class="hero-title">
                            Calidad y Frescura<br>
                            <span class="hero-title-accent">Para Tu Hogar</span>
                        </h1>

                        <p class="hero-subtitle">
                            Descubre la diferencia de los productos seleccionados con los más altos estándares.
                            Directamente a tu mesa con la garantía de <strong>Cold Market</strong>.
                        </p>

                        <div class="hero-cta-container">
                            <a href="{{ route('producto.index') }}" class="btn btn-lg btn-hero">
                                Explorar Catálogo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container-fluid section-container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 mx-auto text-center">
                    <h2 class="section-title">Quiénes Somos</h2>
                    <p class="section-lead">
                        En <strong class="brand-highlight">Cold Market</strong>, nos dedicamos a ofrecerte los mejores
                        productos frescos y de consumo diario. Somos tu aliado confiable para mantener tu hogar
                        abastecido con alimentos de calidad, garantizando frescura y los mejores precios del mercado.
                        Trabajamos con proveedores locales y nacionales para traerte productos que cumplen con
                        los más altos estándares.
                    </p>
                    <a href="#categorias" class="btn btn-outline-primary btn-lg btn-more-info">
                        Más información
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="why-choose-section">
        <div class="container-fluid section-container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/why-choose-us.jpg') }}" alt="Por qué elegirnos" class="why-choose-image">
                </div>
                <div class="col-lg-6">
                    <h2 class="why-choose-title">
                        Te proporcionamos un espacio confiable para tu compra diaria
                    </h2>
                    <p class="why-choose-text">
                        Todas nuestras compras se realizan en un entorno seguro, con productos verificados,
                        precios transparentes y atención personalizada. Nuestra tienda está ubicada en una zona
                        accesible con estacionamiento disponible, y también ofrecemos servicio de entrega a domicilio.
                    </p>
                    <p class="why-choose-text">
                        ¿No puedes venir a la tienda? No te preocupes; realizamos entregas rápidas y seguras
                        directamente a tu hogar.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="categorias" class="categories-section">
        <div class="container-fluid section-container">
            <h2 class="text-center section-title">Nuestras Categorías</h2>

            <div class="categories-grid">
                <div class="col-sm-6 col-lg-3">
                    <div class="category-card">
                        <div class="card-body">
                            <div class="category-icon">🍽️</div>
                            <h4 class="category-card-title">Alimentos</h4>
                            <p class="category-card-text">
                                Productos frescos y de despensa, frutas, carnes, lácteos y víveres de primera calidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="category-card">
                        <div class="card-body">
                            <div class="category-icon">👕</div>
                            <h4 class="category-card-title">Ropa</h4>
                            <p class="category-card-text">
                                Prendas de vestir para toda la familia, con variedad de estilos y tallas disponibles.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="category-card">
                        <div class="card-body">
                            <div class="category-icon">🔌</div>
                            <h4 class="category-card-title">Electrodomésticos</h4>
                            <p class="category-card-text">
                                Equipos para el hogar, desde pequeños electrodomésticos hasta línea blanca de calidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="category-card">
                        <div class="card-body">
                            <div class="category-icon">🔧</div>
                            <h4 class="category-card-title">Ferretería</h4>
                            <p class="category-card-text">
                                Herramientas, materiales de construcción y todo lo necesario para tus proyectos del hogar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('producto.index') }}" class="btn btn-lg btn-primary-custom">
                    Ver todos los productos
                </a>
            </div>
        </div>
    </section>

    <section class="featured-products-section">
        <div class="container-fluid section-container">
            <h2 class="text-center section-title">Productos Destacados</h2>

            <div class="featured-products-grid">
                @forelse($productosDestacados as $producto)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="featured-product-card">
                            <div class="featured-product-image">
                                @php
                                    $imagenPath = 'images/productos/' . $producto->id_producto . '.jpg';
                                @endphp
                                @if(file_exists(public_path($imagenPath)))
                                    <img src="{{ asset($imagenPath) }}" alt="{{ $producto->pro_descripcion }}" class="featured-img">
                                @else
                                    <div class="featured-product-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body text-center featured-product-body">
                                <h5 class="featured-product-title">
                                    {{ $producto->pro_descripcion }}
                                </h5>
                                <p class="featured-product-category">
                                    {{ $producto->categoria->cat_descripcion ?? 'Producto' }}
                                </p>
                                <p class="featured-product-price">
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
                <a href="{{ route('producto.index') }}" class="btn btn-outline-primary btn-lg btn-explore-more">
                    Explorar más productos
                </a>
            </div>
        </div>
    </section>

    <section class="testimonial-section">
        <div class="container-fluid testimonial-container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 mx-auto">
                    <div class="text-center">
                        <blockquote class="blockquote testimonial-quote">
                            <p class="testimonial-text">
                                "Gracias a Cold Market, encontré productos frescos de excelente calidad
                                a precios justos. El servicio de entrega es rápido y confiable.
                                Cold Market me ayudó a mantener mi hogar bien abastecido."
                            </p>
                        </blockquote>
                        <footer class="blockquote-footer testimonial-author">
                            <cite>MARÍA G., CLIENTA DE COLD MARKET</cite>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container-fluid section-container">
            <h2 class="text-center section-title">Sobre Nosotros</h2>
            <p class="text-center team-subtitle">
                Somos un equipo apasionado dedicado a brindarte la mejor experiencia de compra
            </p>

            <div class="team-grid">
                <div class="col-sm-6 col-lg-3">
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('images/jose.jpeg') }}" alt="Jose Zumarraga" class="team-img">
                        </div>
                        <div class="card-body text-center team-card-body">
                            <h4 class="team-member-name">Jose Zumarraga</h4>
                            <p class="team-member-quote">
                                "La innovación es la clave del éxito"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('images/maria.jpeg') }}" alt="Maria Astudillo" class="team-img">
                        </div>
                        <div class="card-body text-center team-card-body">
                            <h4 class="team-member-name">Maria Astudillo</h4>
                            <p class="team-member-quote">
                                "La excelencia no es un acto, es un hábito"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('images/martin.jpeg') }}" alt="Martin Herrera" class="team-img">
                        </div>
                        <div class="card-body text-center team-card-body">
                            <h4 class="team-member-name">Martin Herrera</h4>
                            <p class="team-member-quote">
                                "El trabajo en equipo hace que el sueño funcione"
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('images/matheo.jpeg') }}" alt="Matheo Iza" class="team-img">
                        </div>
                        <div class="card-body text-center team-card-body">
                            <h4 class="team-member-name">Matheo Iza</h4>
                            <p class="team-member-quote">
                                "La pasión impulsa el progreso"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="principles-section">
        <div class="container-fluid section-container">
            <h2 class="text-center section-title">Nuestros Principios</h2>

            <div class="principles-grid">
                <div class="col-sm-6 col-lg-4">
                    <div class="principle-card mission-card">
                        <div class="card-body text-center principle-card-body">
                            <div class="principle-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <h3 class="principle-title">Misión</h3>
                            <p class="principle-text">
                                Proveer alimentos frescos y productos de consumo diario con altos estándares de calidad,
                                ofreciendo un servicio confiable y accesible para todas las familias.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="principle-card vision-card">
                        <div class="card-body text-center principle-card-body">
                            <div class="principle-icon">
                                <i class="bi bi-eye"></i>
                            </div>
                            <h3 class="principle-title">Visión</h3>
                            <p class="principle-text">
                                Ser un mercado líder a nivel local y nacional, reconocido por la frescura de nuestros
                                productos, la excelencia en el servicio al cliente y el compromiso con la comunidad.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="principle-card values-card">
                        <div class="card-body text-center principle-card-body">
                            <div class="principle-icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h3 class="principle-title">Valores</h3>
                            <p class="principle-text">
                                Calidad en cada producto que ofrecemos, responsabilidad con nuestros clientes,
                                honestidad en nuestras prácticas y compromiso con el bienestar de nuestra comunidad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection