function goStudents() {
    window.location.href = '../alumnos/alumnos.php';
}

function goDasboard(){
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

function addActivity(){
    document.querySelector("#insertarActividad").style = "display: flex;";
    document.querySelector("#verTabla").style = "display: none;";
}

function abrirEditorProject(){
    document.querySelector("#editarProyecto").style = "display: flex;";
    document.querySelector("#insertarActividad").style = "display: none;";
    document.querySelector("#verTabla").style = "display: none;";
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