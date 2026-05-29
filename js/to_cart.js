"use strict";

if (!sessionStorage.getItem('cart')) {
    sessionStorage.setItem('cart', JSON.stringify([]));
}

const toCartButtons = document.querySelectorAll('.to-cart-button');
const addedPopup = document.getElementById('added-to-cart-popup');
const closeAddedPopupBtn = document.querySelector('#added-to-cart-popup .orange-button');

toCartButtons.forEach(button => {
    button.addEventListener("click", (e) => {
        if (!isLoggedIn) return; 

        e.preventDefault();
        
        let product_id = button.dataset.id;
        
        let current_cart = JSON.parse(sessionStorage.getItem('cart')) || [];
        current_cart.push(product_id);
        
        sessionStorage.setItem('cart', JSON.stringify(current_cart));
        addedPopup.classList.remove('hidden');
        
        
        console.log("Obecny koszyk:", sessionStorage.getItem('cart'));
    });
});