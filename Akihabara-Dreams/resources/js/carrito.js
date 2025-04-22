// Funcionalidad para el contador del carrito
document.addEventListener("DOMContentLoaded", () => {
    // Actualizar el contador del carrito al cargar la página
    updateCartCounter()
  
    const cartModal = document.getElementById("cartModal")
    const closeModal = document.querySelector(".close")
    const cartItemsContainer = document.getElementById("cartItemsContainer")
  
    document.getElementById("carrito").addEventListener("click", () => {
      cartModal.style.display = "flex"
    })
  
    closeModal.onclick = () => {
      cartModal.style.display = "none"
    }
  
    window.onclick = (event) => {
      if (event.target == cartModal) {
        cartModal.style.display = "none"
      }
    }
  
    // Función para actualizar el contador del carrito
    function updateCartCounter() {
      // Hacer una petición AJAX para obtener el número de productos en el carrito
      fetch("/Akihabara-Dreams/app/includes/cart-count.php")
        .then((response) => response.json())
        .then((data) => {
          const counter = document.getElementById("cart-counter")
          if (counter && data.count > 0) {
            counter.textContent = data.count
            counter.style.display = "flex"
          } else if (counter) {
            counter.textContent = "0"
            counter.style.display = "none"
          }
        })
        .catch((error) => console.error("Error al obtener el contador del carrito:", error))
    }
  
    // Exponer la función para que pueda ser llamada desde otras partes
    window.updateCartCounter = updateCartCounter
  })
  
  // Función para añadir un producto al carrito mediante AJAX
  function addToCart(productId, quantity = 1) {
    fetch(`/Akihabara-Dreams/app/includes/add-to-cart.php?id_product=${productId}&quantity=${quantity}&redirect=false`)
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Mostrar notificación
          const notification = document.getElementById("cart-notification")
          notification.textContent = "Producto añadido al carrito"
          notification.classList.add("show")
  
          // Actualizar el contador del carrito
          updateCartCounter()
  
          // Ocultar la notificación después de 3 segundos
          setTimeout(() => {
            notification.classList.remove("show")
          }, 3000)
        }
      })
      .catch((error) => console.error("Error al añadir al carrito:", error))
  }
  