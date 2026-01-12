import './bootstrap';

// CARGAR CANTIDAD DE PRODUCTOS EN EL CARRITO
document.addEventListener('DOMContentLoaded', () => {
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
});
