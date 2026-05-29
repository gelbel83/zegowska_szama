"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const cartDisplayContainer = document.getElementById('products_display');

    function renderCart() {
        let storedCart = sessionStorage.getItem('cart');
        let currentCartItems = [];
        
        try {
            currentCartItems = JSON.parse(storedCart) || [];
        } catch (error) {
            console.error("Błąd parsowania danych koszyka", error);
        }

        fetch('../php/get_cart_items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(currentCartItems) 
        })
        .then(response => response.text())
        .then(htmlContent => {
            cartDisplayContainer.innerHTML = htmlContent;
        })
        .catch(error => {
            console.error('Błąd:', error);
            cartDisplayContainer.innerHTML = "<p class='text-danger text-center'>Wystąpił błąd podczas ładowania koszyka.</p>";
        });
    }

    renderCart();

    cartDisplayContainer.addEventListener('click', (event) => {
        let currentCartItems = JSON.parse(sessionStorage.getItem('cart')) || [];
        
        // usuwanie produktu
        const removeButton = event.target.closest('.remove-product');
        if (removeButton) {
            const targetProductId = removeButton.getAttribute('data-id');
            currentCartItems = currentCartItems.filter(id => String(id) !== String(targetProductId));
            
            sessionStorage.setItem('cart', JSON.stringify(currentCartItems));
            renderCart();
            return;
        }

        // plus
        if (event.target.classList.contains('increase-quantity')) {
            const targetProductId = event.target.getAttribute('data-id');
            currentCartItems.push(targetProductId); 
            sessionStorage.setItem('cart', JSON.stringify(currentCartItems));
            renderCart();
        }

        // minus
        if (event.target.classList.contains('decrease-quantity')) {
            const targetProductId = event.target.getAttribute('data-id');
            const currentProductCount = currentCartItems.filter(id => String(id) === String(targetProductId)).length;
            
            if (currentProductCount <= 1) {
                return; 
            }
            
            const productIndexInCart = currentCartItems.indexOf(String(targetProductId)); 
            if (productIndexInCart > -1) {
                currentCartItems.splice(productIndexInCart, 1);
                sessionStorage.setItem('cart', JSON.stringify(currentCartItems));
                renderCart();
            }
        }
    });
});