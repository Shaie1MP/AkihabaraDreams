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

  if (decreaseBtn && increaseBtn && quantityInput) {
    decreaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value)
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1
      }
    })

    increaseBtn.addEventListener("click", () => {
      const currentValue = Number.parseInt(quantityInput.value)
      quantityInput.value = currentValue + 1
    })

    // Validar que solo se ingresen números en el input de cantidad
    quantityInput.addEventListener("input", function () {
      this.value = this.value.replace(/[^0-9]/g, "")
      if (this.value === "" || Number.parseInt(this.value) < 1) {
        this.value = 1
      }
    })
  }

  // Funcionalidad para el botón de agregar al carrito
  const addToCartBtn = document.querySelector(".add-to-cart")
  const shopPayBtn = document.querySelector(".shop-pay-button")

  if (addToCartBtn) {
    addToCartBtn.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? parseInt(quantityInput.value) : 1

      // Redireccionar a la URL de agregar al carrito
      window.location.href = `/Akihabara-Dreams/carrito/add/${productId}?quantity=${quantity}`
    })
  }

  if (shopPayBtn) {
    shopPayBtn.addEventListener("click", function (e) {
      // Prevenir el comportamiento predeterminado del onclick
      e.preventDefault()
      
      const productId = this.getAttribute("data-product-id")
      const quantity = quantityInput ? parseInt(quantityInput.value) : 1

      // Usar XMLHttpRequest en lugar de fetch para asegurar que la solicitud se complete
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `/Akihabara-Dreams/carrito/add/${productId}?quantity=${quantity}&redirect=false`, true);
      
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          // Después de agregar al carrito, redirigir a la página de realizar pedido
          window.location.href = '/Akihabara-Dreams/pedidos/realizar';
        } else {
          console.error('Error:', xhr.statusText);
          // En caso de error, redirigir de todos modos
          window.location.href = '/Akihabara-Dreams/pedidos/realizar';
        }
      };
      
      xhr.onerror = function() {
        console.error('Network Error');
        // En caso de error, redirigir de todos modos
        window.location.href = '/Akihabara-Dreams/pedidos/realizar';
      };
      
      xhr.send();
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