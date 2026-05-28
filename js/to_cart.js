"use strict";

const allProductsButtons = document.querySelectorAll('.to-cart-button');
sessionStorage.setItem('koszyk', '');
allProductsButtons.forEach(product => {
    let product_id = product.id.slice(8);
    product.addEventListener("click", (e)=>{
        e.preventDefault();

    })
});
