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
    const clickedInsideAnyPopup = e.target.closest('.popup'); 
    
    const clickedKontoLink = kontoLink.contains(e.target);

    if (!clickedInsideAnyPopup && !clickedKontoLink) {
        hideAllPopups();
    }
});

kontoLink.addEventListener('click', (e) => {
    e.stopPropagation();

    if (!isLoggedIn) {
        hideAllPopups();
        document.getElementById('login-popup').classList.remove('hidden');
    }
});

showRegisterPopupSpan.addEventListener('click', () => {
    hideAllPopups();
    document.getElementById('register-popup').classList.remove('hidden');
});

showLoginPopupSpan.addEventListener('click', () => {
    hideAllPopups();
    document.getElementById('login-popup').classList.remove('hidden');
});