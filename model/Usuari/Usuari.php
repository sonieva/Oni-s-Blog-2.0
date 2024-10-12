<?php

class Usuari {
  private ?int $id;
  private string $alies;
  private string $email;
  private string $password;
  private ?string $nom_complet;

  public function __construct(string $alies, string $email, string $password, ?string $nom_complet = null, ?int $id = null) {
    $this->id = $id;
    $this->alies = $alies;
    $this->email = $email;
    $this->password = $password;
    $this->nom_complet = $nom_complet;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
      $this->id = $id;
  }

  public function getAlies() {
      return $this->alies;
  }

  public function setAlies($alies) {
      $this->alies = $alies;
  }

  public function getEmail() {
      return $this->email;
  }

  public function setEmail($email) {
      $this->email = $email;
  }

  public function getPassword() {
      return $this->password;
  }

  public function setPassword($password) {
      $this->password = $password;
  }

  public function getNomComplet() {
      return $this->nom_complet;
  }

  public function setNomComplet($nom_complet) {
      $this->nom_complet = $nom_complet;
  }

}