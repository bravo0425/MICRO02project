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

function addActivity(){
    document.querySelector("#insertarActividad").style = "display: flex;";
    document.querySelector("#tabla").style = "display: none;";
}
