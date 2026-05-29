"use strict";

const kontoLink = document.getElementById('konto-link');
const showRegisterPopupSpan = document.getElementById('show-register-popup-span');
const showLoginPopupSpan = document.getElementById('show-login-popup-span');

const allPopups = document.querySelectorAll('.popup');

function hideAllPopups() {
    allPopups.forEach(popup => {
        popup.classList.add('hidden');
    });
}

document.addEventListener('click', (e) => {
    const clickedToCartButton = e.target.closest('.to-cart-button');

    if (clickedToCartButton) {
        if (!isLoggedIn) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            hideAllPopups();
            document.getElementById('login-popup').classList.remove('hidden');
        }
        return; 
    }

    const clickedInsideAnyPopup = e.target.closest('.popup'); 
    const clickedKontoLink = kontoLink ? kontoLink.contains(e.target) : false;

    if (!clickedInsideAnyPopup && !clickedKontoLink) {
        hideAllPopups();
    }
}, true); 

if (kontoLink) {
    kontoLink.addEventListener('click', (e) => {
        e.stopPropagation();
        if (!isLoggedIn) {
            hideAllPopups();
            document.getElementById('login-popup').classList.remove('hidden');
        }
    });
}

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