<?php
include '../conexion.php';

$id = $_REQUEST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Comprobar si se subió una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Si hay una nueva imagen, actualizarla en GitHub primero
    include '../../token.php'; // Incluir el archivo de configuración con el token
    $githubUsername = 'Juan-Grimaldo';
    $repoName = 'libreria';
    $branchName = 'main';
    $token = GITHUB_TOKEN;

    $imagen = $_FILES['imagen'];
    $fileName = basename($imagen['name']);
    $filePath = $imagen['tmp_name'];

    // Leer el contenido del archivo
    $content = base64_encode(file_get_contents($filePath));

    // Datos de la solicitud
    $data = json_encode([
        'message' => 'Actualizar imagen ' . $fileName,
        'content' => $content,
        'branch' => $branchName
    ]);

    // URL de la API de GitHub
    $url = "https://api.github.com/repos/$githubUsername/$repoName/contents/imagenes-user/$fileName";

    // Inicializar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'User-Agent: PHP Script'
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtener el código HTTP de respuesta
    if (curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
    }
    curl_close($ch);

    // Verificar la respuesta
    $responseData = json_decode($response, true);
    if ($httpcode == 201 && isset($responseData['content']['download_url'])) {
        // Si la imagen se cargó correctamente, obtener la URL de descarga
        $githubUrl = $responseData['content']['download_url'];

        // Actualizar los datos en la base de datos incluyendo la nueva imagen
        $query = "UPDATE usuario SET imagen='$githubUrl', name='$name', email='$email', password='$password' WHERE id = '$id'";
    } else {
        // Mostrar respuesta de la API de GitHub para diagnosticar el error
        echo "Error al subir la imagen a GitHub. Código HTTP: $httpcode. Respuesta: " . htmlentities($response);
        exit; // Terminar el script en caso de error
    }
} else {
    // Si no se subió una nueva imagen, actualizar solo los demás datos en la base de datos
    $query = "UPDATE usuario SET name='$name', email='$email', password='$password' WHERE id = '$id'";
}

// Ejecutar la consulta de actualización
$resultado = $conn->query($query);

if ($resultado) {
    echo "<script>
            window.alert('¡Registro ACTUALIZADO correctamente!😁');
            window.location.href = '../index_admin.php';
          </script>";
} else {
    echo "<script>
            window.alert('¡Ups, ha ocurrido un error al actualizar en la base de datos!😕');
            window.location.href = '../index_admin.php';
          </script>";
}

$conn->close();
?>
