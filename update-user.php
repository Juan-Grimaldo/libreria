<?php
include 'conexion.php';
session_start();

// Verificar si las claves están definidas en $_POST
$id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : (isset($_REQUEST['id']) ? $_REQUEST['id'] : null);
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (!$id || !$name || !$email || !$password) {
    echo "<script>
            window.alert('Datos incompletos. Por favor, verifica los campos.');
            window.location.href = 'account.php';
          </script>";
    exit;
}
$hashedPassword = hash('sha512', $password);

// Verificar la contraseña
$query = "SELECT password FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$row = $resultado->fetch_assoc();

if ($hashedPassword !== $row['password']) {
    echo "<script>
            window.alert('Contraseña incorrecta. Por favor, intenta de nuevo.');
            window.location.href = 'account.php';
          </script>";
    exit;
}

// Comprobar si se subió una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Si hay una nueva imagen, actualizarla en GitHub primero
    include 'token.php'; // Incluir el archivo de configuración con el token
    $githubUsername = 'Juan-Grimaldo';
    $repoName = 'libreria';
    $branchName = 'main';
    $token = GITHUB_TOKEN;

    $imagen = $_FILES['imagen'];
    $fileName = basename($imagen['name']);
    $filePath = $imagen['tmp_name'];

    // Leer el contenido del archivo
    $content = base64_encode(file_get_contents($filePath));

    // URL de la API de GitHub para obtener el SHA del archivo existente
    $url = "https://api.github.com/repos/$githubUsername/$repoName/contents/imagenes-user/$fileName";

    // Inicializar cURL para obtener el SHA
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'User-Agent: PHP Script'
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $sha = null;
    if ($httpcode == 200) {
        $responseData = json_decode($response, true);
        $sha = $responseData['sha'];
    }

    // Datos de la solicitud
    $data = [
        'message' => 'Actualizar imagen ' . $fileName,
        'content' => $content,
        'branch' => $branchName
    ];

    if ($sha) {
        $data['sha'] = $sha;
    }

    $dataString = json_encode($data);

    // Inicializar cURL para subir/actualizar el archivo
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'User-Agent: PHP Script'
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
    }
    curl_close($ch);

    // Verificar la respuesta
    $responseData = json_decode($response, true);
    if (($httpcode == 201 || $httpcode == 200) && isset($responseData['content']['download_url'])) {
        // Si la imagen se cargó correctamente, obtener la URL de descarga
        $githubUrl = $responseData['content']['download_url'];

        // Actualizar los datos en la base de datos incluyendo la nueva imagen
        $query = "UPDATE usuario SET imagen='$githubUrl', name='$name', email='$email' WHERE id = '$id'";
    } else {
        // Mostrar respuesta de la API de GitHub para diagnosticar el error
        echo "Error al subir la imagen a GitHub. Código HTTP: $httpcode. Respuesta: " . htmlentities($response);
        exit; // Terminar el script en caso de error
    }
} else {
    // Si no se subió una nueva imagen, actualizar solo los demás datos en la base de datos
    $query = "UPDATE usuario SET name='$name', email='$email' WHERE id = '$id'";
}

// Ejecutar la consulta de actualización
$resultado = $conn->query($query);

if ($resultado) {
    echo "<script>
            window.alert('¡Registro ACTUALIZADO correctamente!😁');
            window.location.href = 'account.php';
          </script>";
} else {
    echo "<script>
            window.alert('¡Ups, ha ocurrido un error al actualizar en la base de datos!😕');
            window.location.href = 'account.php';
          </script>";
}

$conn->close();
?>