// Funcionalidad para el contador del carrito
document.addEventListener("DOMContentLoaded", () => {
    console.log("Inicializando funcionalidad del carrito")
  
    // Actualizar el contador del carrito al cargar la página
    updateCartCounter()
  
    const cartModal = document.getElementById("cartModal")
    const cartIcon = document.getElementById("carrito")
    const closeModal = document.querySelector(".close")
  
    // Verificar que los elementos existen antes de añadir event listeners
    if (cartIcon) {
      console.log("Elemento del carrito encontrado, añadiendo event listener")
      cartIcon.addEventListener("click", () => {
        if (cartModal) {
          cartModal.style.display = "flex"
        } else {
          console.error("Modal del carrito no encontrado")
        }
      })
    } else {
      console.error("Elemento del carrito no encontrado")
    }
  
    if (closeModal) {
      closeModal.onclick = () => {
        if (cartModal) {
          cartModal.style.display = "none"
        }
      }
    }
  
    // Cerrar modal al hacer clic fuera
    window.onclick = (event) => {
      if (cartModal && event.target == cartModal) {
        cartModal.style.display = "none"
      }
    }
  
    // Configurar event listeners para los botones de eliminar
    setupRemoveButtons()
  })
  
  // Función para actualizar el contador del carrito
  function updateCartCounter() {
    console.log("Actualizando contador del carrito")
  
    // Hacer una petición AJAX para obtener el número de productos en el carrito
    fetch("/Akihabara-Dreams/app/includes/cart-count.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`)
        }
        return response.json()
      })
      .then((data) => {
        console.log("Datos recibidos del contador:", data)
        const counter = document.getElementById("cart-counter")
  
        if (counter) {
          if (data.count > 0) {
            counter.textContent = data.count
            counter.style.display = "flex"
            console.log(`Contador actualizado: ${data.count} productos`)
          } else {
            counter.textContent = ""
            counter.style.display = "none"
            console.log("Carrito vacío, ocultando contador")
          }
        } else {
          console.error("Elemento del contador no encontrado")
        }
      })
      .catch((error) => {
        console.error("Error al obtener el contador del carrito:", error)
      })
  }
  
  // Función para añadir un producto al carrito mediante AJAX
  function addToCart(productId, quantity = 1) {
    console.log(`Añadiendo producto ${productId} al carrito (cantidad: ${quantity})`)
  
    // Usar la URL correcta para añadir al carrito
    fetch(`/Akihabara-Dreams/cart/add/${productId}?quantity=${quantity}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`)
        }
        // Intentar parsear como JSON, pero manejar el caso en que no sea JSON
        return response.text().then((text) => {
          try {
            return JSON.parse(text)
          } catch (e) {
            // Si no es JSON, simplemente devolver un objeto con éxito
            console.log("Respuesta no es JSON, pero la operación parece exitosa")
            return { success: true }
          }
        })
      })
      .then((data) => {
        console.log("Respuesta al añadir al carrito:", data)
  
        // Mostrar notificación
        const notification = document.getElementById("cart-notification")
        if (notification) {
          notification.textContent = "Producto añadido al carrito"
          notification.classList.add("show")
  
          // Ocultar la notificación después de 3 segundos
          setTimeout(() => {
            notification.classList.remove("show")
          }, 3000)
        }
  
        // Actualizar el contador del carrito
        updateCartCounter()
      })
      .catch((error) => {
        console.error("Error al añadir al carrito:", error)
  
        // Mostrar notificación de error
        const notification = document.getElementById("cart-notification")
        if (notification) {
          notification.textContent = "Error al añadir al carrito"
          notification.classList.add("show")
          notification.style.backgroundColor = "#f44336"
  
          // Ocultar la notificación después de 3 segundos
          setTimeout(() => {
            notification.classList.remove("show")
            notification.style.backgroundColor = ""
          }, 3000)
        }
      })
  }
  
  // Función para configurar los botones de eliminar
  function setupRemoveButtons() {
    console.log("Configurando botones de eliminar")
    const removeButtons = document.querySelectorAll(".remove-item")
  
    removeButtons.forEach((button) => {
      button.addEventListener("click", function (event) {
        event.preventDefault()
        const productId = this.getAttribute("data-id")
  
        if (productId) {
          console.log(`Botón de eliminar clickeado para producto ID: ${productId}`)
          removeFromCart(productId)
        } else {
          console.error("No se encontró el ID del producto en el botón de eliminar")
        }
      })
    })
  }
  
  // Función para eliminar un producto del carrito
  function removeFromCart(productId) {
    console.log(`Eliminando producto ${productId} del carrito`)
  
    fetch(`/Akihabara-Dreams/cart/eliminar/${productId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`)
        }
        // Intentar parsear como JSON, pero manejar el caso en que no sea JSON
        return response.text().then((text) => {
          try {
            return JSON.parse(text)
          } catch (e) {
            // Si no es JSON, simplemente devolver un objeto con éxito
            console.log("Respuesta no es JSON, pero la operación parece exitosa")
            return { success: true }
          }
        })
      })
      .then((data) => {
        console.log("Respuesta al eliminar del carrito:", data)
  
        // Actualizar la interfaz
        const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`)
        if (cartItem) {
          cartItem.remove()
          console.log(`Elemento del carrito con ID ${productId} eliminado del DOM`)
        }
  
        // Actualizar el contador
        updateCartCounter()
  
        // Mostrar notificación
        const notification = document.getElementById("cart-notification")
        if (notification) {
          notification.textContent = "Producto eliminado del carrito"
          notification.classList.add("show")
  
          setTimeout(() => {
            notification.classList.remove("show")
          }, 3000)
        }
  
        // Recargar la página si estamos en la página del carrito
        if (window.location.pathname.includes("/cart")) {
          window.location.reload()
        }
      })
      .catch((error) => {
        console.error("Error al eliminar del carrito:", error)
      })
  }
  
  // Exponer las funciones para que puedan ser llamadas desde otras partes
  window.updateCartCounter = updateCartCounter
  window.addToCart = addToCart
  window.removeFromCart = removeFromCart
  window.setupRemoveButtons = setupRemoveButtons
  