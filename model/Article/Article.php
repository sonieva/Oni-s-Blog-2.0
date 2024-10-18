<?
// Santi Onieva

require_once '../model/Usuari/UsuariDAO.php';

class Article {
  private ?string $id;
  private string $titol;
  private string $cos;
  private ?DateTime $data_creacio;
  private ?DateTime $data_modificacio;
  private string $id_autor;
  private string $ruta_imatge;

  public function __construct(string $titol, string $cos, string $id_autor, string $ruta_imatge, ?DateTime $data_creacio = null, ?DateTime $data_modificacio = null, ?string $id = null) {
    $this->id = $id;
    $this->titol = $titol;
    $this->cos = $cos;
    $this->data_creacio = $data_creacio;
    $this->data_modificacio = $data_modificacio;
    $this->id_autor = $id_autor;
    $this->ruta_imatge = $ruta_imatge;
  }

  public function getId() {
    return $this->id;
  }

  public function getTitol() {
    return $this->titol;
  }

  public function setTitol($titol) {
    $this->titol = $titol;
  }

  public function getCos() {
    return $this->cos;
  }

  public function setCos($cos) {
    $this->cos = $cos;
  }

  public function getDataCreacio() {
    return $this->data_creacio;
  }

  public function getDataModificacio() {
    return $this->data_modificacio;
  }

  public function setDataModificacio($data_modificacio) {
    $this->data_modificacio = $data_modificacio;
  }

  public function getAutor() {
    $usuariDAO = new UsuariDAO();
    return $usuariDAO->getUsuariPerId($this->id_autor);
  }

  public function getIdAutor() {
    return $this->id_autor;
  }

  public function setIdAutor($id_autor) {
    $this->id_autor = $id_autor;
  }

  public function getRutaImatge() {
    return $this->ruta_imatge;
  }

  public function setRutaImatge($ruta_imatge) {
    $this->ruta_imatge = $ruta_imatge;
  }
}