<?php
// Incluir el archivo de configuración
include 'config.php';

// Datos del repositorio de GitHub
$githubUsername = 'Juan-Grimaldo';
$repoName = 'libreria';
$branchName = 'main';
$token = GITHUB_TOKEN;

// Ruta al directorio donde se almacenarán las imágenes temporalmente
$uploadDir = 'uploads/';

// Verifica si el directorio de subidas existe, si no, lo crea
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Verifica si se ha enviado un archivo
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Mueve el archivo al directorio de subidas temporal
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Contenido del archivo en base64
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
        curl_close($ch);

        // Verifica la respuesta
        $responseData = json_decode($response, true);
        if (isset($responseData['content']['download_url'])) {
            $githubUrl = $responseData['content']['download_url'];

            // Conexión a la base de datos
            $conn = new mysqli("localhost", "root", "", "libreria");

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Insertar la URL de la imagen en la base de datos
            $sql = "INSERT INTO libro (titulo, imagen_url) VALUES ('Imagen Subida', '$githubUrl')";

            if ($conn->query($sql) === TRUE) {
                echo "La imagen se ha subido a GitHub y la URL se ha guardado en la base de datos.<br>";
                echo "URL de la imagen: <a href='$githubUrl'>$githubUrl</a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Hubo un error al subir la imagen a GitHub.";
        }

        // Elimina el archivo temporal
        unlink($filePath);
    } else {
        echo "Hubo un error al mover la imagen.";
    }
}
?>