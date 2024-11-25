// Santi Onieva

// Funció per carregar un article completament mitjançant una petició AJAX
function loadArticle(id) {
  // Fa una petició GET a l'API per obtenir les dades de l'article pel seu id
  fetch(`api/get-article.php?id=${id}`)
    .then(response => response.json()) // Converteix la resposta a format JSON
    .then(data => {
      // Si l'API retorna un error, mostra una alerta amb el missatge i surt de la funció
      if (data.error) {
        alert(data.error);
        return;
      }
      
      // Assigna el títol, el cos i la imatge de l'article als elements del modal
      document.getElementById('modal-title').innerText = data.titol;
      document.getElementById('modal-body').innerText = data.cos;
      document.getElementById('modal-image').src = data.imatge;

      // Mostra el modal amb l'article carregat
      document.getElementById('articleModal').style.display = 'flex';
    })
    .catch(error => {
      // En cas d'error en la petició, mostra un missatge d'error a la consola i un alert a l'usuari
      console.error('Error:', error);
      alert('Hi ha hagut un problema en carregar l\'article.');
    });
}

// Funció per tancar el modal
function closeModal() {
  document.getElementById('articleModal').style.display = 'none';
}

function shareQRArticle(id) {
  fetch(`api/get-article-qr.php?id=${id}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }

      document.getElementById('qr-image').src = data.qr; 
  })

  document.getElementById('share-article-modal').style.display = 'flex';
}

function closeQRModal() {
  document.getElementById('qr-image').src = '';
  document.getElementById('share-article-modal').style.display = 'none';
}

// Event listener per tancar el modal quan es fa clic fora del seu contingut
window.addEventListener('click', function(event) {
  // Si l'usuari fa clic fora del modal (és a dir, a la capa de fons), es tanca el modal
  if (event.target.id === 'articleModal') {
    closeModal();
  }
});
