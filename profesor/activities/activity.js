function goDasboard(){
    window.location.href = '../main/index.php';
}

function goStudents() {
    window.location.href = '../alumnos/alumnos.php';
}

function goCursos(){
    window.location.href = '../cursos/cursos.php';
}

function goSettings(){
    window.location.href = '../settings/settings.php';
}

let popUp = document.getElementById('popUp');
let show_popup = document.getElementById('addbtn');
let close_popup = document.getElementById('close_popup');

console.log (popUp);
console.log (show_popup);
console.log (close_popup);


show_popup.addEventListener('click', () => {
    popUp.style.display = 'flex';
    console.log ("HOLA");
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