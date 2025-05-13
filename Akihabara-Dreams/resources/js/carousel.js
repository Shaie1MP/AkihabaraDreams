document.addEventListener("DOMContentLoaded", () => {
  initFeaturedCarousel()
})

function initFeaturedCarousel() {
  const track = document.querySelector(".featured-carousel-track")
  const items = document.querySelectorAll(".featured-carousel-item")
  const prevButton = document.querySelector(".featured-carousel-button.prev")
  const nextButton = document.querySelector(".featured-carousel-button.next")
  const dotsContainer = document.querySelector(".featured-carousel-dots")

  if (!track || items.length === 0) return

  let currentIndex = 0
  let itemsPerView = 3 // Mantener 3 productos visibles a la vez

  // Ajustar el número de elementos visibles según el tamaño de la ventana
  function updateItemsPerView() {
    if (window.innerWidth < 576) {
      itemsPerView = 1
    } else if (window.innerWidth < 992) {
      itemsPerView = 2
    } else {
      itemsPerView = 3 // Mostrar 3 productos en pantallas grandes
    }

    // Calcular el índice máximo basado en la cantidad de elementos y los visibles por vista
    return Math.max(0, items.length - itemsPerView)
  }

  let maxIndex = updateItemsPerView()

  // Crear los puntos de navegación
  function createDots() {
    dotsContainer.innerHTML = ""
    // Crear un punto por cada posición posible del carrusel
    for (let i = 0; i <= maxIndex; i++) {
      const dot = document.createElement("div")
      dot.classList.add("featured-carousel-dot")
      if (i === 0) dot.classList.add("active")
      dot.addEventListener("click", () => {
        goToSlide(i)
      })
      dotsContainer.appendChild(dot)
    }
  }

  createDots()

  // Actualizar los puntos de navegación
  function updateDots() {
    const dots = document.querySelectorAll(".featured-carousel-dot")
    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === currentIndex)
    })
  }

  // Calcular la posición del slide
  function getSlidePosition(index) {
    const itemWidth =
      items[0].offsetWidth +
      Number.parseInt(window.getComputedStyle(items[0]).marginLeft) +
      Number.parseInt(window.getComputedStyle(items[0]).marginRight)
    return -index * itemWidth
  }

  // Ir a un slide específico
  function goToSlide(index) {
    currentIndex = Math.max(0, Math.min(index, maxIndex))
    track.style.transform = `translateX(${getSlidePosition(currentIndex)}px)`
    updateDots()

    // Actualizar visibilidad de los botones de navegación
    prevButton.style.visibility = currentIndex === 0 ? "hidden" : "visible"
    nextButton.style.visibility = currentIndex === maxIndex ? "hidden" : "visible"
  }

  // Slide anterior
  prevButton.addEventListener("click", () => {
    goToSlide(currentIndex - 1)
  })

  // Siguiente slide
  nextButton.addEventListener("click", () => {
    goToSlide(currentIndex + 1)
  })

  // Inicializar visibilidad de botones
  prevButton.style.visibility = "hidden" // Ocultar botón previo al inicio
  nextButton.style.visibility = items.length <= itemsPerView ? "hidden" : "visible"

  // Manejar el evento de redimensionamiento
  window.addEventListener("resize", () => {
    maxIndex = updateItemsPerView()
    createDots()

    // Ajustar la posición del slide actual
    currentIndex = Math.min(currentIndex, maxIndex)
    track.style.transform = `translateX(${getSlidePosition(currentIndex)}px)`

    // Actualizar visibilidad de los botones
    prevButton.style.visibility = currentIndex === 0 ? "hidden" : "visible"
    nextButton.style.visibility = currentIndex === maxIndex ? "hidden" : "visible"
  })

  // Auto slide cada 5 segundos (solo si hay más productos que los visibles)
  if (items.length > itemsPerView) {
    setInterval(() => {
      // Volver al principio cuando llegue al final
      if (currentIndex >= maxIndex) {
        goToSlide(0)
      } else {
        goToSlide(currentIndex + 1)
      }
    }, 5000)
  }
}
