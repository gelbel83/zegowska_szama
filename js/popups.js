"use strict";

const kontoLink = document.getElementById('konto-link');
const cartLink = document.getElementById('cart-link'); // Nowe
const showRegisterPopupSpan = document.getElementById('show-register-popup-span');
const showLoginPopupSpan = document.getElementById('show-login-popup-span');
const allPopups = document.querySelectorAll('.popup');

function hideAllPopups() {
    allPopups.forEach(popup => popup.classList.add('hidden'));
}

document.addEventListener('click', (e) => {
    const clickedToCartButton = e.target.closest('.to-cart-button');
    if (clickedToCartButton && !isLoggedIn) {
        e.preventDefault();
        e.stopPropagation();
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
        return;
    }

    const clickedCartLink = cartLink ? cartLink.contains(e.target) : false;
    if (clickedCartLink && !isLoggedIn) {
        e.preventDefault();
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
        return;
    }

    const clickedKontoLink = kontoLink ? kontoLink.contains(e.target) : false;
    if (clickedKontoLink && !isLoggedIn) {
        e.preventDefault();
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
        return;
    }

    const clickedOrdersLink = document.getElementById('orders-link') ? document.getElementById('orders-link').contains(e.target) : false;
    
    if ((clickedCartLink || clickedKontoLink || clickedOrdersLink) && !isLoggedIn) {
        e.preventDefault();
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
        return;
    }

    const clickedInsideAnyPopup = e.target.closest('.popup');
    if (!clickedInsideAnyPopup && !clickedKontoLink && !clickedCartLink) {
        hideAllPopups();
    }
}, true);

if (showRegisterPopupSpan) {
    showRegisterPopupSpan.addEventListener('click', () => {
        hideAllPopups();
        document.getElementById('register-popup').classList.remove('hidden');
    });
}

if (showLoginPopupSpan) {
    showLoginPopupSpan.addEventListener('click', () => {
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
    });
}