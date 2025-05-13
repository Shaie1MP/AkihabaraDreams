document.addEventListener("DOMContentLoaded", () => {
  const thumbnails = document.querySelectorAll(".thumbnail")
  const mainImage = document.querySelector(".main-image img")

  if (thumbnails && mainImage) {
    thumbnails.forEach((thumbnail) => {
      thumbnail.addEventListener("click", function () {
        thumbnails.forEach((t) => t.classList.remove("active"))

        this.classList.add("active")

        // Actualizar la imagen principal
        const newImageSrc = this.querySelector("img").src
        mainImage.src = newImageSrc
      })
    })
  }

  // Funcionalidad para el botón de cantidad
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
      maxStock = Number.parseInt(stockMatch[1], 10)
    }
  }

  if (decreaseBtn && increaseBtn && quantityInput) {
    decreaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value, 10)
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1
      }
    })

    increaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value, 10)
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

      if (this.value === "" || Number.parseInt(this.value, 10) < 1) {
        this.value = 1
      } else if (Number.parseInt(this.value, 10) > maxStock) {
        this.value = maxStock
        alert(`Solo hay ${maxStock} unidades disponibles.`)
      }
    })
  }

  const addToCartBtn = document.querySelector(".add-to-cart")

  if (addToCartBtn) {
    addToCartBtn.addEventListener("click", function (e) {
      e.preventDefault()

      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? Number.parseInt(quantityInput.value, 10) : 1

      // Verificar que la cantidad no exceda el stock
      if (quantity > maxStock) {
        alert(`Solo hay ${maxStock} unidades disponibles.`)
        return
      }

      window.location.href = `/Akihabara-Dreams/cart/add/${productId}?quantity=${quantity}`
    })
  }

  const shopPayBtn = document.querySelector(".shop-pay-button")

  if (shopPayBtn) {
    shopPayBtn.addEventListener("click", function (e) {
      e.preventDefault()

      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? Number.parseInt(quantityInput.value, 10) : 1

      // Verificar que la cantidad no exceda el stock
      if (quantity > maxStock) {
        alert(`Solo hay ${maxStock} unidades disponibles.`)
        return
      }

      window.location.href = `/Akihabara-Dreams/cart/add/${productId}?quantity=${quantity}&redirect=orders/realizar`
    })
  }

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
