document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(document.querySelectorAll('.carousel-slide'));
    const nextButton = document.querySelector('.carousel-button.next');
    const prevButton = document.querySelector('.carousel-button.prev');
    const dotsNav = document.querySelector('.carousel-dots');
    const dots = Array.from(document.querySelectorAll('.carousel-dot'));
    
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
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
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
    
    // Autoplay opcional
    let autoplayInterval;
    
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            let nextIndex = slideIndex + 1;
            if (nextIndex > slides.length - slidesPerView) {
                nextIndex = 0;
            }
            moveToSlide(nextIndex);
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
});