<?php
// Santi Onieva

class Connexio {
  private static $instance = null;
  private $pdo;

  private $host = 'db';
  private $dbName = 'Pt04_Santi_Onieva';
  private $user = 'root';
  private $password = 'p@ssw0rd';

  // Constructor privat per evitar que es pugui cridar directament
  private function __construct() {
    try {
      $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Error al conectar a la base de datos: " . $e->getMessage());
    }
  }

  // Mètode per obtenir la instància de la connexió a la base de dades per no haver de fer una nova connexió cada vegada
  public static function getInstance(): Connexio {
    if (self::$instance == null) {
      self::$instance = new Connexio();
    }

    return self::$instance;
  }

  // Metode per obtenir la connexió a la base de dades
  public function getConnection(): PDO {
    return $this->pdo;
  }
}
