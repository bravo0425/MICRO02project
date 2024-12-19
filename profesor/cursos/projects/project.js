function goStudents() {
    window.location.href = '../../alumnos/alumnos.php';
}

function goDasboard(){
    window.location.href = '../../main/main.php';
}

function goCursos(){
    window.location.href = '../cursos.php';
}

function addActivity(){
    document.querySelector("#insertarActividad").style = "display: flex;";
    document.querySelector("#tabla").style = "display: none;";
}
