// Santi Onieva

const btnAdd = document.getElementById('btn-add');
const btnCancel = document.getElementById('btn-cancel');

const addArticleDiv = document.getElementById('afegir-article');

if (btnAdd && addArticleDiv) {
  btnAdd.addEventListener('click', () => {
    if (!addArticleDiv.classList.contains('show')) {
      addArticleDiv.classList.add('show');
    }
  });
}

if (btnCancel && addArticleDiv) {
  btnCancel.addEventListener('click', () => {
    if (addArticleDiv.classList.contains('show')) {
      addArticleDiv.classList.remove('show');
    }
  });
}