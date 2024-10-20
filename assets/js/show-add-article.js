// Santi Onieva

// Selecciona els elements HTML necessaris per gestionar l'acció d'afegir un article
const btnAdd = document.getElementById('btn-add'); // Botó per mostrar el formulari d'afegir article
const btnCancel = document.getElementById('btn-cancel'); // Botó per cancel·lar l'acció d'afegir article

const addArticleDiv = document.getElementById('afegir-article'); // Div que conté el formulari per afegir l'article

// Comprova si existeixen el botó per afegir i la divisió del formulari abans d'afegir els listeners
if (btnAdd && addArticleDiv) {
  // Afegeix un event listener al botó d'afegir article per mostrar el formulari
  btnAdd.addEventListener('click', () => {
    // Si el formulari no està visible, afegeix la classe 'show' per mostrar-lo
    if (!addArticleDiv.classList.contains('show')) {
      addArticleDiv.classList.add('show');
    }
  });
}

// Comprova si existeixen el botó per cancel·lar i la divisió del formulari abans d'afegir els listeners
if (btnCancel && addArticleDiv) {
  // Afegeix un event listener al botó de cancel·lar per amagar el formulari
  btnCancel.addEventListener('click', () => {
    // Si el formulari està visible, elimina la classe 'show' per amagar-lo
    if (addArticleDiv.classList.contains('show')) {
      addArticleDiv.classList.remove('show');
    }

    if (document.getElementById('errors-add')) {
      document.getElementById('errors-add').remove();
    }
  });
}
