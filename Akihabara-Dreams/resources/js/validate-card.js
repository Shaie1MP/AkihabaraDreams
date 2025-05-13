// Validar número de tarjeta usando el algoritmo de Luhn
function validateCardNumber(input) {
    const number = input.value.replace(/\s+|-/g, '');
    const errorElement = document.getElementById('card-number-error');
    
    // Verificar que solo contiene dígitos y tiene la longitud correcta
    if (!/^\d{13,19}$/.test(number)) {
        showError(input, errorElement, "El número de tarjeta debe tener entre 13 y 19 dígitos.");
        return false;
    }
    
    cleanError(input, errorElement);
    return true;
}

// Validar fecha de expiración
function validateExpirationDate(input) {
    const date = input.value;
    const errorElement = document.getElementById('card-expiration-error');
    
    // Verificar formato MM/AA o MM/AAAA
    if (!/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/.test(date)) {
        mostrarError(input, errorElement, "La fecha debe tener el formato MM/AA.");
        return false;
    }
    
    const parts = date.split('/');
    const month = parseInt(parts[0]);
    let year = parseInt(parts[1]);
    
    // Convertir año de 2 dígitos a 4 dígitos
    if (year < 100) {
        year += 2000;
    }
    
    // Obtener fecha actual
    const actualDate = new Date();
    const actualMonth = actualDate.getMonth() + 1; 
    const actualYear = actualDate.getFullYear();
    
    // Verificar que la fecha no esté expirada
    if (year < actualYear || (year === actualYear && month < actualMonth)) {
        showError(input, errorElement, "La tarjeta ha expirado.");
        return false;
    }
    
    cleanError(input, errorElement);
    return true;
}

// Validar CVC
function validateCVC(input) {
    const cvc = input.value;
    const errorElement = document.getElementById('card-cvc-error');
    
    // Determinar el tipo de tarjeta basado en el número
    const cardNumber = document.getElementById('card-number').value.replace(/\s+|-/g, '');
    const esAmex = /^3[47]/.test(cardNumber);
    
    // American Express usa CVC de 4 dígitos, el resto usa 3 dígitos
    const regex = esAmex ? /^\d{4}$/ : /^\d{3}$/;
    
    if (!regex.test(cvc)) {
        const lenght = esAmex ? "4" : "3";
        showError(input, errorElement, `El CVC debe tener ${lenght} dígitos.`);
        return false;
    }
    
    cleanError(input, errorElement);
    return true;
}

// Funciones auxiliares para mostrar y ocultar errores
function showError(input, errorElement, message) {
    input.classList.add('error');
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

function cleanError(input, errorElement) {
    input.classList.remove('error');
    errorElement.textContent = '';
    errorElement.style.display = 'none';
}

// Formatear número de tarjeta para que mientras se escribe se agreguen espacios 
function formatCardNumber(input) {
    let value = input.value.replace(/\D/g, '');
    let formated = '';
    
    for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) {
            formated += ' ';
        }
        formated += value.charAt(i);
    }
    
    input.value = formated;
}

// Formatear fecha de expiración para que mientras se escribe se agregue /
function formatExpirationDate(input) {
    let value = input.value.replace(/\D/g, '');
    
    if (value.length > 2) {
        input.value = value.substring(0, 2) + '/' + value.substring(2, 4);
    } else {
        input.value = value;
    }
}

// Validar todo el formulario antes de enviar
function validatePayForm() {
    const cardNumber = document.getElementById('card-number');
    const expirationDate = document.getElementById('card-expiration');
    const cvc = document.getElementById('card-cvc');
    
    const isValidNumber = validateCardNumber(cardNumber);
    const isValidDate = validateExpirationDate(expirationDate);
    const isValidCVC = validateCVC(cvc);
    
    return isValidNumber && isValidDate && isValidCVC;
}

// Configurar eventos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const cardNumber = document.getElementById('card-number');
    const expirationDate = document.getElementById('card-expiration');
    const cvc = document.getElementById('card-cvc');
    const form = document.getElementById('order-form');

    if (cardNumber) {
        const numberError = document.createElement('div');
        numberError.id = 'card-number-error';
        numberError.className = 'error-message';
        cardNumber.parentNode.appendChild(numberError);
        
        // Eventos para número de tarjeta
        cardNumber.addEventListener('input', function() {
            formatCardNumber(this);
        });
        cardNumber.addEventListener('blur', function() {
            validateCardNumber(this);
        });
    }
    
    if (expirationDate) {
        const dateError = document.createElement('div');
        dateError.id = 'card-expiration-error';
        dateError.className = 'error-message';
        expirationDate.parentNode.appendChild(dateError);
        
        // Eventos para fecha de expiración
        expirationDate.addEventListener('input', function() {
            formatExpirationDate(this);
        });
        expirationDate.addEventListener('blur', function() {
            validateExpirationDate(this);
        });
    }
    
    if (cvc) {
        const errorCVC = document.createElement('div');
        errorCVC.id = 'card-cvc-error';
        errorCVC.className = 'error-message';
        cvc.parentNode.appendChild(errorCVC);
        
        // Eventos para CVC
        cvc.addEventListener('blur', function() {
            validateCVC(this);
        });
    }
    
    // Validar todo el formulario antes de enviar
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validatePayForm()) {
                event.preventDefault();
            }
        });
    }
});