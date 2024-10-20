<?php
// Santi Onieva

// S'inclouen les dependències necessàries per a la connexió amb la base de dades i la classe Article.
require_once '../model/Connexio.php';
require_once 'Article.php';

class ArticleDAO {
  private PDO $pdo;

  // Constructor que inicialitza la connexió amb la base de dades.
  public function __construct() {
    $this->pdo = Connexio::getInstance()->getConnection();
  }

  // Insereix un nou article a la base de dades.
  public function inserir(Article $article) {
    $sentenciaAfegir = $this->pdo->prepare("INSERT INTO articles (titol, cos, autor, ruta_imatge) VALUES (:titol, :cos, :autor, :ruta_imatge)");

    // S'executa la sentència amb els valors obtinguts de l'objecte Article.
    return $sentenciaAfegir->execute([
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  // Obté un article a partir del seu ID.
  public function getArticlePerId($id) {
    $sentencia = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();

    $resultat = $sentencia->fetch();

    // Crea un objecte Article amb les dades obtingudes de la base de dades.
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

  // Obté una llista d'articles, amb la possibilitat de filtrar per autor i aplicar paginació.
  public function getArticles($idAutor = null, $offet = 0, $articlesPerPagina = 6) {
    $sql = $idAutor ? 
      "SELECT * FROM articles WHERE autor = :autor LIMIT :offset, :articlesPerPagina" : 
      "SELECT * FROM articles LIMIT :offset, :articlesPerPagina";

    $sentencia = $this->pdo->prepare($sql);

    // S'afegeix el paràmetre d'autor si es proporciona.
    if ($idAutor) {
        $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
    }

    // S'afegeixen els paràmetres de paginació.
    $sentencia->bindParam(':offset', $offet, PDO::PARAM_INT);
    $sentencia->bindParam(':articlesPerPagina', $articlesPerPagina, PDO::PARAM_INT);

    // S'executa la consulta.
    $sentencia->execute();

    $articles = [];

    // Es crea una llista d'objectes Article amb els resultats obtinguts.
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

  // Obté el nombre total d'articles, amb la possibilitat de filtrar per autor.
  public function countArticles($idAutor = null) {
    $sql = $idAutor ? 
      "SELECT COUNT(*) FROM articles WHERE autor = :autor" : 
      "SELECT COUNT(*) FROM articles";
    $sentencia = $this->pdo->prepare($sql);

    // S'afegeix el paràmetre d'autor si es proporciona.
    if ($idAutor) {
      $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
    }

    // S'executa la consulta i es retorna el nombre d'articles.
    $sentencia->execute();
    return $sentencia->fetchColumn();
  }

  // Modifica un article existent a la base de dades.
  public function modificar(Article $article) {
    $sentenciaModificar = $this->pdo->prepare("UPDATE articles SET titol = :titol, cos = :cos, autor = :autor, ruta_imatge = :ruta_imatge, modificat = NOW() WHERE id = :id");

    // S'executa la sentència amb els valors actualitzats de l'objecte Article.
    return $sentenciaModificar->execute([
      'id' => $article->getId(),
      'titol' => $article->getTitol(),
      'cos' => $article->getCos(),
      'autor' => $article->getIdAutor(),
      'ruta_imatge' => $article->getRutaImatge(),
    ]);
  }

  // Elimina un article de la base de dades a partir del seu ID.
  public function eliminar($id) {
    $sentenciaEliminar = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
    $sentenciaEliminar->bindParam(':id', $id, PDO::PARAM_INT);
    
    // S'executa la sentència d'eliminació.
    return $sentenciaEliminar->execute();
  }
}
