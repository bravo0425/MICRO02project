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



document.getElementById('añadirItemF').addEventListener('submit', function(event) {
    let totalPercentage = 0;
    
    // Obtener los porcentajes de los ítems existentes
    let items = document.querySelectorAll('input[name="valor[]"]');
    items.forEach(function(item) {
        totalPercentage += parseInt(item.value);
    });

    // Obtener el valor del nuevo ítem
    let newItemValue = document.getElementById('valorNewItem').value;

    // Validar si la suma de los porcentajes supera 100
    if ((totalPercentage + parseInt(newItemValue)) > 100) {
        alert("El total de los porcentajes excede el 100%. No se puede agregar el ítem.");
        event.preventDefault(); // Evita el envío del formulario
    }
});