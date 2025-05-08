document.addEventListener("DOMContentLoaded", () => {
  // Funcionalidad para los thumbnails
  const thumbnails = document.querySelectorAll(".thumbnail")
  const mainImage = document.querySelector(".main-image img")

  thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener("click", function () {
      // Quitar la clase active de todos los thumbnails
      thumbnails.forEach((t) => t.classList.remove("active"))

      // Agregar la clase active al thumbnail clickeado
      this.classList.add("active")

      // Actualizar la imagen principal
      const newImageSrc = this.querySelector("img").src
      mainImage.src = newImageSrc
    })
  })

  // Funcionalidad para el selector de cantidad
  const decreaseBtn = document.querySelector(".quantity-decrease")
  const increaseBtn = document.querySelector(".quantity-increase")
  const quantityInput = document.querySelector("#product-quantity")

  // Obtener el stock disponible
  let maxStock = 1
  const stockInfo = document.querySelector(".stock-info")

  if (stockInfo) {
    const stockText = stockInfo.textContent
    const stockMatch = stockText.match(/\((\d+)/)
    if (stockMatch && stockMatch[1]) {
      maxStock = Number.parseInt(stockMatch[1])
    }
  }

  if (decreaseBtn && increaseBtn && quantityInput) {
    decreaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value)
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1
      }
    })

    increaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value)
      // Verificar que no exceda el stock disponible
      if (currentValue < maxStock) {
        quantityInput.value = currentValue + 1
      } else {
        alert(`Solo hay ${maxStock} unidades disponibles.`)
      }
    })

    // Validar que solo se ingresen números en el input de cantidad
    quantityInput.addEventListener("input", function () {
      this.value = this.value.replace(/[^0-9]/g, "")
      if (this.value === "" || Number.parseInt(this.value) < 1) {
        this.value = 1
      } else if (Number.parseInt(this.value) > maxStock) {
        this.value = maxStock
        alert(`Solo hay ${maxStock} unidades disponibles.`)
      }
    })
  }

  // Funcionalidad para el botón de agregar al carrito
  const addToCartBtn = document.querySelector(".add-to-cart")
  const shopPayBtn = document.querySelector(".shop-pay-button")

  if (addToCartBtn) {
    addToCartBtn.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? Number.parseInt(quantityInput.value) : 1

      // Verificar que la cantidad no exceda el stock
      if (quantity > maxStock) {
        alert(`Solo hay ${maxStock} unidades disponibles.`)
        return
      }

      // Redireccionar a la URL de agregar al carrito
      window.location.href = `/Akihabara-Dreams/cart/add/${productId}?quantity=${quantity}`
    })
  }

  if (shopPayBtn) {
    shopPayBtn.addEventListener("click", function (e) {
      // Prevenir el comportamiento predeterminado del onclick
      e.preventDefault()

      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? Number.parseInt(quantityInput.value) : 1

      // Verificar que la cantidad no exceda el stock
      if (quantity > maxStock) {
        alert(`Solo hay ${maxStock} unidades disponibles.`)
        return
      }

      // Usar XMLHttpRequest en lugar de fetch para asegurar que la solicitud se complete
      const xhr = new XMLHttpRequest()
      xhr.open("GET", `/Akihabara-Dreams/cart/add/${productId}?quantity=${quantity}&redirect=false`, true)
      xhr.responseType = "json"

      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          const response = xhr.response

          if (response && response.success === false) {
            // Mostrar error si no hay suficiente stock
            alert(response.error || "Error al añadir al carrito")
          } else {
            // Después de agregar al carrito, redirigir a la página de realizar pedido
            window.location.href = "/Akihabara-Dreams/orders/realizar"
          }
        } else {
          console.error("Error:", xhr.statusText)
          // En caso de error, redirigir de todos modos
          window.location.href = "/Akihabara-Dreams/orders/realizar"
        }
      }

      xhr.onerror = () => {
        console.error("Network Error")
        // En caso de error, redirigir de todos modos
        window.location.href = "/Akihabara-Dreams/orders/realizar"
      }

      xhr.send()
    })
  }

  // Funcionalidad para el modal del carrito
  const cartModal = document.getElementById("cartModal")
  const closeModal = document.querySelector(".close")

  // Si existe un elemento con id "carrito", añadir evento para abrir el modal
  const carritoBtn = document.getElementById("carrito")
  if (carritoBtn) {
    carritoBtn.addEventListener("click", () => {
      cartModal.style.display = "flex"
    })
  }

  if (closeModal) {
    closeModal.onclick = () => {
      cartModal.style.display = "none"
    }
  }

  window.onclick = (event) => {
    if (event.target == cartModal) {
      cartModal.style.display = "none"
    }
  }
})
