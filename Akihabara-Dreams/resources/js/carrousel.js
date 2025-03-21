document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(document.querySelectorAll('.carousel-slide'));
    const nextButton = document.querySelector('.carousel-button.next');
    const prevButton = document.querySelector('.carousel-button.prev');
    const dotsNav = document.querySelector('.carousel-dots');
    const dots = Array.from(document.querySelectorAll('.carousel-dot'));
    
    let slideWidth = slides[0].getBoundingClientRect().width;
    let slideIndex = 0;
    
    // Configurar posición inicial de los slides
    function setSlidePosition() {
        slideWidth = slides[0].getBoundingClientRect().width;
        slides.forEach((slide, index) => {
            slide.style.left = slideWidth * index + 'px';
        });
    }
    
    // Mover a un slide específico
    function moveToSlide(targetIndex) {
        if (targetIndex < 0) {
            targetIndex = slides.length - 1;
        } else if (targetIndex >= slides.length) {
            targetIndex = 0;
        }
        
        track.style.transform = 'translateX(-' + (slideWidth * targetIndex) + 'px)';
        slideIndex = targetIndex;
        
        // Actualizar dots
        dots.forEach(dot => dot.classList.remove('active'));
        dots[slideIndex].classList.add('active');
    }
    
    // Event listeners
    nextButton.addEventListener('click', () => {
        moveToSlide(slideIndex + 1);
    });
    
    prevButton.addEventListener('click', () => {
        moveToSlide(slideIndex - 1);
    });
    
    dotsNav.addEventListener('click', e => {
        const targetDot = e.target.closest('button');
        if (!targetDot) return;
        
        const targetIndex = parseInt(targetDot.getAttribute('data-index'));
        moveToSlide(targetIndex);
    });
    
    // Responsive
    window.addEventListener('resize', () => {
        setSlidePosition();
        moveToSlide(slideIndex);
    });
    
    // Inicializar
    setSlidePosition();
    
    // Autoplay
    let autoplayInterval;
    
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            moveToSlide(slideIndex + 1);
        }, 5000); // Cambiar cada 5 segundos
    }
    
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    // Iniciar autoplay
    startAutoplay();
    
    // Detener autoplay al interactuar
    track.addEventListener('mouseenter', stopAutoplay);
    nextButton.addEventListener('mouseenter', stopAutoplay);
    prevButton.addEventListener('mouseenter', stopAutoplay);
    dotsNav.addEventListener('mouseenter', stopAutoplay);
    
    // Reanudar autoplay al dejar de interactuar
    track.addEventListener('mouseleave', startAutoplay);
    nextButton.addEventListener('mouseleave', startAutoplay);
    prevButton.addEventListener('mouseleave', startAutoplay);
    dotsNav.addEventListener('mouseleave', startAutoplay);
    
    // Navegación con teclado
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight') {
            moveToSlide(slideIndex + 1);
        } else if (e.key === 'ArrowLeft') {
            moveToSlide(slideIndex - 1);
        }
    });
    
    // Soporte para gestos táctiles
    let touchStartX = 0;
    let touchEndX = 0;
    
    track.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    }, {passive: true});
    
    track.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        startAutoplay();
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
});