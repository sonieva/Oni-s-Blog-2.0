<?php
// Santi Onieva

// S'inclouen les dependències necessàries per a la connexió amb la base de dades i la classe Article.
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/Connexio.php';
require_once 'Article.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Logger.php';

class ArticleDAO {
  private PDO $pdo;

  // Constructor que inicialitza la connexió amb la base de dades.
  public function __construct() {
    try {
      $this->pdo = Connexio::getInstance()->getConnection();
    } catch (PDOException $e) {
      Logger::log("Error al obtenir la connexio amb la base de dades: " . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
    }
  }

  // Insereix un nou article a la base de dades.
  public function inserir(Article $article): bool {
    try {
      $sentenciaAfegir = $this->pdo->prepare("INSERT INTO articles (titol, cos, autor, ruta_imatge) VALUES (:titol, :cos, :autor, :ruta_imatge)");
  
      // S'executa la sentència amb els valors obtinguts de l'objecte Article.
      $resultat = $sentenciaAfegir->execute([
        'titol' => $article->getTitol(),
        'cos' => $article->getCos(),
        'autor' => $article->getIdAutor(),
        'ruta_imatge' => $article->getRutaImatge(),
      ]);

      Logger::log("L'usuari ". $article->getAutor()->getAlies() ." ha inserit un nou article amb ID: " . $this->pdo->lastInsertId(), TipusLog::DATABASE_LOG, LogLevel::INFO);
      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error en el metode inserir de ArticleDAO: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }

  // Obté un article a partir del seu ID.
  public function getArticlePerId($id): ?Article {
    try {
      $sentencia = $this->pdo->prepare("SELECT * FROM articles WHERE id = :id");
      $sentencia->bindParam(':id', $id);
      $sentencia->execute();
  
      // Es comprova si s'ha obtingut un resultat.
      if ($sentencia->rowCount() === 0) {
        return null;
      }
  
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
    } catch (PDOException $e) {
      Logger::log("Error al obtenir l'article: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return null;
    }
  }

  public function getAllArticles($idAutor = null): array {
    $articles = [];

    try {
      $sql = $idAutor ? 
        "SELECT * FROM articles WHERE autor = :autor" : 
        "SELECT * FROM articles";
        
      $sentencia = $this->pdo->prepare($sql);
  
      // S'afegeix el paràmetre d'autor si es proporciona.
      if ($idAutor) {
          $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
      }
  
      // S'executa la consulta.
      $sentencia->execute();
  
  
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

    } catch (PDOException $e) {
      Logger::log("Error al obtenir articles: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
    }

    return $articles;
  }

  public function buscarArticles(string $query, int $offset, int $limit, string $ordenaPer, ?int $userId = null): array {
    $articles = [];
    
    try {
      $ordenaPer = explode('-', $ordenaPer);
  
      $sql = "SELECT * FROM articles WHERE (titol LIKE :query OR cos LIKE :query)";
  
      if ($userId !== null) {
        $sql .= " AND autor = :userId"; // Filtrar por autor si es el dashboard del usuario
      }
  
      $sql .= " ORDER BY " . $ordenaPer[0] . ' ' . $ordenaPer[1];
      $sql .= " LIMIT :offset, :limit";
  
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
  
      if ($userId !== null) {
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
      }
  
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
      $stmt->execute();
  
  
      while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

    } catch (PDOException $e) {
      Logger::log("Error al cercar articles: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
    }

    return $articles;
  }

  // Obté el nombre total d'articles, amb la possibilitat de filtrar per autor.
  public function countArticles(int $idAutor = null, string $query): int {
    try {
      $sql = $idAutor ? 
        "SELECT COUNT(*) FROM articles WHERE autor = :autor AND (titol LIKE :query OR cos LIKE :query)" : 
        "SELECT COUNT(*) FROM articles WHERE (titol LIKE :query OR cos LIKE :query)";
      $sentencia = $this->pdo->prepare($sql);
  
      // S'afegeix el paràmetre d'autor si es proporciona.
      if ($idAutor) {
        $sentencia->bindParam(':autor', $idAutor, PDO::PARAM_INT);
      }

      $sentencia->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
  
      // S'executa la consulta i es retorna el nombre d'articles.
      $sentencia->execute();
      $resultat = $sentencia->fetchColumn();
  
      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error al contar articles: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return 0;
    }
  }

  // Modifica un article existent a la base de dades.
  public function modificar(Article $article): bool {
    try {
      $sentenciaModificar = $this->pdo->prepare("UPDATE articles SET titol = :titol, cos = :cos, autor = :autor, ruta_imatge = :ruta_imatge, modificat = NOW() WHERE id = :id");
  
      // S'executa la sentència amb els valors actualitzats de l'objecte Article.
      $resultat = $sentenciaModificar->execute([
        'id' => $article->getId(),
        'titol' => $article->getTitol(),
        'cos' => $article->getCos(),
        'autor' => $article->getIdAutor(),
        'ruta_imatge' => $article->getRutaImatge(),
      ]);
  
      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error al modificar un article: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }

  // Elimina un article de la base de dades a partir del seu ID.
  public function eliminar(int $id): bool {
    try {
      $sentenciaEliminar = $this->pdo->prepare("DELETE FROM articles WHERE id = :id");
      $sentenciaEliminar->bindParam(':id', $id, PDO::PARAM_INT);
      
      // S'executa la sentència d'eliminació.
      $resultat = $sentenciaEliminar->execute();

      return $resultat;
    } catch (PDOException $e) {
      Logger::log("Error al eliminar l'article: " . $e->getMessage(), TipusLog::DATABASE_ERROR, LogLevel::ERROR);
      return false;
    }
  }
}
