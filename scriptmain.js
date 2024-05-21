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
  const minPriceInput = document.getElementById('minPrice2');
  const maxPriceInput = document.getElementById('maxPrice2');

  botonAnterior.style.display = "none";

  // Hacer la solicitud AJAX para obtener los datos iniciales
  fetch('obtener_libros.php')
    .then(response => response.json())
    .then(data => {
      // Guardar los datos obtenidos en una variable global
      window.booksData = data;

      // Filtrar y mostrar los datos inicialmente
      filterAndDisplayBooks();
    })
    .catch(error => console.error('Error al obtener los datos:', error));

  // Añadir eventos 'blur' a los campos de filtro
  minPriceInput.addEventListener('blur', filterAndDisplayBooks);
  maxPriceInput.addEventListener('blur', filterAndDisplayBooks);

  function filterAndDisplayBooks() {
    let minPrice = parseFloat(minPriceInput.value);
    const maxPrice = parseFloat(maxPriceInput.value) || Number.MAX_VALUE;
    
    
    // Verificar si los campos de filtro están vacíos
    if (minPriceInput.value === '' && maxPriceInput.value === '') {
      librosFiltrados = window.booksData; // Mostrar todos los libros
    } else {
      // Verificar si el valor de minPrice es menor que 0 y ajustarlo a 0 si es necesario
      if (minPrice < 0) {
        minPrice = 0;
        minPriceInput.value = minPrice;
      }
  
      // Filtrar los datos de los libros según los precios
      librosFiltrados = window.booksData.filter(book => {
        const price = parseFloat(book.precio);
        return price >= minPrice && price <= maxPrice;
      });
  
      if (librosFiltrados.length === 0) {
        alert("No se encontraron libros que coincidan con los criterios de búsqueda.");
        // Reiniciar los filtros
        minPriceInput.value = '';
        maxPriceInput.value = '';
        librosFiltrados = window.booksData; // Mostrar todos los libros
      }
    }
  
    paginaActual = 1;
    mostrarLibros(librosFiltrados, paginaActual);
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
                  <img src="${libro.imagen_url}" alt="Descripción de la imagen">
              </div>
              <p class="título">${libro.titulo}</p>
              <p class="autor">${libro.autor}</p>
              <p class="valor">$${libro.precio}</p>
              <a href="view_prod.php?id_libro=${libro.id_libro}" class="detalles">Detalles</a> <!-- Agrega aquí el enlace -->
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