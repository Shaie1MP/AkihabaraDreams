document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchButton = document.getElementById('search-toggle');
    const productsContainer = document.getElementById('products-container');
    const productCards = productsContainer.querySelectorAll('.product-card');
    const noResultsMessage = document.getElementById('no-results-message');
    
    // Función para filtrar productos
    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            // Si no hay término de búsqueda, restablecer la paginación
            productCards.forEach(card => {
                card.classList.remove('filtered-out');
            });
            
            // Restablecer paginación
            if (window.paginationSystem) {
                window.paginationSystem.resetPagination();
            }
            
            noResultsMessage.style.display = 'none';
            return;
        }
        
        // Filtrar productos según el término de búsqueda
        let hasResults = false;
        
        productCards.forEach(card => {
            const title = card.querySelector('.product-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
                card.classList.remove('filtered-out');
                hasResults = true;
            } else {
                card.style.display = 'none';
                card.classList.add('filtered-out');
            }
        });
        
        // Mostrar mensaje si no hay resultados
        if (!hasResults) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
        
        // Ocultar paginación durante la búsqueda
        document.getElementById('pagination-container').style.display = hasResults ? 'flex' : 'none';
    }
    
    // Evento para el botón de búsqueda
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        filterProducts();
    });
    
    // Evento para buscar al presionar Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            filterProducts();
        }
    });
    
    // Evento para restablecer la búsqueda cuando se borra el campo
    searchInput.addEventListener('input', function() {
        if (this.value === '') {
            // Restablecer la visualización de todos los productos
            productCards.forEach(card => {
                card.classList.remove('filtered-out');
            });
            
            // Restablecer paginación
            if (window.paginationSystem) {
                window.paginationSystem.resetPagination();
            }
            
            noResultsMessage.style.display = 'none';
        }
    });
});