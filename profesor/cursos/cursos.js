function goStudents() {
    window.location.href = '../alumnos/alumnos.php';
}

function goDasboard(){
    window.location.href = '../main/main.php';
}

function irProject(idProject){
    console.log("ID del proyecto:", idProject);
    window.location.href = 'projects/project.php?id=' + idProject;
}