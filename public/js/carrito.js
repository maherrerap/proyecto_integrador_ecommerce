document.addEventListener('DOMContentLoaded', () => {

    // BOTÓN AÑADIR AL CARRITO
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
                        actualizarBadgeCarrito();
                    }
                });
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
                        window.location.href = '/carrito';
                    } else {
                        alert(data.message || 'Error al vaciar el carrito');
                    }
                });
        });
    }

});

/* Actualizar badge del carrito en navbar */
function actualizarBadgeCarrito() {
    fetch('/carrito/count')
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('cart-count');
            if (!badge) return;

            if (data.total > 0) {
                badge.textContent = data.total;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
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

    // Auto ocultar después de 2 segundos
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
        .then(() => location.reload());
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
        .then(() => location.reload());
}