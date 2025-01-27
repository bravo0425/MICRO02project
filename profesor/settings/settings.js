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
    window.location.href = 'settings.php';
}

function showSection(sectionClass, clickedButton) {
    const settingsContainer = document.querySelector('#abajo');

    const sections = settingsContainer.querySelectorAll('section');
    sections.forEach(section => section.style.display = 'none');

    const sectionToShow = settingsContainer.querySelector(`.${sectionClass}`);
    sectionToShow.style.display = 'flex';

    const buttons = settingsContainer.querySelectorAll('.navSettings button');
    buttons.forEach(button => button.classList.remove('activeN'));

    clickedButton.classList.add('activeN');
}

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