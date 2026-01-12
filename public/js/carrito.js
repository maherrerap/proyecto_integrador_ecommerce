document.addEventListener('DOMContentLoaded', () => {

    const btnAdd = document.getElementById('btn-add-cart');
    if (!btnAdd) return;

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

});

/* Actualizar badge */
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

document.addEventListener('click', e => {

    /* + */
    if (e.target.classList.contains('btn-plus')) {
        actualizarCantidad(e.target, 1);
    }

    /* - */
    if (e.target.classList.contains('btn-minus')) {
        actualizarCantidad(e.target, -1);
    }

    /* eliminar */
    if (e.target.classList.contains('btn-remove')) {
        eliminarProducto(e.target);
    }
});

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