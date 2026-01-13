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
                .then(res => res.json())
                .then(data => {
                    if (data.ok) {
                        mostrarAlertaSuperior(data.message);

                        // Actualiza navbar + sidebar resumen
                        onCarritoCambiado();

                    } else {
                        alert(data.message || 'No se pudo añadir al carrito');
                    }
                })
                .catch(() => alert('Error de conexión al añadir al carrito'));
        });
    }

    // BOTÓN APROBAR CARRITO (PAGAR CON TARJETA)
    const btnAprobar = document.getElementById('btn-aprobar-carrito');
    if (btnAprobar) {
        btnAprobar.addEventListener('click', () => {
            if (!confirm('¿Deseas confirmar el pago?')) return;

            fetch('/carrito/aprobar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id_factura: btnAprobar.dataset.factura
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.ok) {
                        alert(data.message);
                        window.location.href = '/carrito';
                    } else {
                        alert(data.message);
                    }
                });
        });
    }

    // BOTÓN VACIAR CARRITO
    const btnVaciar = document.getElementById('btn-vaciar-carrito');
    if (btnVaciar) {
        btnVaciar.addEventListener('click', () => {
            if (!confirm('¿Seguro que deseas vaciar el carrito?')) return;

            fetch('/carrito/anular', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id_factura: btnVaciar.dataset.factura
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.ok) {
                        alert(data.message);

                        // Si se esta en /carrito, se recarga la página (porque cambian totales/tabla)
                        // pero también actualiza badge y resumen por si vuelves al catálogo
                        onCarritoCambiado();
                        window.location.href = '/carrito';

                    } else {
                        alert(data.message || 'Error al vaciar el carrito');
                    }
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

            if (Number(data.total) > 0) {
                badge.textContent = data.total;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
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
                contenedor.innerHTML = `<p class="mb-0 text-muted">No se pudo cargar el carrito.</p>`;
                return;
            }
            contenedor.innerHTML = data.html;
        })
        .catch(() => {
            contenedor.innerHTML = `<p class="mb-0 text-muted">No se pudo cargar el carrito.</p>`;
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

    setTimeout(() => {
        const alerta = contenedor.querySelector('.alert');
        if (alerta) alerta.remove();
    }, 2000);
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
    const idFactura = btn.dataset.factura;
    const qtySpan = document.getElementById(`qty-${idProducto}`);
    if (!qtySpan) return;

    let cantidad = parseInt(qtySpan.textContent) + cambio;
    if (cantidad < 1) return;

    fetch('/carrito/update-cantidad', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id_factura: idFactura,
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
        .catch(() => alert('Error al actualizar cantidad'));
}

/* Eliminar un producto individual del carrito */
function eliminarProducto(btn) {
    if (!confirm('¿Eliminar este producto del carrito?')) return;

    fetch('/carrito/remove-producto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id_factura: btn.dataset.factura,
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
        .catch(() => alert('Error al eliminar producto'));
}
