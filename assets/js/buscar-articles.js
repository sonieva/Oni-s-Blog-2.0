document.addEventListener('DOMContentLoaded', function () {
  const searchBar = document.getElementById('search-bar');
  const articlesContainer = document.getElementById('articles-container');
  const paginationContainerTop = document.getElementById('pagination-container-top');
  const paginationContainerBottom = document.getElementById('pagination-container-bottom');
  const orderSelect = document.getElementById('ordenaPer'); // Cambiado para obtener el select específico por id
  const perPageSelect = document.getElementById('articlesPerPagina');
  const isDashboard = window.location.href.includes('dashboard'); // Verificar si la URL contiene 'dashboard.view.php'

  // Obtener las preferencias del usuario de las cookies
  const cookies = document.cookie.split(';').map(cookie => cookie.trim());
  const perPageCookie = cookies.find(cookie => cookie.startsWith('articlesPerPagina='));
  const orderCookie = cookies.find(cookie => cookie.startsWith('ordenaPer='));

  if (perPageCookie) perPageSelect.value = perPageCookie.split('=')[1];
  if (orderCookie) orderSelect.value = orderCookie.split('=')[1];
  
  let currentPage = 1;
  let articlesPerPagina = perPageSelect ? parseInt(perPageSelect.value) : 6;
  let ordenaPer = orderSelect ? orderSelect.value : 'creat-asc';

  // Función para manejar la búsqueda en tiempo real y la paginación
  searchBar.addEventListener('input', debounce(function () {
      currentPage = 1; // Reiniciar a la primera página en cada nueva búsqueda
      buscarArticulos(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
  }, 300));

  // Evento para cambiar el orden de los artículos
  if (orderSelect) {
    orderSelect.addEventListener('change', function () {
        ordenaPer = this.value;
        document.cookie = `ordenaPer=${ordenaPer}; path=/`; // Guardar la preferencia del usuario en una cookie
        buscarArticulos(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
    });
  }

  // Evento para cambiar el número de artículos por página
  if (perPageSelect) {
    perPageSelect.addEventListener('change', function () {
        articlesPerPagina = parseInt(this.value);
        document.cookie = `articlesPerPagina=${articlesPerPagina}; path=/`; // Guardar la preferencia del usuario en una cookie
        currentPage = 1; // Reiniciar a la primera página
        buscarArticulos(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
    });
}

  // Función para buscar artículos y mostrar resultados
  function buscarArticulos(query, page, perPage, orderBy) {
    const url = `/api/find-articles.php?q=${encodeURIComponent(query)}&page=${page}&articlesPerPagina=${perPage}&ordenaPer=${orderBy}&isDashboard=${isDashboard}`;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          console.error('Error en la búsqueda:', data.error);
          return;
        }
        mostrarResultados(data.articulos, data.numArticulos);
        generarPaginacion(data.totalPaginas, page);
      })
      .catch(error => {
        console.error('Error en la búsqueda:', error);
      });
  }

  // Mostrar los resultados de la búsqueda en tiempo real
  function mostrarResultados(articulos, numArticulos) {
    articlesContainer.innerHTML = ''; // Limpiar los resultados anteriores

    if (articulos.length === 0) {
      if (isDashboard && numArticulos === 0) {
        articlesContainer.innerHTML = '<h2 class="no-articles">Encara no has publicat cap article</h2>';
        return;
      }
      articlesContainer.innerHTML = '<h2 class="no-articles">No s\'han trobat articles.</h2>';
      return;
    }

    articulos.forEach(articulo => {
      const articleElement = document.createElement('article');

      // Puedes construir el HTML del artículo según tu estructura actual.
      articleElement.innerHTML = `
        <figure>
          <img src="${articulo.ruta_imatge}" alt="${articulo.titol}">
          ${isDashboard ? `
            <a class="btn-delete" onclick="deleteArticle(${articulo.id})" title="Eliminar">
              <i class="fa-solid fa-trash-alt"></i>
            </a>
            <a class="btn-edit" href="controller/article.controller.php?action=update&id=${articulo.id}" title="Editar">
              <i class="fa-solid fa-edit"></i>
            </a>` : ''}
        </figure>
        <div class="article-info">
          <small class="article-date">Publicat ${articulo.creat}</small>
          ${articulo.modificat ? `<small class="article-date">Modificat ${articulo.modificat}</small>` : ''}
          <small class="article-author">Per <strong>${articulo.autor}</strong></small>
        </div>
        <div class="article-body">
          <h2>${articulo.titol}</h2>
          <p>${articulo.cos.length > 100 ? articulo.cos.substring(0, 100) + '...' : articulo.cos}</p>
          ${articulo.cos.length > 100 ? `<a class="read-more" onclick="loadArticle(${articulo.id})">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>` : ''}
          <a class="share-article" onclick="shareQRArticle(${articulo.id})" title="Comparteix QR">
            <i class="fa-solid fa-qrcode"></i>
          </a>
        </div>
      `;
      articlesContainer.appendChild(articleElement);
    });
  }

  function generarPaginacion(totalPaginas, paginaActual) {
    // Limpiar ambos contenedores de paginación antes de generar nuevos botones
    paginationContainerTop.innerHTML = '';
    paginationContainerBottom.innerHTML = '';

    // Crear el botón de página anterior, si no estamos en la primera página
    const prevButtonTop = crearBotonPaginacion('prev', paginaActual - 1, paginaActual === 1);
    const prevButtonBottom = crearBotonPaginacion('prev', paginaActual - 1, paginaActual === 1);

    paginationContainerTop.appendChild(prevButtonTop);
    paginationContainerBottom.appendChild(prevButtonBottom);

    // Crear botones numerados para cada página
    for (let i = 1; i <= totalPaginas; i++) {
      const buttonTop = crearBotonPaginacion(i, i);
      const buttonBottom = crearBotonPaginacion(i, i);

      if (i === paginaActual) {
        buttonTop.classList.add('active');
        buttonBottom.classList.add('active');
      }

      paginationContainerTop.appendChild(buttonTop);
      paginationContainerBottom.appendChild(buttonBottom);
    }

    // Crear el botón de página siguiente, si no estamos en la última página
    const nextButtonTop = crearBotonPaginacion('next', paginaActual + 1, paginaActual === totalPaginas || totalPaginas === 0);
    const nextButtonBottom = crearBotonPaginacion('next', paginaActual + 1, paginaActual === totalPaginas || totalPaginas === 0);

    paginationContainerTop.appendChild(nextButtonTop);
    paginationContainerBottom.appendChild(nextButtonBottom);
  }

  function crearBotonPaginacion(text, page, disabled = false) {
    const button = document.createElement('a');
    button.className = (text === 'prev' || text === 'next') ? 'flecha' : 'numPagina';
    button.innerHTML = text === 'prev' ? `<i class="fa-solid fa-chevron-left"></i>` :
                      text === 'next' ? `<i class="fa-solid fa-chevron-right"></i>` : text;

    if (disabled) {
      button.classList.add('disabled');
    } else {
      button.addEventListener('click', () => {
        currentPage = page; // Actualizamos la página actual
        buscarArticulos(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer); // Actualizamos artículos
      });
    }

    return button;
  }

  buscarArticulos('', currentPage, articlesPerPagina, ordenaPer);
});


// Función de debounce
function debounce(func, delay) {
  let timer;
  return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
  };
}
