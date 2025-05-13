window.productos = [];
window.productosFiltrados = [];
window.productosPorPagina = 15;
window.paginaActual = 1;

// Funciones globales
window.mostrarProductos = function(pagina) {
  const inicio = (pagina - 1) * window.productosPorPagina;
  const fin = inicio + window.productosPorPagina;
  const productosPagina = window.productosFiltrados.slice(inicio, fin);

  const contenedor = document.querySelector(".products-grid");
  contenedor.innerHTML = "";
  productosPagina.forEach((producto) => {
    contenedor.appendChild(producto.cloneNode(true));
  });

  // Volver a añadir los eventos a los productos
  const productosActualizados = document.querySelectorAll(".product");
  productosActualizados.forEach((product) => {
    product.addEventListener("click", function () {
      const url = this.getAttribute("onclick").split("'")[1];
      window.location.href = url;
    });
  });
};

window.crearPaginacion = function() {
  const totalPaginas = Math.ceil(window.productosFiltrados.length / window.productosPorPagina);
  const paginacion = document.getElementById("paginacion");
  paginacion.innerHTML = "";

  // Añadir botón "Anterior"
  if (totalPaginas > 1) {
    const botonAnterior = document.createElement("button");

    botonAnterior.innerText = "«";
    botonAnterior.classList.add("pag-btn");

    botonAnterior.addEventListener("click", () => {
      if (window.paginaActual > 1) {
        window.paginaActual--;
        window.mostrarProductos(window.paginaActual);
        actualizarEstadoBotones();
      }
    });

    paginacion.appendChild(botonAnterior);
  }

  // Añadir botones de página
  for (let i = 1; i <= totalPaginas; i++) {
    const boton = document.createElement("button");
    boton.innerText = i;
    boton.classList.add("pag-btn");

    if (i === window.paginaActual) {
      boton.classList.add("active");
    }

    boton.addEventListener("click", () => {
      window.paginaActual = i;
      window.mostrarProductos(window.paginaActual);
      actualizarEstadoBotones();
    });

    paginacion.appendChild(boton);
  }

  // Añadir botón "Siguiente"
  if (totalPaginas > 1) {
    const botonSiguiente = document.createElement("button");
    botonSiguiente.innerText = "»";
    botonSiguiente.classList.add("pag-btn");

    botonSiguiente.addEventListener("click", () => {
      if (window.paginaActual < totalPaginas) {
        window.paginaActual++;
        window.mostrarProductos(window.paginaActual);
        actualizarEstadoBotones();
      }
    });

    paginacion.appendChild(botonSiguiente);
  }
};

function actualizarEstadoBotones() {
  const botones = document.querySelectorAll(".pag-btn");

  botones.forEach((boton) => {
    boton.classList.remove("active");

    if (boton.innerText === window.paginaActual.toString()) {
      boton.classList.add("active");
    }
  });
}

// Función para filtrar productos
window.filtrarProductos = function(filtros) {
  window.productosFiltrados = [...window.productos]; // Resetear a todos los productos

  // Aplicar filtros
  if (filtros) {
    Object.entries(filtros).forEach(([tipo, valor]) => {
      if (valor) {
        window.productosFiltrados = window.productosFiltrados.filter((producto) => {
          const atributo = producto.getAttribute(`data-${tipo}`);
          if (Array.isArray(valor)) {
            // Si el valor es un array, verificar si alguno coincide
            return valor.some((v) => atributo === v || atributo.includes(v));
          } else {
            // Si es un valor único
            return atributo === valor || atributo.includes(valor);
          }
        });
      }
    });
  }

  window.paginaActual = 1;
  window.crearPaginacion();
  window.mostrarProductos(window.paginaActual);

  // Actualizar contador de productos
  const contador = document.querySelector(".products-count");

  if (contador) {
    contador.textContent = `${window.productosFiltrados.length} productos`;
  }
};

// Inicializar cuando el DOM esté cargado
document.addEventListener("DOMContentLoaded", () => {
  window.productos = Array.from(document.querySelectorAll(".products-grid .product"));
  window.productosFiltrados = [...window.productos];

  if (window.productos.length > 0) {
    window.crearPaginacion();
    window.mostrarProductos(window.paginaActual);
  }
});