document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            
            window.productosFiltrados = window.productos.filter(product => {
                const name = product.querySelector('.product-name')?.textContent.toLowerCase();
                return name && name.includes(filter);
            });
            
            window.paginaActual = 1;
            window.crearPaginacion();
            window.mostrarProductos(window.paginaActual);
            
            // Actualizar contador de productos si existe
            const contador = document.querySelector(".products-count");
            if (contador) {
                contador.textContent = `${window.productosFiltrados.length} productos`;
            }
        });
    }
});