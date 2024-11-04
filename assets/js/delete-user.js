// Santi Onieva

// Funció per eliminar un article, rep l'id de l'article com a paràmetre
function deleteUsuari(id) {
  // Mostra un missatge de confirmació a l'usuari abans d'eliminar l'article
  if (confirm("Segur que vols eliminar aquest usuari?")) {
    
    fetch(`api/check-user-articles.php?id=${id}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) { alert(data.error); return; }
      
      if (data.teArticles) {
        if (confirm("Aquest usuari té articles publicats. Segur que vols eliminar-lo? Tots els articles publicats per aquest usuari també s'eliminaran.")) {
          window.location.href = `controller/user.controller.php?action=delete&id=${id}`;
        } else {
          return;
        }
      } else {
        window.location.href = `controller/user.controller.php?action=delete&id=${id}`;
      }
    })
    .catch(error => console.error(error));
  }
}
