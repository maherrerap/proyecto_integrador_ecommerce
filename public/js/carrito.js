document.addEventListener('DOMContentLoaded', () => {

    // Al cargar cualquier página: badge + resumen (si existe el contenedor)
    actualizarBadgeCarrito();
    actualizarResumenCarrito();

    // BOTÓN AÑADIR AL CARRITO (detalle producto)
    const btnAdd = document.getElementById('btn-add-cart');
    if (btnAdd) {
        btnAdd.addEventListener('click', () => {
            const idProducto = btnAdd.dataset.producto;

            fetch('/carrito/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify({
                    id_producto: idProducto,
                    cantidad: 1
                })
            })
                .then(res => {
                    // FIX: Manejar 401 no autenticado - redirigir a login
                    if (res.status === 401) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Debe iniciar sesión',
                            text: 'Para agregar productos al carrito debe iniciar sesión',
                            confirmButtonText: 'Ir a iniciar sesión',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#198754'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/login';
                            }
                        });
                        throw new Error('No autenticado');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.ok) {
                        mostrarAlertaSuperior(data.message);

                        // Actualiza navbar + sidebar resumen
                        onCarritoCambiado();

                    } else {
                        Swal.fire('Error', data.message || 'No se pudo añadir al carrito', 'error');
                    }
                })
                .catch((err) => {
                    // CRITICAL FIX #3: Diferenciar tipos de error
                    let title = 'No pudimos añadir el producto';
                    let text = 'Ocurrió un error inesperado';

                    if (err.name === 'TypeError' || !navigator.onLine) {
                        title = 'Sin conexión';
                        text = 'Verifica tu conexión a internet e intenta nuevamente.';
                    } else if (err.status === 500) {
                        title = 'Error del servidor';
                        text = 'Nuestro servidor está experimentando problemas. Intenta nuevamente en unos minutos.';
                    } else if (err.status === 401) {
                        title = 'Sesión expirada';
                        text = 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: text,
                        confirmButtonText: 'Entendido'
                    });
                });
        });
    }

    // BOTÓN APROBAR CARRITO (PAGAR CON TARJETA)
    const btnAprobar = document.getElementById('btn-aprobar-carrito');
    if (btnAprobar) {
        btnAprobar.addEventListener('click', () => {
            Swal.fire({
                title: 'Confirmar pago',
                text: '¿Deseas confirmar el pago de este carrito?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, pagar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (!result.isConfirmed) return;

                // UX FIX #2: Activar loading state en botón de pago
                btnAprobar.disabled = true;
                const originalText = btnAprobar.innerHTML;
                btnAprobar.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando pago...';

                fetch('/carrito/aprobar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id_carrito: btnAprobar.dataset.carrito
                    })
                })
                    .then(res => {
                        // Si la respuesta es 401 (no autenticado)
                        if (res.status === 401) {
                            return res.json().then(data => {
                                // MEDIUM FIX #9: Restaurar botón antes de redirigir
                                btnAprobar.disabled = false;
                                btnAprobar.innerHTML = originalText;

                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Sesión expirada',
                                    text: data.message,
                                    confirmButtonText: 'Ir a login'
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                                throw new Error('No autenticado');
                            });
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pago realizado',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/carrito';
                            });
                        } else {
                            // MEDIUM FIX #9: Restaurar botón en error
                            btnAprobar.disabled = false;
                            btnAprobar.innerHTML = originalText;
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch((err) => {
                        // CRITICAL FIX #3: Especificar tipo de error en pago
                        if (err.message !== 'No autenticado') {
                            let errorMsg = 'Error de conexión al procesar el pago';

                            if (!navigator.onLine) {
                                errorMsg = 'Sin conexión a internet. Verifica tu red.';
                            } else if (err.status === 500) {
                                errorMsg = 'Error en el servidor. Tu pago no fue procesado. Intenta nuevamente.';
                            } else if (err.status === 400) {
                                errorMsg = 'Hubo un problema con tu solicitud. Verifica los datos del carrito.';
                            }

                            Swal.fire('Error en el pago', errorMsg, 'error');
                        }
                    });
            });
        });
    }

    // BOTÓN VACIAR CARRITO
    const btnVaciar = document.getElementById('btn-vaciar-carrito');
    if (btnVaciar) {
        btnVaciar.addEventListener('click', () => {
            Swal.fire({
                title: '¿Vaciar carrito?',
                text: 'Se eliminarán todos los productos del carrito',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, vaciar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (!result.isConfirmed) return;

                fetch('/carrito/anular', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id_carrito: btnVaciar.dataset.carrito
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Carrito vacío',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // Actualiza badge y resumen antes de recargar
                                onCarritoCambiado();
                                window.location.href = '/carrito';
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Error al vaciar el carrito', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Error de conexión al vaciar el carrito', 'error');
                    });
            });
        });
    }

});

/* ====== Helpers generales ====== */

/* Llamar cuando el carrito cambió: badge + resumen */
function onCarritoCambiado() {
    actualizarBadgeCarrito();
    actualizarResumenCarrito();
}

/* Actualizar badge del carrito en navbar */
function actualizarBadgeCarrito() {
    fetch('/carrito/count')
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('cart-count');
            if (!badge) return;

            // UX FIX MEDIO #7: Mostrar badge siempre, incluso en 0
            badge.textContent = data.total || '0';
            badge.style.display = 'inline-block';
        })
        .catch(() => { /* silencioso */ });
}

/* Actualizar el resumen del carrito (sidebar catálogo) */
function actualizarResumenCarrito() {
    const contenedor = document.getElementById('cart-summary');
    if (!contenedor) return; // si no estás en catálogo, no hace nada

    fetch('/carrito/resumen')
        .then(res => res.json())
        .then(data => {
            if (!data || !data.ok) {
                contenedor.innerHTML = `<p class="mb-0 text-muted">Debe de Iniciar Sesión para ver el carrito</p>`;
                return;
            }
            contenedor.innerHTML = data.html;
        })
        .catch(() => {
            contenedor.innerHTML = `<p class="mb-0 text-muted">Debe de Iniciar Sesión para ver el carrito</p>`;
        });
}

/* Mostrar alerta superior cuando se añade al carrito */
function mostrarAlertaSuperior(mensaje) {
    const contenedor = document.getElementById('alert-carrito');
    if (!contenedor) return;

    contenedor.innerHTML = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>${mensaje}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // SECOND AUDIT FIX #5: Aumentar timeout a 4 segundos
    setTimeout(() => {
        const alerta = contenedor.querySelector('.alert');
        if (alerta) alerta.remove();
    }, 4000); // Cambiado de 2000 a 4000
}

/* Event delegation para botones dinámicos (+, -, eliminar) */
document.addEventListener('click', e => {

    /* Botón + (aumentar cantidad) */
    if (e.target.classList.contains('btn-plus')) {
        actualizarCantidad(e.target, 1);
    }

    /* Botón - (disminuir cantidad) */
    if (e.target.classList.contains('btn-minus')) {
        actualizarCantidad(e.target, -1);
    }

    /* Botón eliminar producto individual */
    if (e.target.classList.contains('btn-remove')) {
        eliminarProducto(e.target);
    }
});

/* Actualizar cantidad de un producto en el carrito */
function actualizarCantidad(btn, cambio) {
    const idProducto = btn.dataset.producto;
    const idCarrito = btn.dataset.carrito;
    const qtySpan = document.getElementById(`qty-${idProducto}`);
    if (!qtySpan) return;

    let cantidad = parseInt(qtySpan.textContent) + cambio;
    if (cantidad < 1) return;

    // UX FIX #3: Mostrar feedback visual inmediato
    qtySpan.style.opacity = '0.5';
    btn.disabled = true;

    fetch('/carrito/update-cantidad', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id_carrito: idCarrito,
            id_producto: idProducto,
            cantidad: cantidad
        })
    })
        .then(res => res.json())
        .then(data => {
            // Si estás en /carrito, recarga porque se recalculan totales visuales
            // Si no, solo refresca resumen/badge
            if (window.location.pathname === '/carrito') {
                location.reload();
            } else {
                onCarritoCambiado();
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Error al actualizar cantidad', 'error');
        });
}

/* Eliminar un producto individual del carrito */
function eliminarProducto(btn) {
    Swal.fire({
        title: 'Eliminar producto',
        text: '¿Deseas eliminar este producto del carrito?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch('/carrito/remove-producto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                id_carrito: btn.dataset.carrito,
                id_producto: btn.dataset.producto
            })
        })
            .then(res => res.json())
            .then(data => {
                if (window.location.pathname === '/carrito') {
                    location.reload();
                } else {
                    onCarritoCambiado();
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Error al eliminar producto', 'error');
            });
    });
}