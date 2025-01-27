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

function goChat(){
    window.location.href = '../chat/chat.php';
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