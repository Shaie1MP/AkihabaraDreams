// Script para mejorar la visualización de promociones
document.addEventListener("DOMContentLoaded", () => {
    // Añadir efectos visuales a los productos con promoción
    const promotionProducts = document.querySelectorAll(".product.has-promotion")
    console.log("Productos con promoción encontrados:", promotionProducts.length)

    // Contador de tiempo para promociones que están por expirar
    function initCountdowns() {
        const countdownElements = document.querySelectorAll("[data-expiry]")

        countdownElements.forEach((element) => {
            const expiryDate = new Date(element.dataset.expiry)

            function updateCountdown() {
                const now = new Date()
                const diff = expiryDate - now

                if (diff <= 0) {
                    element.textContent = "Promoción expirada"
                    return
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24))
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))

                element.textContent = `Expira en: ${days}d ${hours}h ${minutes}m`
            }

            updateCountdown()
            setInterval(updateCountdown, 60000) // Actualizar cada minuto
        })
    }

    // Iniciar contadores si existen elementos con data-expiry
    initCountdowns()

    // Filtrado de productos en promoción (si implementas filtros)
    const filterButtons = document.querySelectorAll(".promociones-filter-btn")
    if (filterButtons.length > 0) {
        filterButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const filter = this.dataset.filter

                // Remover clase activa de todos los botones
                filterButtons.forEach((btn) => btn.classList.remove("active"))

                // Añadir clase activa al botón clickeado
                this.classList.add("active")

                // Filtrar productos
                const products = document.querySelectorAll(".catalogo-item")
                products.forEach((product) => {
                    if (filter === "all") {
                        product.style.display = "block"
                    } else {
                        const discount = Number.parseInt(product.dataset.discount)

                        if (filter === "high" && discount >= 30) {
                            product.style.display = "block"
                        } else if (filter === "medium" && discount >= 15 && discount < 30) {
                            product.style.display = "block"
                        } else if (filter === "low" && discount < 15) {
                            product.style.display = "block"
                        } else {
                            product.style.display = "none"
                        }
                    }
                })
            })
        })
    }


})
