<?php
// Santi Onieva

class Usuari {
  // Atributs de la classe Usuari amb visibilitat privada.
  private ?int $id;
  private string $alies;
  private string $email;
  private string $password;
  private ?string $nom_complet;
  private ?string $token_recuperacio;
  private ?DateTime $expiracio_token;
  private ?string $ruta_imatge;
  private bool $esAdmin;

  // Constructor que inicialitza un objecte Usuari amb els valors proporcionats.
  public function __construct(string $alies, string $email, string $password, ?string $nom_complet = null, ?int $id = null, ?string $token_recuperacio = null, ?DateTime $expiracio_token = null, ?string $ruta_imatge = null, bool $esAdmin = false) {
    $this->id = $id;
    $this->alies = $alies;
    $this->email = $email;
    $this->password = $password;
    $this->nom_complet = $nom_complet;
    $this->token_recuperacio = $token_recuperacio;
    $this->expiracio_token = $expiracio_token;
    $this->ruta_imatge = $ruta_imatge;
    $this->esAdmin = $esAdmin;
  }

  // Retorna l'ID de l'usuari.
  public function getId() {
    return $this->id;
  }

  // Retorna l'àlies de l'usuari.
  public function getAlies() {
    return $this->alies;
  }

  // Estableix un nou valor per a l'àlies.
  public function setAlies($alies) {
    $this->alies = $alies;
  }

  // Retorna el correu electrònic de l'usuari.
  public function getEmail() {
    return $this->email;
  }

  // Estableix un nou correu electrònic per a l'usuari.
  public function setEmail($email) {
    $this->email = $email;
  }

  // Retorna la contrasenya de l'usuari.
  public function getPassword() {
    return $this->password;
  }

  // Estableix una nova contrasenya per a l'usuari.
  public function setPassword($password) {
    $this->password = $password;
  }

  // Retorna el nom complet de l'usuari.
  public function getNomComplet() {
    return $this->nom_complet;
  }

  // Estableix un nou nom complet per a l'usuari.
  public function setNomComplet($nom_complet) {
    $this->nom_complet = $nom_complet;
  }

  // Retorna el token de recuperació de l'usuari.
  public function getTokenRecuperacio() {
    return $this->token_recuperacio;
  }

  // Estableix un nou token de recuperació per a l'usuari.
  public function setTokenRecuperacio($token_recuperacio) {
    $this->token_recuperacio = $token_recuperacio;
  }

  // Retorna la data d'expiració del token de recuperació de l'usuari.
  public function getExpiracioToken() {
    return $this->expiracio_token;
  }

  // Estableix una nova data d'expiració per al token de recuperació de l'usuari.
  public function setExpiracioToken($expiracio_token) {
    $this->expiracio_token = $expiracio_token;
  }

  // Retorna la ruta de la imatge de perfil de l'usuari.
  public function getRutaImatge() {
    return $this->ruta_imatge;
  }

  // Estableix una nova ruta per a la imatge de perfil de l'usuari.
  public function setRutaImatge($ruta_imatge) {
    $this->ruta_imatge = $ruta_imatge;
  }

  // Retorna si l'usuari és administrador o no.
  public function esAdmin() {
    return $this->esAdmin;
  }

  // Estableix si l'usuari és administrador o no.
  public function setEsAdmin($esAdmin) {
    $this->esAdmin = $esAdmin;
  }

}
