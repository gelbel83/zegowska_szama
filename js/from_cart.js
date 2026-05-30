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
        
        const removeButton = event.target.closest('.remove-product');
        if (removeButton) {
            const targetProductId = removeButton.getAttribute('data-id');
            currentCartItems = currentCartItems.filter(id => String(id) !== String(targetProductId));
            
            sessionStorage.setItem('cart', JSON.stringify(currentCartItems));
            renderCart();
            return;
        }

        if (event.target.classList.contains('increase-quantity')) {
            const targetProductId = event.target.getAttribute('data-id');
            currentCartItems.push(targetProductId); 
            sessionStorage.setItem('cart', JSON.stringify(currentCartItems));
            renderCart();
            return;
        }

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
            return;
        }

        if (event.target.id === 'place-order-button') {
            if (currentCartItems.length === 0) {
                alert("Twój koszyk jest pusty!");
                return;
            }

            event.target.disabled = true;
            event.target.innerText = "Przetwarzanie...";

            fetch('../php/place_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(currentCartItems)
            })
            .then(response => response.json()) 
            .then(data => {
                if (data.success) {
                    const modalElement = document.getElementById('order-success-popup');
                    const orderNumberDisplay = document.getElementById('popup-order-number');
                    
                    orderNumberDisplay.innerText = data.order_id;
                    
                    const successModal = new bootstrap.Modal(modalElement);
                    successModal.show();

                    event.target.disabled = false;
                    event.target.innerText = "Złóż zamówienie";

                    modalElement.addEventListener('hidden.bs.modal', function () {
                        sessionStorage.removeItem('cart');
                        renderCart(); 
                    }, { once: true });

                } else {
                    alert("Wystąpił błąd: " + data.message);
                    event.target.disabled = false;
                    event.target.innerText = "Złóż zamówienie";
                }
            })
            .catch(error => {
                console.error("Błąd sieci:", error);
                event.target.disabled = false;
                event.target.innerText = "Złóż zamówienie";
            });
        }
    });
});