const cartModal = document.getElementById("cartModal");
const closeModal = document.querySelector(".close");
const cartItemsContainer = document.getElementById("cartItemsContainer");

document.getElementById("carrito").addEventListener("click", () => {
    cartModal.style.display = "flex";
});

closeModal.onclick = () => {
    cartModal.style.display = "none";
};

window.onclick = (event) => {
    if (event.target == cartModal) {
        cartModal.style.display = "none";
    }
};    