"use strict";

const loginModalElement = document.getElementById('loginModal');
const registerModalElement = document.getElementById('registerModal');

const loginModal = loginModalElement ? new bootstrap.Modal(loginModalElement) : null;
const registerModal = registerModalElement ? new bootstrap.Modal(registerModalElement) : null;

const kontoLink = document.getElementById('konto-link');
const cartLink = document.getElementById('cart-link');
const showRegisterPopupSpan = document.getElementById('show-register-popup-span');
const showLoginPopupSpan = document.getElementById('show-login-popup-span');
const ordersLink = document.getElementById('orders-link'); 

document.addEventListener('click', (e) => {
    const clickedToCartButton = e.target.closest('.to-cart-button');
    if (clickedToCartButton && !isLoggedIn) {
        e.preventDefault();
        e.stopPropagation();
        if(loginModal) loginModal.show();
        return;
    }

    const clickedCartLink = cartLink ? cartLink.contains(e.target) : false;
    const clickedKontoLink = kontoLink ? kontoLink.contains(e.target) : false;
    const clickedOrdersLink = ordersLink ? ordersLink.contains(e.target) : false;
    
    if ((clickedCartLink || clickedKontoLink || clickedOrdersLink) && !isLoggedIn) {
        e.preventDefault();
        if(loginModal) loginModal.show();
        return;
    }
}, true);

if (showRegisterPopupSpan) {
    showRegisterPopupSpan.addEventListener('click', (e) => {
        e.preventDefault();
        if(loginModal) loginModal.hide();
        if(registerModal) registerModal.show();
    });
}

if (showLoginPopupSpan) {
    showLoginPopupSpan.addEventListener('click', (e) => {
        e.preventDefault();
        if(registerModal) registerModal.hide();
        if(loginModal) loginModal.show();
    });
}