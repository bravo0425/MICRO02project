function goDasboard(){
    window.location.href = 'index.php';
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

Highcharts.chart('grafica', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Notas de los Alumnos'
    },
    xAxis: {
        categories: alumnos,
        title: {
            text: 'Alumnos'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Notas'
        }
    },
    series: [{
        name: 'Nota',
        data: notas.map(Number) // Asegurarse de que los datos sean numéricos
    }]
});