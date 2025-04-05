const productos = Array.from(document.querySelectorAll('.product'));
let productosFiltrados = [...productos];
const productosPorPagina = 9;
let paginaActual = 1;

function mostrarProductos(pagina) {
    const inicio = (pagina - 1) * productosPorPagina;
    const fin = inicio + productosPorPagina;
    const productosPagina = productosFiltrados.slice(inicio, fin);

    const contenedor = document.getElementById('productList');
    contenedor.innerHTML = '';
    productosPagina.forEach(producto => {
        contenedor.appendChild(producto.cloneNode(true));
    });
}

function crearPaginacion() {
    const totalPaginas = Math.ceil(productosFiltrados.length / productosPorPagina);
    const paginacion = document.getElementById('paginacion');
    paginacion.innerHTML = '';

    for (let i = 1; i <= totalPaginas; i++) {
        const boton = document.createElement('button');
        boton.innerText = i;
        boton.addEventListener('click', () => {
            paginaActual = i;
            mostrarProductos(paginaActual);
        });
        paginacion.appendChild(boton);
    }
}

crearPaginacion();
mostrarProductos(paginaActual);
