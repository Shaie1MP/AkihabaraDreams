document.addEventListener('DOMContentLoaded', function() {
    const orderHeaders = document.querySelectorAll('.admin-order-header');
    orderHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const content = this.nextElementSibling;
            content.classList.toggle('active');
        });
    });
});