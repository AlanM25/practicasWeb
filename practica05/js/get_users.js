const makeAdmin = async (id) => {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch(`http://${PHP_SERVER}/make_admin.php`, {
      method: "POST",
      body: formData,
    });
    const finalRespponse = await response.json();

    Swal.fire({
      title: finalRespponse.status,
      text: finalRespponse.message,
      icon: finalRespponse.status,
    }).then(() => {
      location.reload();
    });
  } catch (e) {
    console.log(e);
  }
};

const makeUser = async (id) => {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch(`http://${PHP_SERVER}/make_user.php`, {
      method: "POST",
      body: formData,
    });
    const finalRespponse = await response.json();

    Swal.fire({
      title: finalRespponse.status,
      text: finalRespponse.message,
      icon: finalRespponse.status,
    }).then(() => {
      location.reload();
    });
  } catch (e) {
    console.log(e);
  }
};

const setDefaultPassword = async (id) => {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch(`http://${PHP_SERVER}/set_default_password.php`, {
      method: "POST",
      body: formData,
    });
    const finalRespponse = await response.json();

    Swal.fire({
      title: finalRespponse.status,
      text: finalRespponse.message,
      icon: finalRespponse.status,
    }).then(() => {
      location.reload();
    });
  } catch (e) {
    console.log(e);
  }
};

const deleteUser = async (id) => {
  const formData = new FormData();
  formData.append("id", id);

  try {
    const response = await fetch(`http://${PHP_SERVER}/delete_user.php`, {
      method: "POST",
      body: formData,
    });
    const finalRespponse = await response.json();

    Swal.fire({
      title: finalRespponse.status,
      text: finalRespponse.message,
      icon: finalRespponse.status,
    }).then(() => {
      location.reload();
    });
  } catch (e) {
    console.log(e);
  }
};

let usersData = []; // Variable para almacenar todos los usuarios

const getUsers = async () => {
  try {
    const response = await fetch(`http://${PHP_SERVER}/ajax/get_users.php`);
    const users = await response.json();
    usersData = users; // Guardar los usuarios en la variable global
    renderUsers(usersData);
  } catch (error) {
    console.error("Error al recuperar usuarios", error);
    return null;
  }
};

const renderUsers = (users) => {
  const tableBody = document
    .getElementById("users-table")
    .getElementsByTagName("tbody")[0];
  tableBody.innerHTML = "";

  users.forEach((user) => {
    const row = tableBody.insertRow();
    const username = row.insertCell(0);
    const firstName = row.insertCell(1);
    const lastName = row.insertCell(2);
    const genre = row.insertCell(3);
    const bornDate = row.insertCell(4);
    const action = row.insertCell(5);

    username.textContent = user.username;
    firstName.textContent = user.nombre;
    lastName.textContent = user.apellidos;
    genre.textContent = user.genero;
    bornDate.textContent = user.fecha_nacimiento;

    const userId = user.id;

    const actionBtn = document.createElement("button");

    if (user.es_admin) {
      actionBtn.textContent = "convertir a usuario";
      actionBtn.addEventListener("click", () => {
        makeUser(userId);
      });
    }

    if (!user.es_admin) {
      actionBtn.textContent = "convertir a admin";
      actionBtn.addEventListener("click", () => {
        makeAdmin(userId);
      });
    }

    action.appendChild(actionBtn);

    const defaultPasswordBtn = document.createElement("button");
    defaultPasswordBtn.textContent = "set default pass";
    defaultPasswordBtn.addEventListener("click", () => {
      setDefaultPassword(userId);
    });

    const deleteUserBtn = document.createElement("button");
    deleteUserBtn.textContent = "eliminar usuario";
    deleteUserBtn.addEventListener("click", () => {
      deleteUser(userId);
    });

    action.appendChild(defaultPasswordBtn);
    action.appendChild(deleteUserBtn);
  });
};

// Función para filtrar usuarios según el valor del campo de búsqueda
const filterUsers = () => {
  const searchQuery = document.getElementById("search-input").value.toLowerCase();
  const filteredUsers = usersData.filter((user) =>
    user.username.toLowerCase().includes(searchQuery) ||
    user.nombre.toLowerCase().includes(searchQuery) ||
    user.apellidos.toLowerCase().includes(searchQuery)
  );
  renderUsers(filteredUsers);
};

document.getElementById("search-input").addEventListener("input", filterUsers);

getUsers();
