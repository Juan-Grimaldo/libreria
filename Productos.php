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
            margin-bottom: 10px;
        }

        .product-related {
            width: 95%;
            padding: 10px;
            display: flex;
            justify-content: center;
        }

        .tittle {
            font-size: 40px;
            margin: 0;
        }
    </style>
</head>
<hr>
<div id="dark-overlay2" class="btn-pro-hidden">
    <div id="container-pro" class="btn-pro-hidden">
        <button id="btn-cerrar" class="btn-pro-show close">
            <label for="btn-cerrar" class="icon-equis">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </label>
        </button>
        <div class="ini-filtro">
            <p>Filtrar y ordenar</p>
        </div>
        <div class="hr">
            <hr>
        </div>
        <div class="filtrar-ordenar">
            <button id="btn-filtrar2" class="btn-pre-hidden">Precio
                <label for="btn-filtrar2" class="btn-pre-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right-circle" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 15l3 -3l-3 -3" />
                        <path d="M5 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M7 12h14" />
                    </svg>
                </label>
            </button>
            <div class="vent-ordenar">
                <p>Ordenar por:</p>
                <div class="dropdown">
                    <select>
                        <option value="" disabled selected hidden>Alfabeticamente, A-Z</option>
                        <option value="opcion1">Alfabeticamente, A-Z</option>
                        <option value="opcion2">Alfabeticamente, Z-A</option>
                        <option value="opcion3">Precio, menor a mayor</option>
                        <option value="opcion4">Precio, mayor a menor</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="hr">
            <hr>
        </div>
        <div class="eliminar">
            <button id="eliminar" class="delete">Eliminar todos filtros</button>
        </div>
    </div>
</div>
<div id="dark-overlay4" class="btn-pre-hidden">
    <div id="container-pre" class="btn-pre-hidden">
        <button id="btn-cerrar-pre" class="btn-pre-show close">
            <label for="btn-cerrar" class="icon-equis">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </label>
        </button>
        <div class="ini-filtro">
            <p>Filtrar y ordenar</p>
        </div>
        <div class="hr">
            <hr>
        </div>
        <div class="filtrar-ordenar">
            <button id="btn-filtrar2" class="btn-pre-show">
                <label for="btn-filtrar2" class="btn-pre-show boton">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left-circle" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 12h-14" />
                        <path d="M6 9l-3 3l3 3" />
                        <path d="M19 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    </svg>
                    <div>
                        Precio
                    </div>
                </label>
            </button>
            <form id="searchForm" class="precios">
                <div class="precio">
                    <label for="minPrice">Desde:</label>
                    <input type="number" id="minPrice" name="minPrice" min="0" placeholder="Precio mínimo">
                </div>
                <div class="precio">
                    <label for="maxPrice">Hasta:</label>
                    <input type="number" id="maxPrice" name="maxPrice" min="0" placeholder="Precio máximo">
                </div>
            </form>
        </div>
        <div class="hr">
            <hr>
        </div>
        <div class="eliminar">
            <button id="eliminar3" class="delete">Eliminar Filtros</button>
        </div>
    </div>
</div>
<div class="main-pro">
    <h1 class="titule-pro">Productos</h1>
    <div class="filtrar">
        <button id="btn-pro" class="btn-pro-hidden">
            <label for="btn-pro" id="">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-horizontal" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 6l8 0" />
                    <path d="M16 6l4 0" />
                    <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 12l2 0" />
                    <path d="M10 12l10 0" />
                    <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M4 18l11 0" />
                    <path d="M19 18l1 0" />
                </svg>
                <p>Filtrar y ordenar</p>
            </label>
        </button>
        <?php
            include 'conexion.php';
            $query = "SELECT COUNT(*) as total FROM libro";
            $resultado = mysqli_query($conn, $query);
            $fila = mysqli_fetch_assoc($resultado);

            // Obtener el total de registros
            $total_registros = $fila['total'];
            ?>
            <p><?php echo $total_registros ?> Productos</p>
    </div>
    <div class="filtro-desk">
        <div class="filtros">
            <p>Filtro:</p>
            <div class="dropdown">
                <div class="flex-order">
                    <a href="#">Precio</a>
                    <div class="svg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-caret-down dropdown-svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 10l6 6l6 -6h-12" />
                        </svg>
                    </div>
                </div>
                <div class="dropdown-filtro">
                    <div>
                        <div class="eliminar">
                            <button id="eliminardesk2" class="delete">Eliminar Filtros</button>
                        </div>
                    </div>
                    <hr>
                    <form id="searchForm" class="precios2">
                        <div class="precio2">
                            <label for="minPrice">Desde:</label>
                            <input type="number" id="minPrice2" name="minPrice" min="0" placeholder="Precio mínimo">
                        </div>
                        <div class="precio2">
                            <label class="hasta" for="maxPrice">Hasta:</label>
                            <input type="number" id="maxPrice2" name="maxPrice" min="0" placeholder="Precio máximo">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ordenar">
            <div class="vent-ordenar">
                <p>Ordenar por:</p>
                <div class="dropdown">
                    <select>
                        <option value="" disabled selected hidden>Alfabeticamente, A-Z</option>
                        <option value="opcion1">Alfabeticamente, A-Z</option>
                        <option value="opcion2">Alfabeticamente, Z-A</option>
                        <option value="opcion3">Precio, menor a mayor</option>
                        <option value="opcion4">Precio, mayor a menor</option>
                    </select>
                </div>
            </div>
            <?php
            include 'conexion.php';
            $query = "SELECT COUNT(*) as total FROM libro";
            $resultado = mysqli_query($conn, $query);
            $fila = mysqli_fetch_assoc($resultado);

            // Obtener el total de registros
            $total_registros = $fila['total'];
            ?>
            <p><?php echo $total_registros ?> Productos</p>
        </div>
    </div>
    <div class="productos">
        <div class="libros" id="paginacion">
        </div>
        <div class="paginacion">
            <div id="anterior" class="wrapper">
                <button class="bonito">
                    Anterior
                </button>
            </div>
            <div id="siguiente" class="wrapper">
                <button class="bonito">
                    Siguiente
                </button>
            </div>
        </div>
    </div>
</div>
</main>
</body>
<script src="./scriptmain.js"></script>
<?php include 'footer.php' ?>

</html>