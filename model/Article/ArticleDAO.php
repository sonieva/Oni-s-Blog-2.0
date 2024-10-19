<?
// Santi Onieva

require_once '../model/Connexio.php';
require_once 'Article.php';

class ArticleDAO {
  private PDO $pdo;

  public function __construct() {
    $this->pdo = Connexio::getInstance()->getConnection();
  }

  public function inserir(Article $article) {
    $sentenciaAfegir = $this->pdo->prepare("INSERT INTO articles (titol, cos, autor, ruta_imatge) VALUES (:titol, :cos, :autor, :ruta_imatge)");

    return $sentenciaAfegir->execute([
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  public function getArticlePerId($id) {
    $sentencia = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    $resultat = $sentencia->fetch();

    return new Article(
      $resultat['titol'], 
      $resultat['cos'],  
      $resultat['autor'], 
      $resultat['ruta_imatge'], 
      new DateTime($resultat['creat']), 
      isset($resultat['modificat']) ? new DateTime($resultat['modificat']) : null, 
      $resultat['id']
    );
  }

  public function getArticles($idAutor = null, $offet = 0, $articlesPerPagina = 6) {
    $sql = $idAutor ? "SELECT * FROM articles WHERE autor = :autor LIMIT :offset, :articlesPerPagina" : "SELECT * FROM articles LIMIT :offset, :articlesPerPagina";
    $sentencia = $this->pdo->prepare($sql);

    if ($idAutor) {
        $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
    }

    $sentencia->bindParam(':offset', $offet, PDO::PARAM_INT);
    $sentencia->bindParam(':articlesPerPagina', $articlesPerPagina, PDO::PARAM_INT);

    $sentencia->execute();


    $articles = [];

    while ($article = $sentencia->fetch(PDO::FETCH_ASSOC)) {
      $articles[] = new Article(
        $article['titol'], 
        $article['cos'],  
        $article['autor'], 
        $article['ruta_imatge'], 
        new DateTime($article['creat']), 
        isset($article['modificat']) ? new DateTime($article['modificat']) : null, 
        $article['id']
      );
    }

    return $articles;
  }

  public function countArticles($idAutor = null) {
    $sql = $idAutor ? "SELECT COUNT(*) FROM articles WHERE autor = :autor" : "SELECT COUNT(*) FROM articles";
    $sentencia = $this->pdo->prepare($sql);

    if ($idAutor) {
      $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
    }

    $sentencia->execute();

    return $sentencia->fetchColumn();
  }

  public function modificar(Article $article) {
    $sentenciaModificar = $this->pdo->prepare("UPDATE articles SET titol = :titol, cos = :cos, autor = :autor, ruta_imatge = :ruta_imatge, modificat = NOW() WHERE id = :id");

    return $sentenciaModificar->execute([
      'id' => $article->getId(),
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  public function eliminar($id) {
    $sentenciaEliminar = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
    $sentenciaEliminar->bindParam(':id', $id, PDO::PARAM_INT);
    return $sentenciaEliminar->execute();
  }
}