// Santi Onieva

// Funció per eliminar un article, rep l'id de l'article com a paràmetre
function deleteArticle(id) {
  // Mostra un missatge de confirmació a l'usuari abans d'eliminar l'article
  if (confirm("Segur que vols eliminar aquest article?")) {
    // Si l'usuari confirma, redirigeix a la URL per eliminar l'article específicament
    window.location.href = `controller/article.controller.php?action=delete&id=${id}`;
  }
}
