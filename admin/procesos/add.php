<?php
include '../../conexion.php';
include '../../token.php'; // Incluir el archivo de configuración

$githubUsername = 'Juan-Grimaldo';
$repoName = 'libreria';
$branchName = 'main';
$token = GITHUB_TOKEN;

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$genero = $_POST['genero'];
$sinopsis = $_POST['sinopsis'];
$precio = $_POST['precio'];

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen = $_FILES['imagen'];
    $fileName = basename($imagen['name']);
    $filePath = $imagen['tmp_name'];

    // Leer el contenido del archivo
    $content = base64_encode(file_get_contents($filePath));

    // Datos de la solicitud
    $data = json_encode([
        'message' => 'Agregar imagen ' . $fileName,
        'content' => $content,
        'branch' => $branchName
    ]);

    // URL de la API de GitHub
    $url = "https://api.github.com/repos/$githubUsername/$repoName/contents/imagenes-libros/$fileName";

    // Inicializa cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $token,
        'User-Agent: PHP Script'
    ]);

    // Ejecuta la solicitud
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtener el código HTTP de respuesta
    if(curl_errno($ch)) {
        echo 'Error en cURL: ' . curl_error($ch);
    }
    curl_close($ch);

    // Verifica la respuesta
    $responseData = json_decode($response, true);
    if ($httpcode == 201 && isset($responseData['content']['download_url'])) {
        $githubUrl = $responseData['content']['download_url'];

        // Inserta la URL de la imagen en la base de datos junto con los demás datos
        $query = "INSERT INTO libro (imagen_url, titulo, autor, genero, sinopsis, precio) VALUES ('$githubUrl', '$titulo', '$autor', '$genero', '$sinopsis', '$precio')";
        $resultado = $conn->query($query);

        if ($resultado) {
            echo "<script>
                    window.alert('¡Registro AGREGADO correctamente!😁');
                    window.location.href = '../index_admin.php';
                  </script>";
        } else {
            echo "<script>
                    window.alert('¡Ups, ha ocurrido un error al guardar en la base de datos!😕');
                    window.location.href = '../index_admin.php';
                  </script>";
        }
    } else {
        // Mostrar respuesta de la API de GitHub para diagnosticar el error
        echo "Error al subir la imagen a GitHub. Código HTTP: $httpcode. Respuesta: " . htmlentities($response);
    }
} else {
    echo "<script>
            window.alert('¡Ups, ha ocurrido un error con la imagen subida!😕');
            window.location.href = '../index_admin.php';
          </script>";
}
?>