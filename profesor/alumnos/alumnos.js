
function mostrarFormularioA() {
    document.querySelector("#listaAlumnos").style = "display: none;";
    document.querySelector("#crearAlumno").style = "display: flex;";
}

function mostrarTabla() {
    document.querySelector("#listaAlumnos").style = "display: flex;";
    document.querySelector("#crearAlumno").style = "display: none;";
    document.querySelector("#modificarAl").style = "display: none;";
}


function goDasboard() {
    window.location.href = '../main/main.php';
}

function goCursos(){
    window.location.href = '../cursos/cursos.php';
}