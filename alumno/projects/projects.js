function goDasboard() {
    window.location.href = '../main/main.php';
}

function goTasks() {
    window.location.href = '../tasks/tasks.php';
}

function goProjects() {
    window.location.href = 'projects.php';
}

function goChat() {
    window.location.href = '../chat/chat.php';
}

function goSettings() {
    window.location.href = '../settings/settings.php';
}


const botonesToggle = document.querySelectorAll('.abrirProyecto');

for (let i = 0; i < botonesToggle.length; i++) {
    botonesToggle[i].addEventListener('click', function() {
        const actividades = this.nextElementSibling;
        if (actividades.classList.contains('hidden')) {
            actividades.classList.remove('hidden');
        } else {
            actividades.classList.add('hidden');
        }
    });
}

