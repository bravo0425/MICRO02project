function goDasboard() {
    window.location.href = '../main/main.php';
}

function goTasks() {
    window.location.href = 'tasks.php';
}

function goProjects() {
    window.location.href = '../projects/projects.php';
}

function goChat() {
    window.location.href = '../chat/chat.php';
}

function goSettings() {
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
