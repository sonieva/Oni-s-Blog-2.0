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
    $sentenciaAfegir = $this->pdo->prepare("INSERT INTO articles (titol, cos, id_autor, ruta_imatge) VALUES (:titol, :cos, :id_autor, :ruta_imatge)");

    return $sentenciaAfegir->execute([
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'id_autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  public function getArticlePerId($id) {
    $sentencia = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");

    $sentencia->bindParam(':id', $id);

    $sentencia->execute();

    $resultat = $sentencia->fetch();

    return new Article($resultat['titol'], $resultat['cos'],  $resultat['id_autor'], $resultat['ruta_imatge'], new DateTime($resultat['data_creacio']), new DateTime($resultat['data_modificacio']), $resultat['id']);
  }

  public function getArticlePerAutor($id_autor) {
    $sentencia = $this->pdo->prepare("SELECT * FROM articles WHERE autor = :autor");

    $sentencia->bindParam(':autor', $id_autor);

    $sentencia->execute();

    $resultats = $sentencia->fetchAll();

    $articles = [];

    foreach ($resultats as $resultat) {
      $articles[] = new Article($resultat['titol'], $resultat['cos'],  $resultat['id_autor'], $resultat['ruta_imatge'], new DateTime($resultat['data_creacio']), new DateTime($resultat['data_modificacio']), $resultat['id']);
    }

    return $articles;
  }

  public function getArticles() {
    $sentencia = $this->pdo->prepare("SELECT * FROM articles");

    $sentencia->execute();

    $resultats = $sentencia->fetchAll();

    $articles = [];

    foreach ($resultats as $resultat) {
      $articles[] = new Article($resultat['titol'], $resultat['cos'],  $resultat['id_autor'], $resultat['ruta_imatge'], new DateTime($resultat['data_creacio']), new DateTime($resultat['data_modificacio']), $resultat['id']);
    }

    return $articles;
  }

  public function modificar(Article $article) {
    $sentenciaModificar = $this->pdo->prepare("UPDATE articles SET titol = :titol, cos = :cos, id_autor = :id_autor, ruta_imatge = :ruta_imatge, data_modificacio = NOW() WHERE id = :id");

    return $sentenciaModificar->execute([
      'id' => $article->getId(),
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'id_autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  public function eliminar($id) {
    $sentenciaEliminar = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");

    return $sentenciaEliminar->execute([
      'id' => $id,
    ]);
  }
}