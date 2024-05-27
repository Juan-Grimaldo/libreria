document.addEventListener("DOMContentLoaded", function () {
    const searchIcon = document.getElementById("search-icon");
    const searchBar = document.getElementById("search-bar");
    const searchInput = document.getElementById("search-input");
    const searchResults = document.getElementById("search-results");

    window.booksData = [];
    // Hacer la solicitud AJAX para obtener los datos iniciales
    fetch('obtener_libros.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los datos');
            }
            return response.json();
        })
        .then(data => {
            window.booksData = data;
        })
        .catch(error => console.error('Error al obtener los datos:', error));

    searchIcon.addEventListener("click", function () {
        searchBar.style.display = searchBar.style.display === "block" ? "none" : "block";
        if (searchBar.style.display === "block") {
            searchInput.focus(); // Enfocar el input de búsqueda cuando se despliegue la barra
        }
    });

    searchInput.addEventListener("input", function () {
        const query = searchInput.value.toLowerCase();
        searchResults.innerHTML = ''; // Limpiar resultados previos

        if (query) {
            const filteredBooks = window.booksData.filter(book =>
                book.titulo.toLowerCase().includes(query) ||
                book.autor.toLowerCase().includes(query)
            );

            filteredBooks.forEach(book => {
                const resultItem = document.createElement("div");
                resultItem.className = "search-result-item";

                // Comprobar si book.title y book.author están definidos antes de usar toLowerCase()
                const titulo = book.titulo ? book.titulo.toLowerCase() : "";
                const autor = book.autor ? book.autor.toLowerCase() : "";

                resultItem.innerHTML = `
                    <a href="view_prod.php?id_libro=${book.id_libro}">
                        <div class="search-result-title">${titulo}</div>
                        <div class="search-result-author">${autor}</div>
                    </a>
                `;
                searchResults.appendChild(resultItem);
            });
        }
    });
});