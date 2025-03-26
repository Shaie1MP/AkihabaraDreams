document.addEventListener('DOMContentLoaded', function () {
    // Configuración de paginación
    const productsPerPage = 10;
    const totalPages = Math.ceil(totalProducts / productsPerPage);
    let currentPage = 1;

    // Elementos del DOM
    const productsContainer = document.getElementById('products-container');
    const paginationContainer = document.getElementById('pagination-container');
    const productCards = productsContainer.querySelectorAll('.product-card');

    // Inicializar paginación
    initPagination();

    // Función para inicializar la paginación
    function initPagination() {
        // Ocultar todos los productos inicialmente
        productCards.forEach(card => {
            card.style.display = 'none';
        });

        // Mostrar productos de la primera página
        showProductsForPage(1);

        // Crear controles de paginación
        createPaginationControls();
    }

    // Función para mostrar productos de una página específica
    function showProductsForPage(page) {
        // Calcular índices de inicio y fin
        const startIndex = (page - 1) * productsPerPage;
        const endIndex = Math.min(startIndex + productsPerPage, totalProducts);

        // Ocultar todos los productos
        productCards.forEach(card => {
            card.style.display = 'none';
        });

        // Mostrar solo los productos de la página actual
        for (let i = startIndex; i < endIndex; i++) {
            if (productCards[i]) {
                productCards[i].style.display = 'block';
            }
        }

        // Actualizar página actual
        currentPage = page;

        // Actualizar controles de paginación
        updatePaginationControls();
    }

    // Función para crear controles de paginación
    function createPaginationControls() {
        if (totalPages <= 1) {
            paginationContainer.style.display = 'none';
            return;
        }

        paginationContainer.innerHTML = '';

        // Botón Anterior
        const prevButton = document.createElement('span');
        prevButton.className = 'pagination-button' + (currentPage === 1 ? ' disabled' : '');
        prevButton.innerHTML = '←'; 
        if (currentPage > 1) {
            prevButton.addEventListener('click', () => showProductsForPage(currentPage - 1));
        }
        paginationContainer.appendChild(prevButton);

        // Números de página
        const range = 2;

        // Primera página
        if (currentPage - range > 1) {
            addPageButton(1);
            if (currentPage - range > 2) {
                addEllipsis();
            }
        }

        // Páginas alrededor de la actual
        for (let i = Math.max(1, currentPage - range); i <= Math.min(totalPages, currentPage + range); i++) {
            addPageButton(i);
        }

        // Última página
        if (currentPage + range < totalPages) {
            if (currentPage + range < totalPages - 1) {
                addEllipsis();
            }
            addPageButton(totalPages);
        }

        // Botón Siguiente
        const nextButton = document.createElement('span');
        nextButton.className = 'pagination-button' + (currentPage === totalPages ? ' disabled' : '');
        nextButton.innerHTML = '→'; // Simplificado a una flecha
        if (currentPage < totalPages) {
            nextButton.addEventListener('click', () => showProductsForPage(currentPage + 1));
        }
        paginationContainer.appendChild(nextButton);
    }

    // Función para actualizar controles de paginación
    function updatePaginationControls() {
        createPaginationControls();
    }

    // Función para añadir botón de página
    function addPageButton(pageNum) {
        const pageButton = document.createElement('span');
        pageButton.className = 'pagination-button' + (pageNum === currentPage ? ' active' : '');
        pageButton.textContent = pageNum;
        if (pageNum !== currentPage) {
            pageButton.addEventListener('click', () => showProductsForPage(pageNum));
        }
        paginationContainer.appendChild(pageButton);
    }

    // Función para añadir elipsis
    function addEllipsis() {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'pagination-ellipsis';
        ellipsis.textContent = '...';
        paginationContainer.appendChild(ellipsis);
    }

    // Exponer funciones para uso externo (para la búsqueda)
    window.paginationSystem = {
        showProductsForPage,
        resetPagination: function () {
            showProductsForPage(1);
        }
    };
});