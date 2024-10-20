function deleteArticle(id){
  if (confirm("Segur que vols eliminar aquest article?")){
    window.location.href = `controller/article.controller.php?action=delete&id=${id}`;
  }
}