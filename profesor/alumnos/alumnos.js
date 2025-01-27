
function goDasboard() {
    window.location.href = '../main/index.php';
}

function goCursos(){
    window.location.href = '../cursos/cursos.php';
}

function goSettings(){
    window.location.href = '../settings/settings.php';
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
