document.addEventListener('DOMContentLoaded', function() {
    const showAllButtons = document.querySelectorAll('.show-all-button');
    
    showAllButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            const container = document.getElementById(category + '-container');
            const hiddenProducts = container.querySelectorAll('.hidden-product');
            
            hiddenProducts.forEach(product => {
                product.classList.remove('hidden-product');
            });
            
            this.parentElement.style.display = 'none';
        });
    });
});