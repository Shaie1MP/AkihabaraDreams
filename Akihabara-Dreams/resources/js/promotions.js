document.addEventListener("DOMContentLoaded", () => {
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

            // Actualizar cada minuto
            setInterval(updateCountdown, 60000)
        })
    }

    initCountdowns()
})
