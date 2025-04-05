document.getElementById('searchInput').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    productosFiltrados = productos.filter(product => {
        const name = product.querySelector('.product-name').textContent.toLowerCase();
        return name.includes(filter);
    });
    paginaActual = 1;
    crearPaginacion();
    mostrarProductos(paginaActual);
});
