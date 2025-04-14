document.addEventListener("DOMContentLoaded", () => {
    // Manejar el ordenamiento de productos
    const sortSelect = document.getElementById("sortSelect")
    if (sortSelect) {
      sortSelect.addEventListener("change", function () {
        const sortValue = this.value
        window.location.href = `/Akihabara-Dreams/productos/catalogo?sort=${sortValue}`
      })
    }
  
    // Hacer que toda la tarjeta sea clickeable
    const products = document.querySelectorAll(".product")
    products.forEach((product) => {
      product.addEventListener("click", function () {
        const url = this.getAttribute("onclick").split("'")[1]
        window.location.href = url
      })
    })
  
    // Manejar el botón de filtro
    const filterButton = document.querySelector(".filter-button")
    if (filterButton) {
      filterButton.addEventListener("click", () => {
        // Mostrar/ocultar el panel de filtros
        const filterPanel = document.getElementById("filterPanel")
        if (filterPanel) {
          filterPanel.classList.toggle("show")
        } else {
          crearPanelFiltros()
        }
      })
    }
  
    // Función para crear el panel de filtros
    function crearPanelFiltros() {
      // Crear el panel de filtros
      const filterPanel = document.createElement("div")
      filterPanel.id = "filterPanel"
      filterPanel.className = "filter-panel show"
  
      // Añadir contenido al panel
      filterPanel.innerHTML = `
              <div class="filter-header">
                  <h3>Filtros</h3>
                  <button class="close-filter">×</button>
              </div>
              <div class="filter-content">
                  <div class="filter-group">
                      <h4>Categoría</h4>
                      <div class="filter-options">
                          <label><input type="checkbox" name="category" value="figuras"> Figuras</label>
                          <label><input type="checkbox" name="category" value="manga"> Manga</label>
                          <label><input type="checkbox" name="category" value="merchandising"> Merchandising</label>
                      </div>
                  </div>
                  <div class="filter-group">
                      <h4>Precio</h4>
                      <div class="filter-options">
                          <label><input type="checkbox" name="price" value="0-20"> 0€ - 20€</label>
                          <label><input type="checkbox" name="price" value="20-50"> 20€ - 50€</label>
                          <label><input type="checkbox" name="price" value="50-100"> 50€ - 100€</label>
                          <label><input type="checkbox" name="price" value="100+"> Más de 100€</label>
                      </div>
                  </div>
                  <div class="filter-group">
                      <h4>Disponibilidad</h4>
                      <div class="filter-options">
                          <label><input type="checkbox" name="availability" value="in-stock"> En stock</label>
                          <label><input type="checkbox" name="availability" value="out-of-stock"> Agotado</label>
                      </div>
                  </div>
              </div>
              <div class="filter-footer">
                  <button class="apply-filters">Aplicar filtros</button>
                  <button class="clear-filters">Limpiar filtros</button>
              </div>
          `
  
      // Añadir el panel al DOM
      document.getElementById("catalog-container").appendChild(filterPanel)
  
      // Manejar el cierre del panel
      const closeButton = filterPanel.querySelector(".close-filter")
      closeButton.addEventListener("click", () => {
        filterPanel.classList.remove("show")
      })
  
      // Manejar la aplicación de filtros
      const applyButton = filterPanel.querySelector(".apply-filters")
      applyButton.addEventListener("click", () => {
        const filtros = {}
  
        // Recoger categorías seleccionadas
        const categorias = Array.from(filterPanel.querySelectorAll('input[name="category"]:checked')).map(
          (input) => input.value,
        )
        if (categorias.length > 0) {
          filtros.category = categorias
        }
  
        // Recoger rangos de precio seleccionados
        const precios = Array.from(filterPanel.querySelectorAll('input[name="price"]:checked')).map(
          (input) => input.value,
        )
        if (precios.length > 0) {
          filtros.price = precios
        }
  
        // Recoger disponibilidad seleccionada
        const disponibilidad = Array.from(filterPanel.querySelectorAll('input[name="availability"]:checked')).map(
          (input) => input.value,
        )
        if (disponibilidad.length > 0) {
          filtros.availability = disponibilidad
        }
  
        // Aplicar filtros
        if (window.filtrarProductos) {
          window.filtrarProductos(filtros)
          filterPanel.classList.remove("show")
        }
      })
  
      // Manejar la limpieza de filtros
      const clearButton = filterPanel.querySelector(".clear-filters")
      clearButton.addEventListener("click", () => {
        // Desmarcar todos los checkboxes
        filterPanel.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
          checkbox.checked = false
        })
  
        // Resetear filtros
        if (window.filtrarProductos) {
          window.filtrarProductos(null)
        }
      })
    }
  })
  