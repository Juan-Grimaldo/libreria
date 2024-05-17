<!DOCTYPE html>
<html lang="en">

<?php
require_once './user/validate_sesion1.php';
$conn = new mysqli("localhost", "root", "", "libreria");
$id = $_REQUEST['id'];
$query = "SELECT * FROM usuario WHERE id='$id'";
$sql = "SELECT imagen FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$result = $conn->query($sql);
$row = $resultado->fetch_assoc();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NubeLiteraria</title>
    <link rel="stylesheet" href="./estilos/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Coming+Soon&family=Lobster&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./estilos/stylemain.css">
    <link rel="stylesheet" href="./estilos/style2.css">
</head>

<body class="btn-menu-hidden">
    <div class="header-ini">
        <p>¡Bienvenido a NubeLiteraria!</p>
    </div>
    <header class="header">
        <div class="sec1">
            <a href="index.php">
                <img class="mercado" src="./imagen/libreria.png" alt="Imagen de libro" class="logo">
            </a>
            <div class="btn-menu">
                <button id="btn-menu" class="btn-menu-hidden">
                    <label for="btn-menu" class="icon-menu2 icono">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2 menu-toggle-icon" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 6l16 0" />
                            <path d="M4 12l16 0" />
                            <path d="M4 18l16 0" />
                        </svg>
                    </label>
                </button>
                <a href="index.php" class="icono icon">
                    <img class="mercado" src="./imagen/libreria.png" alt="Menú" class="icono-menu">
                </a>
            </div>
            <a href="index.php">Inicio</a>
            <a href="Productos.php">Libreria</a>
            <div class="dropdown">
                <div class="flex-genero">
                    <a href="genero.php">Generos</a>
                </div>
            </div>
            <a href="#">Contacto</a>
        </div>
        <div class="sec2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
            </a>
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-bag" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
                    <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
                </svg>
            </a>
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
            </a>
        </div>
    </header>
    <main>
        <div id="dark-overlay" class="btn-menu-hidden">
            <div id="container-menu" class="btn-menu-hidden">
                <div class="cont-menu">
                    <nav>
                        <a href="index.php">Inicio</a>
                        <a href="Productos.php">Libreria</a>
                        <a href="genero.php">Géneros</a>
                        <a href="#">Contacto</a>
                    </nav>
                    <label for="" class="icon-equis"></label>
                </div>
                <div class="usuario">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        <p>Iniciar Sesión</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- INICIO ACCOUNT -->
        <main>
            <hr>
            <div class="product-details">
                <div class="left-column">
                    <?php
                    if (!empty($row['imagen'])) {
                    ?> <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Imagen de usuario" style="width: 350px; height: auto;"> <?php
                                                                                                                                                                } else {
                                                                                                                                                                    ?> <img src="https://cdn-icons-png.freepik.com/512/1077/1077063.png" alt="Imagen de usuario"> <?php
                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                    ?>
                </div>
                <div class="right-column">
                    <h3 class="tittle">Datos del usuario</h3>

                    <h3>Nombre de usuario</h3>
                    <p><?php echo $row['name'] ?></p>

                    <h3>Email / Correo</h3>
                    <p><?php echo $row['email'] ?></p><br>
                    <a href="update_user.php?id=<?php echo $id ?>"><button style="background-color:black">Actualizar información</button></a>
                    <a href="./user/logout1.php"><button style="background-color:black">Cerrar sesión</button></a><br><br>
                    <a href=""><button style="background-color:#EA4F4F">Eliminar cuenta</button></a>
                </div>
            </div>
        </main>
        <?php include 'footer.php' ?>
</html>