<?php
// Santi Onieva

// S'inclou la classe UsuariDAO per poder obtenir informació sobre els autors dels articles.
require_once '../model/Usuari/UsuariDAO.php';

class Article {
  private ?string $id;
  private string $titol;
  private string $cos;
  private ?DateTime $data_creacio;
  private ?DateTime $data_modificacio;
  private int $id_autor;
  private string $ruta_imatge;

  // Constructor de la classe Article que inicialitza els seus atributs.
  public function __construct(
    string $titol,
    string $cos,
    int $id_autor,
    string $ruta_imatge,
    ?DateTime $data_creacio = null,
    ?DateTime $data_modificacio = null,
    ?string $id = null
  ) {
    $this->id = $id;
    $this->titol = $titol;
    $this->cos = $cos;
    $this->data_creacio = $data_creacio;
    $this->data_modificacio = $data_modificacio;
    $this->id_autor = $id_autor;
    $this->ruta_imatge = $ruta_imatge;
  }

  // Obté l'ID de l'article.
  public function getId() {
    return $this->id;
  }

  // Obté el títol de l'article.
  public function getTitol() {
    return $this->titol;
  }

  // Estableix el títol de l'article.
  public function setTitol($titol) {
    $this->titol = $titol;
  }

  // Obté el cos (contingut) de l'article.
  public function getCos() {
    return $this->cos;
  }

  // Estableix el cos (contingut) de l'article.
  public function setCos($cos) {
    $this->cos = $cos;
  }

  // Obté la data de creació de l'article.
  public function getDataCreacio() {
    return $this->data_creacio;
  }

  // Obté la data de modificació de l'article.
  public function getDataModificacio() {
    return $this->data_modificacio;
  }

  // Estableix la data de modificació de l'article.
  public function setDataModificacio($data_modificacio) {
    $this->data_modificacio = $data_modificacio;
  }

  // Obté l'autor de l'article com un objecte Usuari.
  public function getAutor() {
    $usuariDAO = new UsuariDAO();
    return $usuariDAO->getUsuariPerId($this->id_autor);
  }

  // Obté l'ID de l'autor de l'article.
  public function getIdAutor() {
    return $this->id_autor;
  }

  // Estableix l'ID de l'autor de l'article.
  public function setIdAutor($id_autor) {
    $this->id_autor = $id_autor;
  }

  // Obté la ruta de la imatge associada a l'article.
  public function getRutaImatge() {
    return $this->ruta_imatge;
  }

  // Estableix la ruta de la imatge associada a l'article.
  public function setRutaImatge($ruta_imatge) {
    $this->ruta_imatge = $ruta_imatge;
  }
}
