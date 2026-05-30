"use strict";

if (!sessionStorage.getItem('cart')) {
    sessionStorage.setItem('cart', JSON.stringify([]));
}

const toCartButtons = document.querySelectorAll('.to-cart-button');
const addedToCartModalElement = document.getElementById('addedToCartModal');
const addedCartModal = addedToCartModalElement ? new bootstrap.Modal(addedToCartModalElement) : null;

toCartButtons.forEach(button => {
    button.addEventListener("click", (e) => {
        if (!isLoggedIn) return; // Jeśli użytkownik nie jest zalogowany, popups.js wyświetli modal logowania

        e.preventDefault();
        
        let product_id = button.dataset.id;
        let current_cart = JSON.parse(sessionStorage.getItem('cart')) || [];
        
        current_cart.push(product_id);
        sessionStorage.setItem('cart', JSON.stringify(current_cart));
        
        // Pokaż modal sukcesu z Bootstrapa
        if(addedCartModal) {
            addedCartModal.show();
        }
        
        console.log("Obecny koszyk:", sessionStorage.getItem('cart'));
    });
});