document.addEventListener("DOMContentLoaded", () => {
    const productos = Array.from(document.querySelectorAll(".products-grid .product"))
    let productosFiltrados = [...productos]
    const productosPorPagina = 15
    let paginaActual = 1
  
    function mostrarProductos(pagina) {
      const inicio = (pagina - 1) * productosPorPagina
      const fin = inicio + productosPorPagina
      const productosPagina = productosFiltrados.slice(inicio, fin)
  
      const contenedor = document.querySelector(".products-grid")
      contenedor.innerHTML = ""
      productosPagina.forEach((producto) => {
        contenedor.appendChild(producto.cloneNode(true))
      })
  
      // Volver a añadir los event listeners a los productos
      const productosActualizados = document.querySelectorAll(".product")
      productosActualizados.forEach((product) => {
        product.addEventListener("click", function () {
          const url = this.getAttribute("onclick").split("'")[1]
          window.location.href = url
        })
      })
    }
  
    function crearPaginacion() {
      const totalPaginas = Math.ceil(productosFiltrados.length / productosPorPagina)
      const paginacion = document.getElementById("paginacion")
      paginacion.innerHTML = ""
  
      // Añadir botón "Anterior"
      if (totalPaginas > 1) {
        const botonAnterior = document.createElement("button")
        botonAnterior.innerText = "«"
        botonAnterior.classList.add("pag-btn")
        botonAnterior.addEventListener("click", () => {
          if (paginaActual > 1) {
            paginaActual--
            mostrarProductos(paginaActual)
            actualizarEstadoBotones()
          }
        })
        paginacion.appendChild(botonAnterior)
      }
  
      // Añadir botones de página
      for (let i = 1; i <= totalPaginas; i++) {
        const boton = document.createElement("button")
        boton.innerText = i
        boton.classList.add("pag-btn")
        if (i === paginaActual) {
          boton.classList.add("active")
        }
        boton.addEventListener("click", () => {
          paginaActual = i
          mostrarProductos(paginaActual)
          actualizarEstadoBotones()
        })
        paginacion.appendChild(boton)
      }
  
      // Añadir botón "Siguiente"
      if (totalPaginas > 1) {
        const botonSiguiente = document.createElement("button")
        botonSiguiente.innerText = "»"
        botonSiguiente.classList.add("pag-btn")
        botonSiguiente.addEventListener("click", () => {
          if (paginaActual < totalPaginas) {
            paginaActual++
            mostrarProductos(paginaActual)
            actualizarEstadoBotones()
          }
        })
        paginacion.appendChild(botonSiguiente)
      }
    }
  
    function actualizarEstadoBotones() {
      const botones = document.querySelectorAll(".pag-btn")
      botones.forEach((boton) => {
        boton.classList.remove("active")
        if (boton.innerText === paginaActual.toString()) {
          boton.classList.add("active")
        }
      })
    }
  
    // Función para filtrar productos
    window.filtrarProductos = (filtros) => {
      productosFiltrados = [...productos] // Resetear a todos los productos
  
      // Aplicar filtros
      if (filtros) {
        Object.entries(filtros).forEach(([tipo, valor]) => {
          if (valor) {
            productosFiltrados = productosFiltrados.filter((producto) => {
              // Obtener el valor del atributo data correspondiente
              const atributo = producto.getAttribute(`data-${tipo}`)
              if (Array.isArray(valor)) {
                // Si el valor es un array, verificar si alguno coincide
                return valor.some((v) => atributo === v || atributo.includes(v))
              } else {
                // Si es un valor único
                return atributo === valor || atributo.includes(valor)
              }
            })
          }
        })
      }
  
      paginaActual = 1 // Volver a la primera página
      crearPaginacion()
      mostrarProductos(paginaActual)
  
      // Actualizar contador de productos
      const contador = document.querySelector(".products-count")
      if (contador) {
        contador.textContent = `${productosFiltrados.length} productos`
      }
    }
  
    // Inicializar paginación si hay productos
    if (productos.length > 0) {
      crearPaginacion()
      mostrarProductos(paginaActual)
    }
  })
  