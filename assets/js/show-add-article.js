const btnAdd = document.getElementById('btn-add');
const btnCancel = document.getElementById('btn-cancel');

const addArticleDiv = document.getElementById('afegir-article');

btnAdd.addEventListener('click', () => {
  if (!addArticleDiv.classList.contains('show')) {
    addArticleDiv.classList.add('show');
  }
});

btnCancel.addEventListener('click', () => {
  if (addArticleDiv.classList.contains('show')) {
    addArticleDiv.classList.remove('show');
  }
});