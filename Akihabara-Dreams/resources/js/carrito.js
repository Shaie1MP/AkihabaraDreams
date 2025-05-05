// Funcionalidad para el contador del carrito
document.addEventListener("DOMContentLoaded", () => {
  console.log("Inicializando funcionalidad del carrito");
  
  // Actualizar el contador del carrito al cargar la página
  updateCartCounter();
  
  const cartModal = document.getElementById("cartModal");
  const cartIcon = document.getElementById("carrito");
  const closeModal = document.querySelector(".close");
  
  // Verificar que los elementos existen antes de añadir event listeners
  if (cartIcon) {
      console.log("Elemento del carrito encontrado, añadiendo event listener");
      cartIcon.addEventListener("click", () => {
          if (cartModal) {
              cartModal.style.display = "flex";
          } else {
              console.error("Modal del carrito no encontrado");
          }
      });
  } else {
      console.error("Elemento del carrito no encontrado");
  }
  
  if (closeModal) {
      closeModal.onclick = () => {
          if (cartModal) {
              cartModal.style.display = "none";
          }
      };
  }
  
  // Cerrar modal al hacer clic fuera
  window.onclick = (event) => {
      if (cartModal && event.target == cartModal) {
          cartModal.style.display = "none";
      }
  };
  
  // Configurar event listeners para los botones de eliminar
  setupRemoveButtons();
});

// Función para actualizar el contador del carrito
function updateCartCounter() {
  console.log("Actualizando contador del carrito");
  
  // Hacer una petición AJAX para obtener el número de productos en el carrito
  fetch("/Akihabara-Dreams/app/includes/cart-count.php")
      .then(response => {
          if (!response.ok) {
              throw new Error(`Error HTTP: ${response.status}`);
          }
          return response.json();
      })
      .then(data => {
          console.log("Datos recibidos del contador:", data);
          const counter = document.getElementById("cart-counter");
          
          if (counter) {
              if (data.count > 0) {
                  counter.textContent = data.count;
                  counter.style.display = "flex";
                  console.log(`Contador actualizado: ${data.count} productos`);
              } else {
                  counter.textContent = "";
                  counter.style.display = "none";
                  console.log("Carrito vacío, ocultando contador");
              }
          } else {
              console.error("Elemento del contador no encontrado");
          }
      })
      .catch(error => {
          console.error("Error al obtener el contador del carrito:", error);
      });
}

// Función para añadir un producto al carrito mediante AJAX
function addToCart(productId, quantity = 1) {
  console.log(`Añadiendo producto ${productId} al carrito (cantidad: ${quantity})`);
  
  fetch(`/Akihabara-Dreams/app/includes/add-to-cart.php?id_product=${productId}&quantity=${quantity}&redirect=false`)
      .then(response => {
          if (!response.ok) {
              throw new Error(`Error HTTP: ${response.status}`);
          }
          return response.json();
      })
      .then(data => {
          console.log("Respuesta al añadir al carrito:", data);
          
          if (data.success) {
              // Mostrar notificación
              const notification = document.getElementById("cart-notification");
              if (notification) {
                  notification.textContent = "Producto añadido al carrito";
                  notification.classList.add("show");
                  
                  // Ocultar la notificación después de 3 segundos
                  setTimeout(() => {
                      notification.classList.remove("show");
                  }, 3000);
              }
              
              // Actualizar el contador del carrito
              updateCartCounter();
          } else {
              console.error("Error al añadir producto:", data.message || "Error desconocido");
          }
      })
      .catch(error => {
          console.error("Error al añadir al carrito:", error);
      });
}

// Función para configurar los botones de eliminar
function setupRemoveButtons() {
  const removeButtons = document.querySelectorAll(".remove-item");
  
  removeButtons.forEach(button => {
      button.addEventListener("click", function(event) {
          event.preventDefault();
          const productId = this.getAttribute("data-id");
          
          if (productId) {
              removeFromCart(productId);
          }
      });
  });
}

// Función para eliminar un producto del carrito
function removeFromCart(productId) {
  console.log(`Eliminando producto ${productId} del carrito`);
  
  fetch(`/Akihabara-Dreams/app/includes/remove-from-cart.php?id_product=${productId}`)
      .then(response => {
          if (!response.ok) {
              throw new Error(`Error HTTP: ${response.status}`);
          }
          return response.json();
      })
      .then(data => {
          console.log("Respuesta al eliminar del carrito:", data);
          
          if (data.success) {
              // Actualizar la interfaz
              const cartItem = document.querySelector(`.cart-item[data-id="${productId}"]`);
              if (cartItem) {
                  cartItem.remove();
              }
              
              // Actualizar el contador
              updateCartCounter();
              
              // Mostrar notificación
              const notification = document.getElementById("cart-notification");
              if (notification) {
                  notification.textContent = "Producto eliminado del carrito";
                  notification.classList.add("show");
                  
                  setTimeout(() => {
                      notification.classList.remove("show");
                  }, 3000);
              }
          } else {
              console.error("Error al eliminar producto:", data.message || "Error desconocido");
          }
      })
      .catch(error => {
          console.error("Error al eliminar del carrito:", error);
      });
}

// Exponer las funciones para que puedan ser llamadas desde otras partes
window.updateCartCounter = updateCartCounter;
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;