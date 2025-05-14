document.addEventListener("DOMContentLoaded", () => {
  // Inicializar el sidebar, los dropdowns y actualizar los contadores
  initSidebar()
  initDropdowns()
  updateCounters()
})

function initSidebar() {
  const menuToggle = document.getElementById("menu-toggle")
  const closeSidebar = document.getElementById("close-sidebar")
  const sidebarModal = document.getElementById("sidebar-modal")
  const overlay = document.getElementById("overlay")
  const body = document.body

  // Función para abrir el sidebar
  function openSidebar() {
    sidebarModal.classList.add("active")
    overlay.classList.add("active")
    body.style.overflow = "hidden" // Prevenir scroll en el fondo
  }

  // Función para cerrar el sidebar
  function closeSidebarModal() {
    sidebarModal.classList.remove("active")
    overlay.classList.remove("active")
    body.style.overflow = "" // Restaurar scroll
  }

  // Event listeners
  if (menuToggle) menuToggle.addEventListener("click", openSidebar)
  if (closeSidebar) closeSidebar.addEventListener("click", closeSidebarModal)
  if (overlay) overlay.addEventListener("click", closeSidebarModal)

  // Cerrar sidebar con la tecla Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && sidebarModal.classList.contains("active")) {
      closeSidebarModal()
    }
  })

  // Cerrar sidebar cuando se hace clic en un enlace
  const sidebarLinks = document.querySelectorAll(".sidebar-link")
  sidebarLinks.forEach((link) => {
    link.addEventListener("click", () => {
      // Pequeño retraso para que se vea la selección antes de cerrar
      setTimeout(closeSidebarModal, 150)
    })
  })

  // Marcar el enlace activo
  const currentPath = window.location.pathname
  sidebarLinks.forEach((link) => {
    const linkPath = link.getAttribute("href")
    if (currentPath === linkPath || (currentPath.startsWith(linkPath) && linkPath !== "/Akihabara-Dreams/")) {
      link.classList.add("active")
    }
  })

  // Ajustar altura del sidebar en dispositivos móviles
  function adjustSidebarHeight() {
    const windowHeight = window.innerHeight
    sidebarModal.style.height = `${windowHeight}px`
  }

  // Ajustar altura al cargar y al cambiar el tamaño de la ventana
  adjustSidebarHeight()
  window.addEventListener("resize", adjustSidebarHeight)
}

function initDropdowns() {
  // Cerrar dropdowns al hacer clic fuera de ellos
  document.addEventListener("click", (e) => {
    const dropdowns = document.querySelectorAll(".dropdown")
    dropdowns.forEach((dropdown) => {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove("active")
      }
    })
  })
}

function updateCounters() {
  // Actualizar contadores de wishlist y carrito
  updateWishlistCounter()
  updateCartCounter()
}

function updateWishlistCounter() {
  const wishlistCounter = document.getElementById("wishlist-counter")
  if (!wishlistCounter) return

  // Usar una petición para obtener el contador
  fetch("/Akihabara-Dreams/app/includes/wishlist-count.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`)
      }
      return response.json()
    })
    .then((data) => {
      if (data.count > 0) {
        wishlistCounter.textContent = data.count
        wishlistCounter.style.display = "flex"

        wishlistCounter.setAttribute("data-count", data.count)

        // Ajustar el tamaño 
        if (data.count > 9) {
          wishlistCounter.style.minWidth = "20px"
          wishlistCounter.style.height = "20px"
          wishlistCounter.style.padding = "0 4px"
        } else {
          wishlistCounter.style.minWidth = "18px"
          wishlistCounter.style.height = "18px"
          wishlistCounter.style.padding = "2px"
        }
      } else {
        wishlistCounter.style.display = "none"
        wishlistCounter.removeAttribute("data-count")
      }
    })
    .catch((error) => {
      console.error("Error al obtener contador de wishlist:", error)
    })
}

function updateCartCounter() {
  const cartCounter = document.getElementById("cart-counter")
  if (!cartCounter) return

  // Usar una petición simple para obtener el contador
  fetch("/Akihabara-Dreams/app/includes/cart-count.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`)
      }
      return response.json()
    })
    .then((data) => {
      if (data.count > 0) {
        cartCounter.textContent = data.count
        cartCounter.style.display = "flex"

        cartCounter.setAttribute("data-count", data.count)

        // Ajustar el tamaño 
        if (data.count > 9) {
          cartCounter.style.minWidth = "20px"
          cartCounter.style.height = "20px"
          cartCounter.style.padding = "0 4px"
        } else {
          cartCounter.style.minWidth = "18px"
          cartCounter.style.height = "18px"
          cartCounter.style.padding = "2px"
        }
      } else {
        cartCounter.style.display = "none"
        cartCounter.removeAttribute("data-count")
      }
    })
    .catch((error) => {
      console.error("Error al obtener contador de carrito:", error)
    })
}
