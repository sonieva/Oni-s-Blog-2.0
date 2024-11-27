document.addEventListener('DOMContentLoaded', function () {
  const searchBar = document.getElementById('search-bar');
  const articlesContainer = document.getElementById('articles-container');
  const paginationContainerTop = document.getElementById('pagination-container-top');
  const paginationContainerBottom = document.getElementById('pagination-container-bottom');
  const orderSelect = document.getElementById('ordenaPer');
  const perPageSelect = document.getElementById('articlesPerPagina');
  const isDashboard = window.location.href.includes('dashboard');

  const cookies = document.cookie.split(';').map(cookie => cookie.trim());
  const perPageCookie = cookies.find(cookie => cookie.startsWith('articlesPerPagina='));
  const orderCookie = cookies.find(cookie => cookie.startsWith('ordenaPer='));

  if (perPageCookie) perPageSelect.value = perPageCookie.split('=')[1];
  if (orderCookie) orderSelect.value = orderCookie.split('=')[1];
  
  let currentPage = 1;
  let articlesPerPagina = perPageSelect ? parseInt(perPageSelect.value) : 6;
  let ordenaPer = orderSelect ? orderSelect.value : 'creat-asc';

  searchBar.addEventListener('input', debounce(function () {
    currentPage = 1;
    cercaArticles(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
  }, 300));

  if (orderSelect) {
    orderSelect.addEventListener('change', function () {
      ordenaPer = this.value;
      document.cookie = `ordenaPer=${ordenaPer}; path=/; SameSite=none; Secure`;
      cercaArticles(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
    });
  }

  if (perPageSelect) {
    perPageSelect.addEventListener('change', function () {
      articlesPerPagina = parseInt(this.value);
      document.cookie = `articlesPerPagina=${articlesPerPagina}; path=/; SameSite=none; Secure`;
      currentPage = 1;
      cercaArticles(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
    });
}

  function cercaArticles(query, page, perPage, orderBy) {
    const url = `/api/find-articles.php?q=${encodeURIComponent(query)}&page=${page}&articlesPerPagina=${perPage}&ordenaPer=${orderBy}&isDashboard=${isDashboard}`;
    fetch(url)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          console.error('Error en la cerca:', data.error);
          return;
        }
        mostrarResultados(data.articles, data.numArticlesUsuari);
        generarPaginacio(data.totalPagines, page);
      })
      .catch(error => {
        console.error('Error en la cerca:', error);
      });
  }

  function mostrarResultados(articles, numArticlesUsuari) {
    articlesContainer.innerHTML = '';

    if (articles.length === 0) {
      if (isDashboard && numArticlesUsuari === 0) {
        articlesContainer.innerHTML = '<h2 class="no-articles">Encara no has publicat cap article</h2>';
        return;
      }
      articlesContainer.innerHTML = '<h2 class="no-articles">No s\'han trobat articles.</h2>';
      return;
    }

    articles.forEach(article => {
      const articleElement = document.createElement('article');

      articleElement.innerHTML = `
        <figure>
          <img src="${article.ruta_imatge}" alt="${article.titol}">
          ${isDashboard ? `
            <a class="btn-delete" onclick="deleteArticle(${article.id})" title="Eliminar">
              <i class="fa-solid fa-trash-alt"></i>
            </a>
            <a class="btn-edit" href="controller/article.controller.php?action=update&id=${article.id}" title="Editar">
              <i class="fa-solid fa-edit"></i>
            </a>` : ''}
        </figure>
        <div class="article-info">
          <small class="article-date">Publicat ${article.creat}</small>
          ${article.modificat ? `<small class="article-date">Modificat ${article.modificat}</small>` : ''}
          <small class="article-author">Per <strong>${article.autor}</strong></small>
        </div>
        <div class="article-body">
          <h2>${article.titol}</h2>
          <p>${article.cos.length > 100 ? article.cos.substring(0, 100) + '...' : article.cos}</p>
          ${article.cos.length > 100 ? `<a class="read-more" onclick="loadArticle(${article.id})">Continua llegint <i class="fa-solid fa-arrow-right"></i></a>` : ''}
          <a class="share-article" onclick="shareQRArticle(${article.id})" title="Comparteix QR">
            <i class="fa-solid fa-qrcode"></i>
          </a>
        </div>
      `;
      articlesContainer.appendChild(articleElement);
    });
  }

  function generarPaginacio(totalPaginas, paginaActual) {
    paginationContainerTop.innerHTML = '';
    paginationContainerBottom.innerHTML = '';

    const prevButtonTop = crearBotoPaginacio('prev', paginaActual - 1, paginaActual === 1);
    const prevButtonBottom = crearBotoPaginacio('prev', paginaActual - 1, paginaActual === 1);

    paginationContainerTop.appendChild(prevButtonTop);
    paginationContainerBottom.appendChild(prevButtonBottom);

    for (let i = 1; i <= totalPaginas; i++) {
      const buttonTop = crearBotoPaginacio(i, i);
      const buttonBottom = crearBotoPaginacio(i, i);

      if (i === paginaActual) {
        buttonTop.classList.add('active');
        buttonBottom.classList.add('active');
      }

      paginationContainerTop.appendChild(buttonTop);
      paginationContainerBottom.appendChild(buttonBottom);
    }

    const nextButtonTop = crearBotoPaginacio('next', paginaActual + 1, paginaActual === totalPaginas || totalPaginas === 0);
    const nextButtonBottom = crearBotoPaginacio('next', paginaActual + 1, paginaActual === totalPaginas || totalPaginas === 0);

    paginationContainerTop.appendChild(nextButtonTop);
    paginationContainerBottom.appendChild(nextButtonBottom);
  }

  function crearBotoPaginacio(text, page, disabled = false) {
    const button = document.createElement('a');
    button.className = (text === 'prev' || text === 'next') ? 'flecha' : 'numPagina';
    button.innerHTML = text === 'prev' ? `<i class="fa-solid fa-chevron-left"></i>` :
                      text === 'next' ? `<i class="fa-solid fa-chevron-right"></i>` : text;

    if (disabled) {
      button.classList.add('disabled');
    } else {
      button.addEventListener('click', () => {
        currentPage = page;
        cercaArticles(searchBar.value.trim(), currentPage, articlesPerPagina, ordenaPer);
      });
    }

    return button;
  }

  cercaArticles('', currentPage, articlesPerPagina, ordenaPer);
});

function debounce(func, delay) {
  let timer;
  return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
  };
}
