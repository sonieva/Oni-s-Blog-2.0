<?php

function getHoraDelDia() {
  $hora = date('H');

  if ($hora >= 6 && $hora < 12) {
    return 'matí';
  } else if ($hora >= 12 && $hora < 20) {
    return 'a tarda';
  } else {
    return 'a nit';
  }
}

function getDiaSetmana() {
  $diesSetmana = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
  ];

  return $diesSetmana[date('N') - 1];
}

function validarContrasenya(string $password) {
  return strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password) && preg_match('/[\W]/', $password);
}