const kontoLink = document.getElementById('konto-link');

const showRegisterPopupSpan = document.getElementById('show-register-popup-span');
const showLoginPopupSpan = document.getElementById('show-login-popup-span');

const loginPopup = document.getElementById('login-popup');
const registerPopup = document.getElementById('register-popup');

kontoLink.addEventListener('click', (e) => {
    e.stopPropagation();

    if (!isLoggedIn) {
        loginPopup.classList.remove('hidden');
    }
});

document.addEventListener('click', (e) => {
    const clickedInsideLogin = loginPopup.contains(e.target);
    const clickedInsideRegister = registerPopup.contains(e.target);
    const clickedKontoLink = kontoLink.contains(e.target);

    if (!clickedInsideLogin && !clickedInsideRegister && !clickedKontoLink) {
        loginPopup.classList.add('hidden');
        registerPopup.classList.add('hidden');
    }
});

showRegisterPopupSpan.addEventListener('click', () => {
    registerPopup.classList.remove('hidden');
    loginPopup.classList.add('hidden');
});

showLoginPopupSpan.addEventListener('click', () => {
    registerPopup.classList.add('hidden');
    loginPopup.classList.remove('hidden');
});