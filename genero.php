<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<head>
    <style>
        .product-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-related {
            width: 95%;
            padding: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        label {
            padding: 5px;
            font-weight: bold;
            margin-top: 7px;
        }

        .tittle {
            font-size: 40px;
            margin: 0;
        }
    </style>
</head>
<hr>
<div class="product-details">
    <div class="product-related">
        <label for="genero" style="font-family: 'Arial', sans-serif; font-size: 16px; color: #333; margin-bottom: 8px;">Selecciona un género: </label>
        <select id="genero" onchange="buscarLibros()" style="padding: 8px; font-family: 'Arial', sans-serif; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            <option value="" disabled selected hidden>Selecciona una opción</option>
            <option value="Ficción">📘 Ficción</option>
            <option value="No ficción">📚 No Ficción</option>
            <option value="Ciencia ficción">🚀 Ciencia Ficción</option>
            <option value="Drama">🎭 Drama</option>
            <option value="Romance">💖 Romance</option>
        </select>
    </div>
</div>
<div id="resultado"></div>

<script>
    // Llamar a esta función cuando se cargue la página inicialmente
    window.onload = function() {
        buscarLibros();
    };

    function buscarLibros() {
        var generoSeleccionado = document.getElementById("genero").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultado").innerHTML = this.responseText;
            }
        };

        // Si no se selecciona ningún género, cargar todos los libros
        if (generoSeleccionado === "") {
            xmlhttp.open("GET", "buscar_libros.php", true);
            xmlhttp.send();
        } else {
            // Si se selecciona un género, cargar libros filtrados por género
            xmlhttp.open("GET", "buscar_libros.php?genero=" + generoSeleccionado, true);
            xmlhttp.send();
        }
    }
</script>

</body>
<script src="./scriptmain.js"></script>
<?php include 'footer.php' ?>
</html>