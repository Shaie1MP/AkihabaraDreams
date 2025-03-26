document.addEventListener("DOMContentLoaded", () => {
    const cartIconContainer = document.getElementById("cart-icon-container")
    const miniCart = document.getElementById("mini-cart")
    const miniCartClose = document.getElementById("mini-cart-close")
    const miniCartItems = document.getElementById("mini-cart-items")
    const miniCartTotal = document.getElementById("mini-cart-total")
    const cartCount = document.getElementById("cart-count")
    const cartNotification = document.getElementById("cart-notification")

    let cart = []
  
    // Cargar el carrito desde localStorage o inicializarlo
    function loadCart() {
      const savedCart = localStorage.getItem("akihabaraCart")
      if (savedCart) {
        cart = JSON.parse(savedCart)
        updateCartUI()
      }
    }
  
    // Guardar el carrito en localStorage
    function saveCart() {
      localStorage.setItem("akihabaraCart", JSON.stringify(cart))
      updateCartUI()
    }
  
    // Actualizar la UI del carrito
    function updateCartUI() {
      const totalItems = cart.reduce((total, item) => total + item.quantity, 0)
      cartCount.textContent = totalItems

      updateMiniCart()
    }
  
    // Actualizar el mini carrito
    function updateMiniCart() {
      if (!miniCartItems) return
  
      miniCartItems.innerHTML = ""
  
      if (cart.length === 0) {
        miniCartItems.innerHTML = '<div class="mini-cart-empty">Tu carrito está vacío</div>'
        miniCartTotal.textContent = "0.00 €"
        return
      }
  
      let total = 0
  
      cart.forEach((item) => {
        const itemTotal = item.price * item.quantity
        total += itemTotal
  
        const itemElement = document.createElement("div")
        itemElement.className = "mini-cart-item"
        itemElement.innerHTML = `
                  <img src="/Akihabara-Dreams/resources/images/productos/portadas/${item.image}" alt="${item.name}" class="mini-cart-item-image">
                  <div class="mini-cart-item-details">
                      <div class="mini-cart-item-name">${item.name}</div>
                      <div class="mini-cart-item-price">${item.price.toFixed(2)} €</div>
                      <div class="mini-cart-item-quantity">
                          <button class="decrease-quantity" data-id="${item.id}">-</button>
                          <span>${item.quantity}</span>
                          <button class="increase-quantity" data-id="${item.id}">+</button>
                      </div>
                  </div>
                  <button class="mini-cart-item-remove" data-id="${item.id}">&times;</button>
              `
  
        miniCartItems.appendChild(itemElement)
      })
  
      miniCartTotal.textContent = `${total.toFixed(2)} €`
  
      // Añadir event listeners a los botones
      const decreaseButtons = miniCartItems.querySelectorAll(".decrease-quantity")
      const increaseButtons = miniCartItems.querySelectorAll(".increase-quantity")
      const removeButtons = miniCartItems.querySelectorAll(".mini-cart-item-remove")
  
      decreaseButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
          e.stopPropagation()
          const id = this.getAttribute("data-id")
          decreaseQuantity(id)
        })
      })
  
      increaseButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
          e.stopPropagation()
          const id = this.getAttribute("data-id")
          increaseQuantity(id)
        })
      })
  
      removeButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
          e.stopPropagation()
          const id = this.getAttribute("data-id")
          removeFromCart(id)
        })
      })
    }
  
    // Añadir producto al carrito
    function addToCart(product) {
      const existingItemIndex = cart.findIndex((item) => item.id === product.id)
  
      if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity += 1
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          quantity: 1,
        })
      }
  
      saveCart()
      showNotification()
    }
  
    // Aumentar cantidad de un producto
    function increaseQuantity(id) {
      const itemIndex = cart.findIndex((item) => item.id === id)
      if (itemIndex !== -1) {
        cart[itemIndex].quantity += 1
        saveCart()
      }
    }
  
    // Disminuir cantidad de un producto
    function decreaseQuantity(id) {
      const itemIndex = cart.findIndex((item) => item.id === id)
      if (itemIndex !== -1) {
        if (cart[itemIndex].quantity > 1) {
          cart[itemIndex].quantity -= 1
        } else {
          cart.splice(itemIndex, 1)
        }
        saveCart()
      }
    }
  
    // Eliminar producto del carrito
    function removeFromCart(id) {
      const itemIndex = cart.findIndex((item) => item.id === id)
      if (itemIndex !== -1) {
        cart.splice(itemIndex, 1)
        saveCart()
      }
    }
  
    // Mostrar notificación de producto añadido
    function showNotification() {
      cartNotification.classList.add("show")
      cartCount.classList.add("bounce")
  
      setTimeout(() => {
        cartNotification.classList.remove("show")
        cartCount.classList.remove("bounce")
      }, 3000)
    }

    if (cartIconContainer) {
      cartIconContainer.addEventListener("click", (e) => {
        e.stopPropagation()
        miniCart.classList.toggle("show")
      })
    }
  
    if (miniCartClose) {
      miniCartClose.addEventListener("click", (e) => {
        e.stopPropagation()
        miniCart.classList.remove("show")
      })
    }
  
    // Cerrar mini carrito al hacer clic fuera
    document.addEventListener("click", (e) => {
      if (
        miniCart &&
        miniCart.classList.contains("show") &&
        !miniCart.contains(e.target) &&
        e.target !== cartIconContainer
      ) {
        miniCart.classList.remove("show")
      }
    })
  
    // Añadir event listeners a los botones "Añadir al carrito"
    const addToCartButtons = document.querySelectorAll(".add-to-cart-button")
    addToCartButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const productCard = this.closest(".product-card")
        const product = {
          id: this.getAttribute("data-id"),
          name: productCard.querySelector(".product-title").textContent,
          price: Number.parseFloat(
            productCard.querySelector(".product-price").textContent.replace("€", "").replace(",", "."),
          ),
          image: productCard.querySelector(".product-image-container img").getAttribute("src").split("/").pop(),
        }
  
        addToCart(product)
  
        // Efecto visual
        this.classList.add("added")
        this.textContent = "Añadido"
  
        setTimeout(() => {
          this.classList.remove("added")
          this.textContent = "Añadir al carrito"
        }, 2000)
      })
    })
  
    // Cargar carrito al iniciar
    loadCart()
  })
  
  