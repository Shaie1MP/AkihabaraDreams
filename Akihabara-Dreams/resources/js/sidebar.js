document.addEventListener("DOMContentLoaded", () => {
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
    menuToggle.addEventListener("click", openSidebar)
    closeSidebar.addEventListener("click", closeSidebarModal)
    overlay.addEventListener("click", closeSidebarModal)
  
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
  
    // Marcar el enlace activo basado en la URL actual
    const currentPath = window.location.pathname
    sidebarLinks.forEach((link) => {
      const linkPath = link.getAttribute("href")
      if (currentPath === linkPath || (currentPath.startsWith(linkPath) && linkPath !== "/Akihabara-Dreams/")) {
        link.classList.add("active")
      }
    })
  })
  