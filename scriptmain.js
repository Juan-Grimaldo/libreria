const btnMenu = document.getElementById("btn-menu");
const contMenu = document.getElementById("container-menu");
const btnPro = document.getElementById("btn-pro");
const contPro = document.getElementById("container-pro");
const btnCerrar = document.querySelector("#btn-cerrar");
const btnFil1 = document.getElementById("btn-filtrar1");
const contDis = document.getElementById("container-dis");
const btnCerrardis = document.querySelector("#btn-cerrar-dis");
const btnFil2 = document.getElementById("btn-filtrar2");
const contPre = document.getElementById("container-pre");
const btnCerrarpre = document.querySelector("#btn-cerrar-pre");
const body = document.body;


document.addEventListener("DOMContentLoaded", function () {
  var librosFiltrados = []; // Almacena los libros filtrados
  var librosPorPagina = 10;
  var paginaActual = 1;
  var criterioOrdenamientoActual = "opcion1"; // Almacena el criterio de ordenamiento actual
  var librosContainer = document.getElementById("paginacion");
  var botonAnterior = document.getElementById("anterior");
  var botonSiguiente = document.getElementById("siguiente");
  var selectOrdenar1 = document.querySelector(".ordenar .dropdown select");
  var selectOrdenar2 = document.querySelector(".vent-ordenar .dropdown select");
  var selectOrdenar = document.querySelector(".dropdown select");

  botonAnterior.style.display = "none";

  // Realizar solicitud AJAX para obtener datos del servidor
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "obtener_libros.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var libros = JSON.parse(xhr.responseText); // Obtener los datos de la respuesta
        librosFiltrados = libros; // Actualizar los libros filtrados con los datos obtenidos del servidor
        // Aplicar filtros y mostrar libros al cargar la página
        aplicarFiltros();
      } else {
        console.error("Error al obtener datos del servidor.");
      }
    }
  };
  xhr.send();

  function aplicarFiltros() {
    var enExistencia = document.getElementById("checkbox1").checked;
    var agotado = document.getElementById("checkbox2").checked;
    var minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
    var maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;

    librosFiltrados = libros.filter(function (libro) {
      var precioLibro = parseFloat(libro.precio);
      var precioCumple = precioLibro >= minPrice && precioLibro <= maxPrice;

      if (enExistencia && !agotado) {
        return libro.disponibilidad === true && precioCumple;
      } else if (!enExistencia && agotado) {
        return libro.disponibilidad === false && precioCumple;
      } else {
        return precioCumple;
      }
    });

    paginaActual = 1;

    if (librosFiltrados.length === 0) {
      alert("No se encontraron libros que coincidan con los criterios de búsqueda.");
    } else {
      mostrarLibros(librosFiltrados, paginaActual);
    }
  }

  function filtrarLibros() {
    var enExistencia2 = document.getElementById("checkbox3").checked;
    var agotado2 = document.getElementById("checkbox4").checked;
    var minPrice2 = parseFloat(document.getElementById("minPrice2").value) || 0;
    var maxPrice2 = parseFloat(document.getElementById("maxPrice2").value) || Infinity;

    librosFiltrados = libros.filter(function (libro) {
      var precioLibro = parseFloat(libro.precio);
      var disponibilidadCumple = true;
      if (enExistencia2 && !agotado2) {
        disponibilidadCumple = libro.disponibilidad === true;
      } else if (!enExistencia2 && agotado2) {
        disponibilidadCumple = libro.disponibilidad === false;
      }

      return precioLibro >= minPrice2 && precioLibro <= maxPrice2 && disponibilidadCumple;
    });

    paginaActual = 1;

    if (librosFiltrados.length === 0) {
      alert("No se encontraron libros que coincidan con los criterios de búsqueda.");
    } else {
      mostrarLibros(librosFiltrados, paginaActual);
    }
  }

  function ordenarLibros(criterio) {
    criterioOrdenamientoActual = criterio; // Actualiza el criterio de ordenamiento
    if (criterio === "opcion1") {
      librosFiltrados.sort((a, b) => a.titulo.localeCompare(b.titulo));
    } else if (criterio === "opcion2") {
      librosFiltrados.sort((a, b) => b.titulo.localeCompare(a.titulo));
    } else if (criterio === "opcion3") {
      librosFiltrados.sort((a, b) => parseFloat(a.precio) - parseFloat(b.precio));
    } else if (criterio === "opcion4") {
      librosFiltrados.sort((a, b) => parseFloat(b.precio) - parseFloat(a.precio));
    }
    mostrarLibros(librosFiltrados, paginaActual); // Muestra los libros filtrados y ordenados
  }

  function mostrarLibros(librosAMostrar, pagina) {
    var inicio = (pagina - 1) * librosPorPagina;
    var fin = inicio + librosPorPagina;
    var librosPagina = librosAMostrar.slice(inicio, fin);

    librosContainer.innerHTML = "";
    librosPagina.forEach(function (libro) {
      var libroHTML = `
            <div class="libro">
                <div class="imagen-libro">
                    <img src="data:image/jpg;base64,${libro.imagen}" alt="Descripción de la imagen">
                </div>
                <p class="titulo">${libro.titulo}</p>
                <p class="editorial">${libro.autor}</p>
                <p class="valor">$${libro.precio}</p>
            </div>
        `;
      librosContainer.innerHTML += libroHTML;
    });
    // Actualiza la visibilidad de los botones de paginación
    botonAnterior.style.display = paginaActual > 1 ? "block" : "none";
    botonSiguiente.style.display = paginaActual < Math.ceil(librosFiltrados.length / librosPorPagina) ? "block" : "none";
  }

  function cambiarPagina(numeroPagina) {
    paginaActual = numeroPagina;
    mostrarLibros(librosFiltrados, paginaActual);
  }

  botonSiguiente.addEventListener("click", function () {
    if (paginaActual < Math.ceil(librosFiltrados.length / librosPorPagina)) {
      cambiarPagina(paginaActual + 1);
    }
  });

  botonAnterior.addEventListener("click", function () {
    if (paginaActual > 1) {
      cambiarPagina(paginaActual - 1);
    }
  });

  selectOrdenar.addEventListener("change", function() {
    ordenarLibros(this.value);
  });

  // Inicializa la página con el orden por defecto
  ordenarLibros(criterioOrdenamientoActual);

  // Event listener para el cambio en la selección de ordenar del primer selector
  selectOrdenar1.addEventListener("change", function() {
    ordenarLibros(this.value);
  });

  // Event listener para el cambio en la selección de ordenar del segundo selector
  selectOrdenar2.addEventListener("change", function() {
    ordenarLibros(this.value);
  });
  document.getElementById("checkbox1").addEventListener("change", aplicarFiltros);
  document.getElementById("checkbox2").addEventListener("change", aplicarFiltros);
  document.getElementById("checkbox3").addEventListener("change", filtrarLibros);
  document.getElementById("checkbox4").addEventListener("change", filtrarLibros);
  document.getElementById("minPrice").addEventListener("change", aplicarFiltros);
  document.getElementById("maxPrice").addEventListener("change", aplicarFiltros);
  document.getElementById("minPrice2").addEventListener("change", filtrarLibros);
  document.getElementById("maxPrice2").addEventListener("change", filtrarLibros);
});

btnMenu.addEventListener("click", () => {
  menuDisplayer();
})

btnPro.addEventListener("click", () => {
  proDisplayer();
})


// Función para expadir o contraer el menú
function menuDisplayer() {
  if (btnMenu) {
    btnMenu.classList.toggle("btn-menu-hidden");
    btnMenu.classList.toggle("btn-menu-show");

    contMenu.classList.toggle("btn-menu-hidden");
    contMenu.classList.toggle("btn-menu-show");

    body.classList.toggle("btn-menu-hidden");
    body.classList.toggle("btn-menu-show");
  } else {
    console.error("No se encontraron todos los elementos necesarios para mostrar u ocultar el menú.");
  }
}
function proDisplayer() {
  if (btnPro) {
    btnPro.classList.toggle("btn-pro-hidden");
    btnPro.classList.toggle("btn-pro-show");

    contPro.classList.toggle("btn-pro-hidden");
    contPro.classList.toggle("btn-pro-show");

    body.classList.toggle("btn-menu-hidden");
    body.classList.toggle("btn-menu-show");
  } else {
    console.error("No se encontraron todos los elementos necesarios para mostrar u ocultar el menú.");
  }
}