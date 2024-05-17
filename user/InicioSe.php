<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/style1.css">
    <script src="https://kit.fontawesome.com/dd0247d67c.js" crossorigin="anonymous"></script>
    <title>eBook</title>
</head>

<body>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>¡Bienvenido!</h2>
                <p>Si ya estas registrado, entra aquí</p>
                <input type="button" value="Iniciar Sesion" id="sign-in">
                <p>¿o eres un colaborador? ingresa aquí</p>
                <input type="button" value="Colaborador" id="admin">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una cuenta</h2>
                <p>¡Unete a nosotros, registrando tus datos aquí!</p>
                <form action="u ser/singup.php" method="post" class="form" autocomplete="off">
                    <label>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" id="nombre" placeholder="Nombre" required>
                    </label>
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Correo Electronico" required>
                    </label>
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    </label>
                    <input type="submit" value="Registrarse">
                </form>
            </div>
        </div>
    </div>

    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡Bienvenido!</h2>
                <p>¿Aún no tienes una cuenta?, entra aquí</p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Inciar sesión</h2>
                <p>¡Ingresa tus datos aquí!</p>
                <form action="user/login.php" class="form" method="post" autocomplete="off">
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="" placeholder="Correo Electronico" required>
                    </label>
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="" placeholder="Contraseña" required>
                    </label>
                    <input type="submit" value="Iniciar sesión">
                </form>
            </div>
        </div>
    </div>

    <div class="container-form loginadmin hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡Bienvenido!</h2>
                <p>Si no eres colaborador, inicia como invitado</p>
                <input type="button" value="Volver" id="volver">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Inciar sesión como colaborador</h2>
                <p>¡Ingresa tus datos aquí!</p>
                <form action="admin/login_admin.php" class="form" method="post" autocomplete="off">
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Correo Electronico" required>
                    </label>
                    <label>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    </label>
                    <input type="submit" value="Iniciar sesión">
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>