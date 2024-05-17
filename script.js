const btnSingIn = document.getElementById("sign-in"),
      btnSingUp = document.getElementById("sign-up"),
      btnAdmin = document.getElementById("admin"),
      btnVolver = document.getElementById("volver"),
      formRegister = document.querySelector(".register"),
      formLogin = document.querySelector(".login"),
      formAdmin = document.querySelector(".loginadmin");

btnSingIn.addEventListener("click", e =>{
    formRegister.classList.add("hide")
    formLogin.classList.remove("hide")
})

btnSingUp.addEventListener("click", e =>{
    formLogin.classList.add("hide")
    formRegister.classList.remove("hide")
})

btnAdmin.addEventListener("click", e =>{
    formLogin.classList.add("hide")
    formRegister.classList.add("hide")
    formAdmin.classList.remove("hide")
})

btnVolver.addEventListener("click", e =>{
    formAdmin.classList.add("hide")
    formRegister.classList.remove("hide")
})

