<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';
include 'conexion.php';

// Validar que haya una sesión activa
if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
    echo "<script>window.alert('¡Ou, debes iniciar sesión primero!😴');
          window.location.href = 'form.php';</script>";
    exit;
}

// Consultas para traer información del usuario
$id = $_REQUEST['id'];
$query = "SELECT * FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$row = $resultado->fetch_assoc();
$correo = $row['email'];
?>

<head>
    <link rel="stylesheet" href="./estilos/style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd0247d67c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .imagen {
            width: min-content;
            height: 200px;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        label {
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 2;
        }

        input {
            margin-top: 20px;
            margin-bottom: 2;
        }

        .form-control {
            font-size: 2rem;
        }

        .flex-btn {
            display: flex;
            justify-content: space-evenly;
        }

        .btn {
            font-size: 2rem;
        }

        .mt-4 {
            margin-bottom: 4rem;
        }

        h2 {
            color: black;
            font-size: 3.5rem;
            text-align: center;
        }

        .btn-rojo {
            margin-top: 2rem;
            --bs-btn-color: #fff;
            --bs-btn-bg: red;
            --bs-btn-border-color: red;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: red;
            --bs-btn-hover-border-color: red;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: red;
            --bs-btn-active-border-color: red;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: red;
            --bs-btn-disabled-border-color: red;
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <hr>
    <main>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h2>Actualizar datos</h2>
                            <hr>
                            <!-- Formulario de actualización en la página principal -->
                            <form id="updateForm" action="update-user.php?id=<?php echo urlencode($row['id']); ?>" method="POST"
                                class="formregistro" autocomplete="off" enctype="multipart/form-data">
                                <label for="formFile" class="form-label">Imagen:</label>
                                <img height="100px" class="imagen" src="<?php echo htmlspecialchars($row['imagen']); ?>"
                                    alt="Descripción de la imagen">
                                <input class="form-control" type="file" id="imagen" name="imagen">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="flex-btn">
                                    <input type="submit" class="btn btn-primary" value="Actualizar" id="update"
                                        name="update">
                                    <button type="button" class="btn btn-rojo" id="deleteBtn">Eliminar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal para ingresar la contraseña -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Confirmar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="password-container">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Ingresa tu contraseña" required>
                        <i class="fa fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmPasswordBtn">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        // Mostrar modal de confirmación de contraseña
        document.getElementById('deleteBtn').addEventListener('click', function () {
            var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        });

        // Alternar visibilidad de la contraseña
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordInput = document.getElementById('confirmPassword');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // Confirmar la eliminación de la cuenta
        document.getElementById('confirmPasswordBtn').addEventListener('click', function () {
            var confirmPassword = document.getElementById('confirmPassword').value;
            if (confirmPassword) {
                // Crear un formulario y enviarlo
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'delete-user.php';

                var inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = "<?php echo htmlspecialchars($row['id']); ?>";
                form.appendChild(inputId);

                var inputPassword = document.createElement('input');
                inputPassword.type = 'hidden';
                inputPassword.name = 'password';
                inputPassword.value = confirmPassword;
                form.appendChild(inputPassword);

                document.body.appendChild(form);
                form.submit();
            } else {
                alert('Por favor, ingresa tu contraseña.');
            }
        });
    </script>
</body>
<script src="./scriptmain.js"></script>;
<?php include 'footer.php' ?>
</html>