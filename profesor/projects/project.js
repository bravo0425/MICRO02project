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
    document.querySelector("#verTabla").style = "display: none;";
}

function abrirEditorProject(){
    document.querySelector("#editarProyecto").style = "display: flex;";
    document.querySelector("#insertarActividad").style = "display: none;";
    document.querySelector("#verTabla").style = "display: none;";
}