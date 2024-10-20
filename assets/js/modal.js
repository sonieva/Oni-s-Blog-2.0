function loadArticle(id) {
  fetch(`api/get-article.php?id=${id}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }
      
      document.getElementById('modal-title').innerText = data.titol;
      document.getElementById('modal-body').innerText = data.cos;
      document.getElementById('modal-image').src = data.imatge;

      document.getElementById('articleModal').style.display = 'flex';
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Hi ha hagut un problema en carregar l\'article.');
    });
}

function closeModal() {
  document.getElementById('articleModal').style.display = 'none';
}

window.addEventListener('click', function(event) {
  if (event.target.id === 'articleModal') {
    closeModal();
  }
});