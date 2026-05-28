"use strict";

const allProductsButtons = document.querySelectorAll('.to-cart-button');
sessionStorage.setItem('cart', '');

allProductsButtons.forEach(product => {
    let product_id = product.id.slice(8);
    product.addEventListener("click", (e)=>{
        e.preventDefault();
        let current_cart = [];
        try{
            current_cart = JSON.parse(sessionStorage.getItem('cart'));
        }
        catch{
            
        }
        current_cart.push(product_id);
        sessionStorage.setItem('cart', JSON.stringify(current_cart));
        console.log(sessionStorage.getItem('cart'));
    })
});
