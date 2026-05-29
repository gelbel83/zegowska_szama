"use strict";

if (!sessionStorage.getItem('cart')) {
    sessionStorage.setItem('cart', JSON.stringify([]));
}

const toCartButtons = document.querySelectorAll('.to-cart-button');

toCartButtons.forEach(button => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        
        let product_id = button.dataset.id;
        
        let current_cart = JSON.parse(sessionStorage.getItem('cart')) || [];
        current_cart.push(product_id);
        
        sessionStorage.setItem('cart', JSON.stringify(current_cart));
        
        alert("Dodano do koszyka!"); 
        console.log("Obecny koszyk:", sessionStorage.getItem('cart'));
    });
});