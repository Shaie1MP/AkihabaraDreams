/**
 * Category Carousel - Script para manejar los carruseles de categorías
 */
document.addEventListener('DOMContentLoaded', function() {
    // Función para inicializar un carrusel
    function initCategoryCarousel(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        const track = container.querySelector('.category-carousel-track');
        const slides = Array.from(container.querySelectorAll('.category-carousel-slide'));
        const nextButton = container.querySelector('.category-carousel-button.next');
        const prevButton = container.querySelector('.category-carousel-button.prev');
        
        if (!track || slides.length === 0 || !nextButton || !prevButton) return;
        
        let slideWidth = slides[0].getBoundingClientRect().width;
        let slideIndex = 0;
        let slidesPerView = getNumSlidesPerView();
        
        // Configurar posición inicial de los slides
        function setSlidePosition() {
            slideWidth = slides[0].getBoundingClientRect().width;
            slides.forEach((slide, index) => {
                slide.style.left = slideWidth * index + 'px';
            });
        }
        
        // Obtener número de slides visibles según el ancho de la ventana
        function getNumSlidesPerView() {
            if (window.innerWidth >= 1200) return 5;
            if (window.innerWidth >= 992) return 4;
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 576) return 2;
            return 1;
        }
        
        // Mover a un slide específico
        function moveToSlide(targetIndex) {
            if (targetIndex < 0) {
                targetIndex = 0;
            } else if (targetIndex > slides.length - slidesPerView) {
                targetIndex = slides.length - slidesPerView;
            }
            
            track.style.transform = 'translateX(-' + (slideWidth * targetIndex) + 'px)';
            slideIndex = targetIndex;
        }
        
        // Event listeners
        nextButton.addEventListener('click', () => {
            moveToSlide(slideIndex + 1);
        });
        
        prevButton.addEventListener('click', () => {
            moveToSlide(slideIndex - 1);
        });
        
        // Responsive
        window.addEventListener('resize', () => {
            const newSlidesPerView = getNumSlidesPerView();
            if (newSlidesPerView !== slidesPerView) {
                slidesPerView = newSlidesPerView;
                if (slideIndex > slides.length - slidesPerView) {
                    slideIndex = slides.length - slidesPerView;
                }
            }
            setSlidePosition();
            moveToSlide(slideIndex);
        });
        
        // Inicializar
        setSlidePosition();
        
        // Soporte para gestos táctiles
        let touchStartX = 0;
        let touchEndX = 0;
        
        track.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, {passive: true});
        
        track.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, {passive: true});
        
        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                // Deslizar a la izquierda
                moveToSlide(slideIndex + 1);
            } else if (touchEndX > touchStartX + swipeThreshold) {
                // Deslizar a la derecha
                moveToSlide(slideIndex - 1);
            }
        }
    }
    
    // Inicializar todos los carruseles
    initCategoryCarousel('figuras-carousel-container');
    initCategoryCarousel('mangas-carousel-container');
    initCategoryCarousel('merchandising-carousel-container');
});