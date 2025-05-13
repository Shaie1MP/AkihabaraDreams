document.addEventListener("DOMContentLoaded", () => {
  console.log("Inicializando funcionalidad de wishlist")

  // Configurar los botones de eliminar de la wishlist, añadir a la wishlist y actualizar el contador
  setupWishlistRemoveButtons()
  setupWishlistAddButtons()
  updateWishlistCounter()
})

// Función para configurar los botones de eliminar de la wishlist
function setupWishlistRemoveButtons() {
  const removeButtons = document.querySelectorAll(".remove-wishlist-item")
  console.log("Botones de eliminar encontrados:", removeButtons.length)

  removeButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault()
      console.log("Botón de eliminar clickeado")

      const productId = this.getAttribute("data-id")
      console.log("ID del producto a eliminar:", productId)

      if (productId) {
        removeFromWishlist(productId, this)
      } else {
        console.error("No se pudo encontrar el ID del producto")
      }
    })
  })
}

// Función para configurar los botones de añadir a la wishlist
function setupWishlistAddButtons() {
  const addButtons = document.querySelectorAll(".add-to-wishlist")
  console.log("Botones de añadir a wishlist encontrados:", addButtons.length)

  addButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault()
      console.log("Botón de añadir a wishlist clickeado")
      const productId = this.getAttribute("data-product-id")
      console.log("ID del producto:", productId)

      if (productId) {
        toggleWishlist(productId, this)
      }
    })
  })
}

// Función para eliminar productos de la wishlist
function removeFromWishlist(productId, button) {
  console.log("Eliminando producto de wishlist:", productId)

  // Deshabilitar el botón para evitar clics múltiples
  if (button) {
    button.disabled = true
    button.textContent = "Eliminando..."
  }

  // Crear un formulario para enviar la solicitud
  const form = document.createElement("form")
  form.method = "POST"
  form.action = `/Akihabara-Dreams/wishlist/remove/${productId}`
  form.style.display = "none"

  // Añadir un campo para indicar que es una solicitud AJAX
  const ajaxField = document.createElement("input")
  ajaxField.type = "hidden"
  ajaxField.name = "is_ajax"
  ajaxField.value = "1"
  form.appendChild(ajaxField)

  document.body.appendChild(form)

  fetch(form.action, {
    method: "POST",
    body: new FormData(form),
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
  })
    .then((response) => {
      document.body.removeChild(form)

      // Verificar si la respuesta es exitosa
      if (response.ok) {
        // Intentar parsear como JSON, pero manejar el caso en que no sea JSON
        return response.text().then((text) => {
          try {
            return JSON.parse(text)
          } catch (e) {
            return { success: true, message: "Producto eliminado de tu lista de deseos" }
          }
        })
      } else {
        throw new Error(`Error HTTP: ${response.status}`)
      }
    })
    .then((data) => {
      console.log("Respuesta procesada:", data)

      // Eliminar el elemento de la interfaz
      const wishlistItem = document.querySelector(`.wishlist-item[data-id="${productId}"]`)
      if (wishlistItem) {
        wishlistItem.remove()
        console.log("Elemento eliminado del DOM")
      }

      showNotification(data.message || "Producto eliminado de tu lista de deseos")

      updateWishlistCounter()

      // Si no quedan elementos, mostrar mensaje de lista vacía
      const wishlistItems = document.querySelectorAll(".wishlist-item")
      if (wishlistItems.length === 0) {
        const wishlistContainer = document.querySelector(".wishlist-items")
        if (wishlistContainer) {
          const emptyMessage = document.createElement("div")
          emptyMessage.className = "empty-wishlist"
          emptyMessage.innerHTML = `
          <p>Tu lista de deseos está vacía.</p>
          <a href="/Akihabara-Dreams/catalog" class="btn-primary">Explorar Productos</a>
        `

          // Vaciar el contenedor y añadir el mensaje
          wishlistContainer.innerHTML = ""
          wishlistContainer.appendChild(emptyMessage)

          // Ocultar el botón de vaciar wishlist
          const clearButton = document.querySelector(".wishlist-actions")
          if (clearButton) {
            clearButton.style.display = "none"
          }
        }
      }
    })
    .catch((error) => {
      showNotification("Error al eliminar el producto", "error")

      // Restaurar el botón
      if (button) {
        button.disabled = false
        button.textContent = "Eliminar"
      }
    })
}

// Función para añadir y quitar un producto de la wishlist
function toggleWishlist(productId, button) {
  const isActive = button.classList.contains("active")
  const url = isActive ? `/Akihabara-Dreams/wishlist/remove/${productId}` : `/Akihabara-Dreams/wishlist/add/${productId}`

  fetch(url, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
  })
    .then((response) => {
      console.log("Respuesta recibida:", response.status)
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`)
      }

      // Intentar parsear como JSON, pero manejar el caso en que no sea JSON
      return response.text().then((text) => {
        try {
          return JSON.parse(text)
        } catch (e) {
          return {
            success: true,
            message: isActive ? "Producto eliminado de tu lista de deseos" : "Producto añadido a tu lista de deseos",
          }
        }
      })
    })
    .then((data) => {
      console.log("Datos procesados:", data)

      // Actualizar el estado del botón
      if (isActive) {
        button.classList.remove("active")
        button.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
          Añadir a Favoritos
        `
      } else {
        button.classList.add("active")
        button.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
          En Favoritos
        `
      }

      showNotification(data.message || "Lista de deseos actualizada")

      updateWishlistCounter()
    })
    .catch((error) => {
      console.error("Error al actualizar la wishlist:", error)
      showNotification("Error al actualizar la lista de deseos", "error")
    })
}

// Función para actualizar el contador de la wishlist
function updateWishlistCounter() {
  const xhr = new XMLHttpRequest()

  xhr.open("GET", "/Akihabara-Dreams/app/includes/wishlist-count.php", true)
  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      try {
        const data = JSON.parse(xhr.responseText)
        console.log("Contador de wishlist:", data)

        const counter = document.getElementById("wishlist-counter")
        if (counter) {
          if (data.count > 0) {
            counter.textContent = data.count
            counter.style.display = "flex"
          } else {
            counter.textContent = ""
            counter.style.display = "none"
          }
        }
      } catch (e) {
        console.error("Error al parsear respuesta del contador:", e)
      }
    }
  }
  xhr.onerror = () => {
    console.error("Error de red al obtener contador")
  }
  xhr.send()
}

// Función para mostrar notificaciones
function showNotification(message, type = "success") {
  console.log("Mostrando notificación:", message, type)

  // Verificar si ya existe una notificación
  let notification = document.getElementById("notification")

  if (!notification) {
    notification = document.createElement("div")
    notification.id = "notification"
    document.body.appendChild(notification)
  }

  // Configurar la notificación
  notification.className = `notification ${type}`
  notification.textContent = message
  notification.style.display = "block"

  // Ocultar después de 3 segundos
  setTimeout(() => {
    notification.style.display = "none"
  }, 3000)
}

// Funciones para que puedan ser llamadas desde otras partes
window.removeFromWishlist = removeFromWishlist
window.toggleWishlist = toggleWishlist
window.updateWishlistCounter = updateWishlistCounter
