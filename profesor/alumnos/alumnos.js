
function goDasboard() {
    window.location.href = '../main/index.php';
}

function goCursos(){
    window.location.href = '../cursos/cursos.php';
}

function goSettings(){
    window.location.href = '../settings/settings.php';
}

function goChat(){
    window.location.href = '../chat/chat.php';
}

let popUp = document.getElementById('popup');
let show_popup = document.getElementById('show_popup');
let close_popup = document.getElementById('close_popup');

show_popup.addEventListener('click', () => {
    popUp.style.display = 'flex';
});

close_popup.addEventListener('click', () => {
    popUp.style.display = 'none';
});


const popupOverlay = document.querySelector('.error-pop');
const popupCloseButton = document.querySelector('.popup-close');

// Mostrar el pop-up
if (popupOverlay) {
    popupOverlay.style.display = 'flex';
}

// Cerrar el pop-up
if (popupCloseButton) {
    popupCloseButton.addEventListener('click', function() {
        popupOverlay.style.display = 'none';
    });
}


const popupSucces = document.querySelector('.succes-pop');
const popupCloseSucces = document.querySelector('.close-Succes');

// Mostrar el pop-up
if (popupSucces) {
    popupSucces.style.display = 'flex';
}

// Cerrar el pop-up
if (popupCloseSucces) {
    popupCloseSucces.addEventListener('click', function() {
        popupSucces.style.display = 'none';
    });
}