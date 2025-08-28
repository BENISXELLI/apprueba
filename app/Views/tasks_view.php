<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Tareas</title>
<style>
body { font-family: Arial; margin:20px; }
ul { list-style:none; padding:0; }
li { padding:8px; margin:4px 0; background:#f0f0f0; display:flex; }
input[type="text"] { flex:1; padding:4px; }
button { margin-left:10px; }
</style>
</head>
<body>
<h1>Lista de Tareas</h1>
<form id="taskForm">
<input type="text" id="taskTitle" placeholder="Nueva tarea" required>
<button type="submit">Agregar</button>
</form>
<ul id="taskList"></ul>

<script>
const API_URL = 'http://localhost:8080/tasks';

async function fetchTasks() {
    try {
        const res = await fetch(API_URL);
        if(!res.ok) throw new Error(res.status);
        const tasks = await res.json();
        if(!Array.isArray(tasks)) throw new Error('Se esperaba un array');

        const list = document.getElementById('taskList');
        list.innerHTML='';
        tasks.forEach(task=>{
            list.innerHTML+=`
                 <li>
                    
                    <input type="text" value="${task.title}" readonly="readonly">
                    <button onclick="updateTask(${task.id}, '${task.title}')">Actualizar</button>
                    <button onclick="deleteTask(${task.id}, '${task.title}')">Eliminar</button>
                </li>`;
            });
    } catch(err) { console.error('Error al obtener tareas:', err); }
}

async function createTask(title){
    try{
        const res = await fetch(API_URL,{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({title})
        });
        if(!res.ok) throw new Error(res.status);
        fetchTasks();
    } catch(err){ console.error('Error al crear tarea:', err); }
}

async function updateTask(id, currentTitle) {
    const newTitle = prompt('Se actualizara la tarea "'+currentTitle+'" \nIngrese la nueva tarea para actualizar.');
    if (newTitle === null || newTitle.trim() === "") return;

    try {
        const res = await fetch(`${API_URL}/${id}`, {
            method: 'PUT',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ title: newTitle })
        });
        if (!res.ok) throw new Error(res.status);
        alert("Tarea actualizada correctamente.");
        fetchTasks();
    } catch (err) {
        console.error('Error al actualizar tarea:', err);
    }
}



async function deleteTask(id, currentTitle){
     if (!confirm('Se eliminará la tarea "'+currentTitle+'" \n¿Estás seguro de eliminar esta tarea?')) {
        return; // Si el usuario cancela, no hace nada
    }
    try{
        const res = await fetch(`${API_URL}/${id}`,{method:'DELETE'});
        if(!res.ok) throw new Error(res.status);
        fetchTasks();
    } catch(err){ console.error('Error al eliminar tarea:', err); }
}

document.getElementById('taskForm').addEventListener('submit',e=>{
    e.preventDefault();
    const title=document.getElementById('taskTitle').value.trim();
    if(title)
    {
        createTask(title);
    }
    e.target.reset();
});

fetchTasks();
</script>
</body>
</html>