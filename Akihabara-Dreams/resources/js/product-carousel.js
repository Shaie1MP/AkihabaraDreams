document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos los carouseles de productos
    const carousels = document.querySelectorAll('.product-carousel-container');
    
    carousels.forEach(carousel => {
        const track = carousel.querySelector('.product-carousel-track');
        const slides = carousel.querySelectorAll('.product-carousel-slide');
        const prevButton = carousel.querySelector('.product-carousel-button.prev');
        const nextButton = carousel.querySelector('.product-carousel-button.next');
        const dots = carousel.querySelectorAll('.product-carousel-dot');
        
        if (slides.length === 0) return;
        
        // Determinar cuántos slides mostrar a la vez según el ancho de la ventana
        const getItemsPerView = () => {
            if (window.innerWidth >= 1200) return 5;
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 481) return 2;
            return 1;
        };
        
        let currentIndex = 0;
        let itemsPerView = getItemsPerView();
        
        // Actualizar el carousel cuando cambia el tamaño de la ventana
        window.addEventListener('resize', () => {
            itemsPerView = getItemsPerView();
            goToSlide(currentIndex);
        });
        
        // Función para ir a un slide específico
        const goToSlide = (index) => {
            // Asegurarse de que el índice no sea mayor que el máximo permitido
            const maxIndex = Math.max(0, slides.length - itemsPerView);
            currentIndex = Math.min(Math.max(0, index), maxIndex);
            
            // Calcular el desplazamiento
            const slideWidth = slides[0].offsetWidth;
            const offset = -currentIndex * slideWidth;
            
            // Aplicar la transformación
            track.style.transform = `translateX(${offset}px)`;
            
            // Actualizar los dots
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === currentIndex);
            });
            
            // Habilitar/deshabilitar botones según la posición
            prevButton.style.opacity = currentIndex === 0 ? '0.5' : '1';
            nextButton.style.opacity = currentIndex === maxIndex ? '0.5' : '1';
        };
        
        // Configurar los botones de navegación
        prevButton.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
        });
        
        nextButton.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
        });
        
        // Configurar los dots
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                goToSlide(i);
            });
        });
        
        // Inicializar el carousel
        goToSlide(0);
        
        // Autoplay opcional (descomenta para activar)
        /*
        let autoplayInterval;
        
        const startAutoplay = () => {
            autoplayInterval = setInterval(() => {
                const nextIndex = (currentIndex + 1) % (slides.length - itemsPerView + 1);
                goToSlide(nextIndex);
            }, 5000); // Cambiar cada 5 segundos
        };
        
        const stopAutoplay = () => {
            clearInterval(autoplayInterval);
        };
        
        // Iniciar autoplay
        startAutoplay();
        
        // Detener autoplay al interactuar con el carousel
        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);
        */
    });
});