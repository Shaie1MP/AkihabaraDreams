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
    let itemsPerView = 3 // Default to 3 items per view for desktop
  
    // Adjust items per view based on screen size
    function updateItemsPerView() {
      if (window.innerWidth < 576) {
        itemsPerView = 1
      } else if (window.innerWidth < 992) {
        itemsPerView = 2
      } else {
        itemsPerView = 3
      }
      return Math.max(0, items.length - itemsPerView)
    }
  
    let maxIndex = updateItemsPerView()
  
    // Create dots
    function createDots() {
      dotsContainer.innerHTML = ""
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
  
    // Update dots
    function updateDots() {
      const dots = document.querySelectorAll(".featured-carousel-dot")
      dots.forEach((dot, index) => {
        dot.classList.toggle("active", index === currentIndex)
      })
    }
  
    // Calculate slide position
    function getSlidePosition(index) {
      const itemWidth =
        items[0].offsetWidth +
        Number.parseInt(window.getComputedStyle(items[0]).marginLeft) +
        Number.parseInt(window.getComputedStyle(items[0]).marginRight)
      return -index * itemWidth
    }
  
    // Go to specific slide
    function goToSlide(index) {
      currentIndex = Math.max(0, Math.min(index, maxIndex))
      track.style.transform = `translateX(${getSlidePosition(currentIndex)}px)`
      updateDots()
    }
  
    // Previous slide
    prevButton.addEventListener("click", () => {
      goToSlide(currentIndex - 1)
    })
  
    // Next slide
    nextButton.addEventListener("click", () => {
      goToSlide(currentIndex + 1)
    })
  
    // Handle window resize
    window.addEventListener("resize", () => {
      maxIndex = updateItemsPerView()
      createDots()
  
      // Adjust current position
      currentIndex = Math.min(currentIndex, maxIndex)
      track.style.transform = `translateX(${getSlidePosition(currentIndex)}px)`
    })
  
    // Auto slide every 5 seconds
    setInterval(() => {
      goToSlide((currentIndex + 1) % (maxIndex + 1))
    }, 5000)
  }
  
  