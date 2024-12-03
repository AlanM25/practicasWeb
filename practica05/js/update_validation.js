const registerForm = document.getElementById("register-form")

const updateDAta = async (
  username,
  currentPassword,
  password,
  confirmPassword,
  firstName,
  lastName,
  genre,
  bornDate
) => {
  console.log("ente a la función")

  const formData = new FormData()

  formData.append("username", username)
  formData.append("currentPassword", currentPassword)
  formData.append("password", password)
  formData.append("confirmPassword", confirmPassword)
  formData.append("firstName", firstName)
  formData.append("lastName", lastName)
  formData.append("genre", genre)
  formData.append("bornDate", bornDate)
  console.log(formData)

  try {
    const response = await fetch(
      `http://${PHP_SERVER}/uploads/update-user-data.php`,
      {
        method: "POST",
        body: formData,
      }
    )
    const finalRespponse = await response.json()
    console.log(finalRespponse)

    if (finalRespponse.status === "error") {
      Swal.fire({
        title: "Error",
        text: finalRespponse.message,
        icon: "error",
      })
      return
    }

    Swal.fire({
      title: "Success",
      text: "Data updated successfully",
      icon: "success",
    })

    window.location.replace(`http://${PHP_SERVER}/logout.php`);
  } catch (e) {
    console.log(e)
  }
}

registerForm.addEventListener("submit", (e) => {
  e.preventDefault()

  const usernameInput = document.getElementById("username-input")
  const currentPasswordInput = document.getElementById("current-password-input")
  const passwordInput = document.getElementById("password-input")
  const confirmPasswordInput = document.getElementById("confirm-password-input")
  const firstNameInput = document.getElementById("first-name-input")
  const lastNameInput = document.getElementById("last-name-input")
  const genreInput = document.getElementById("genre-input")
  const bornDateInput = document.getElementById("born-date-input")

  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/
  const usernameRegex = /^[a-z_]+$/;

  let username = usernameInput.value
  let password = passwordInput.value
  let currentPassword = currentPasswordInput.value
  let confirmPassword = confirmPasswordInput.value
  let firstName = firstNameInput.value
  let lastName = lastNameInput.value
  let genre = genreInput.value
  let bornDate = bornDateInput.value
  
  if (
    username == "" ||
    currentPassword == "" ||
    password == "" ||
    confirmPassword == "" ||
    firstName == "" ||
    genre == "" ||
    bornDate == ""
  ) {
    Swal.fire({
      title: "Error",
      text: "You have to fill all the required inputs",
      icon: "error",
    })
    return
  }

  if (!usernameRegex.test(username)) {
    Swal.fire({
        title: "Error",
        text: "The username must only contain lowercase letters and underscores.",
        icon: "error",
    });
  }
  if (genre === "") {
    Swal.fire({
        title: "Error",
        text: "Por favor, seleccione un género.",
        icon: "error",
    });
    return;
}


  if (!passwordRegex.test(password)) {
    Swal.fire({
      title: "Error",
      text: "The password does not have the requirements",
      icon: "error",
    })
    return
  }

  if (password != confirmPassword) {
    Swal.fire({
      title: "Error",
      text: "Passwords doesn't match",
      icon: "error",
    })
    return
  }

  updateDAta(
    username,
    currentPassword,
    password,
    confirmPassword,
    firstName,
    lastName,
    genre,
    bornDate
  )
})
