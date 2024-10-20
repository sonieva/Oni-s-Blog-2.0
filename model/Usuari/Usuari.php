<?php
// Santi Onieva

class Usuari {
  // Atributs de la classe Usuari amb visibilitat privada.
  private ?string $id;
  private string $alies;
  private string $email;
  private string $password;
  private ?string $nom_complet;

  // Constructor que inicialitza un objecte Usuari amb els valors proporcionats.
  public function __construct(string $alies, string $email, string $password, ?string $nom_complet = null, ?string $id = null) {
    $this->id = $id;
    $this->alies = $alies;
    $this->email = $email;
    $this->password = $password;
    $this->nom_complet = $nom_complet;
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

}
