<?php
// Santi Onieva

if (session_status() == PHP_SESSION_NONE) session_start();

// Funció per obtenir la part del dia en funció de l'hora actual.
function getHoraDelDia(): string {
  // S'obté l'hora actual en format de 24 hores.
  $hora = date('H');

  // Es retorna 'matí' si és entre les 6:00 i les 11:59.
  if ($hora >= 6 && $hora < 12) {
    return 'matí';
  } 
  // Es retorna 'a tarda' si és entre les 12:00 i les 19:59.
  else if ($hora >= 12 && $hora < 20) {
    return 'a tarda';
  } 
  // Es retorna 'a nit' per qualsevol altra hora.
  else {
    return 'a nit';
  }
}

// Funció per obtenir el dia de la setmana en català.
function getDiaSetmana(): string {
  // Es defineix un array amb els dies de la setmana.
  $diesSetmana = [
    'Dilluns',
    'Dimarts',
    'Dimecres',
    'Dijous',
    'Divendres',
    'Dissabte',
    'Diumenge',
  ];

  // Es retorna el dia de la setmana corresponent a l'índex de l'array (1 = Dilluns).
  return $diesSetmana[date('N') - 1];
}

// Funció per generar un missatge de benvinguda aleatori.
function missatgeBenvinguda(): string {
  // Es defineix un array amb diferents missatges de benvinguda.
  $llistatBenvingudes = [
    'Hola', 
    'Bon' . getHoraDelDia(), 
    'Benvingut/da',
    'Benvingut/da de nou',
    'Feliç ' . getDiaSetmana(), 
    'Hola de nou', 
  ];

  // Es retorna un missatge de benvinguda aleatori de l'array.
  return $llistatBenvingudes[array_rand($llistatBenvingudes)];
}

// Funció per validar la seguretat d'una contrasenya.
function validarContrasenya(string $password): bool {
  // Es comprova que la contrasenya tingui almenys 8 caràcters, una majúscula, una minúscula, un número i un caràcter especial.
  return strlen($password) >= 8 && 
    preg_match('/[A-Z]/', $password) && 
    preg_match('/[a-z]/', $password) && 
    preg_match('/[0-9]/', $password) && 
    preg_match('/[\W]/', $password);
}

// Funció per validar una imatge pujada.
function validarImatge($imatge): void {
  // Es defineixen les extensions permeses per les imatges.
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  // S'obté l'extensió de l'arxiu pujat.
  $fileExtension = strtolower(pathinfo($imatge['name'], PATHINFO_EXTENSION));
  
  // Es comprova si no s'ha pujat cap arxiu.
  if (!isset($imatge)) {
    addMessage('errorAdd', 'No s\'ha pujat cap imatge');
  }

  // Es comprova si hi ha hagut algun error durant la pujada de l'arxiu.
  if ($imatge['error'] !== UPLOAD_ERR_OK) {
    addMessage('errorAdd', 'No s\'ha pogut pujar la imatge');
  }
  
  // Es comprova si l'extensió de l'arxiu no és vàlida.
  if (!in_array($fileExtension, $allowedExtensions)) {
    addMessage('errorAdd', 'L\'arxiu no té una extensió vàlida');
  }

  // Es mou l'arxiu pujat a la carpeta 'uploads' i es comprova si l'operació ha estat correcta.
  if (!move_uploaded_file($imatge['tmp_name'], '../uploads/' . basename($imatge['name']))) {
    addMessage('errorAdd', 'No s\'ha pogut pujar la imatge al servidor');
  }
}

function setMessage($key, $message): void {
  $_SESSION[$key] = $message;
}

function addMessage($key, $message): void {
  $_SESSION[$key][] = $message;
}

function getMessage($key): ?string {
  if (isset($_SESSION[$key])) {
      $message = $_SESSION[$key];
      unset($_SESSION[$key]); 
      return $message;
  }
  return null;
}

function getMessages($key): ?array {
  if (isset($_SESSION[$key])) {
      $messages = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $messages;
  }
  return null;
}

function generarToken(): string {
  return bin2hex(random_bytes(32));
}

function usuariEstaLogat(): void {
  if (!isset($_SESSION['usuari'])) {
    // Estableix el codi de resposta HTTP 403 Forbidden
    http_response_code(403);

    header('Location: ../view/errors/403.html');
    exit();
  }
}

function usuariNoEstaLogat(): void {
  if (isset($_SESSION['usuari'])) {
    header('Location: /');
    exit();
  }
}

function generarAliesAleatori(): string {
  $noms = [
    "Gat", "Gos", "Lleó", "Tigre", "Elefant", "Girafa", "Cavall", "Vaca", "Ovella", "Cabra",
    "Conill", "Porquet", "Àguila", "Falcó", "Colom", "Peix", "Granota", "Serp", "Ratpenat", "Cérvol",
    "Pingüí", "Dofí", "Foqueta", "Orca", "Balena", "Cigne", "Ànec", "Gall", "Gallina", "Oca",
    "Guineu", "Ós", "Cangur", "Panda", "Eriçó", "Esquirol", "Ratolí", "Rata", "Castor", "Hipopòtam",
    "Rinoceront", "Iguana", "Camell", "Dromedari", "Cama", "Gavina", "Gavot", "Pingüí", "Pollet",
    "Tauró", "Medusa", "Calamar", "Pop", "Cranc", "Llagosta", "Escorpí",
    "Mussol", "Óliba", "Bufo", "Aligot", "Corb", "Gaig", "Lloro", "Periquito", "Serpent", "Tortuga",
    "Sargantana", "Llangardaix", "Cocodril", "Aligot", "Faisà", "Tucà", "Ocellaire", "Agaporni", "Papagai", "Periquito",
    "Vespa", "Abella", "Formiga", "Escarabat", "Libèl·lula", "Papallona", "Mosca", "Mosquit", "Cuca",
    "Formiguer", "Aranya", "Escorpí", "Marieta", "Saltamartí", "Centpeus", "Milpeus",
    "Grill", "Cargol", "Medusa", "Corall", "Anemona", "Oruga", "Termita",
    "Tisoreta", "Pagell", "Rèmora", "Manta", "Bagre", "Carpa", "Truita", "Rèmora",
    "Tenca", "Perca", "Sardina", "Verat", "Lluç", "Moll", "Salpa", "Dorada", "Orada", "Anguila",
    "Clotxina", "Gamba", "Escamarlà", "Cloïssa", "Musclo", "Navalla", "Pop", "Sípia",
    "Calamaret", "Sepieta", "Tintorera", "Caiman", "Caimaní"
  ];

  $adjectius = [
    "Ràpid", "Lent", "Fort", "Feble", "Intel·ligent", "Tonto", "Gran", "Petit", "Enorme", "Mínim",
    "Bonic", "Lleig", "Brillant", "Fosc", "Clar", "Pesat", "Lleuger", "Calent", "Fred", "Tíbid",
    "Sec", "Humit", "Llis", "Rugós", "Fresc", "Vell", "Jove", "Nou", "Antic", "Mandrós",
    "Actiu", "Audaz", "Tímid", "Valent", "Covard", "Savi", "Ignorant", "Pacífic", "Agressiu", "Dòcil",
    "Rebel", "Feliç", "Trist", "Alegre", "Melancòlic", "Sà", "Malalt", "Tranquil", "Nerviós", "Confiat",
    "Desconfiat", "Curiós", "Indiferent", "Fidel", "Infidel", "Lleial", "Traïdor", "Just", "Injust",
    "Obert", "Tancat", "Generós", "Garrepa", "Amable", "Groller", "Cortès", "Descortès", "Optimista", "Pessimista",
    "Honest", "Deshonest", "Prudent", "Imprudent", "Responsable", "Irresponsable", "Puntual", "Impuntual", "Constant", "Inconstant",
    "Ambiciós", "Humil", "Extravagant", "Modest", "Fiable", "Insegur", "Ferm", "Àgil", "Maladroit", "Dinàmic",
    "Passiu", "Creatiu", "Rutinari", "Idealista", "Realista", "Simpatí", "Antipàtic", "Natural", "Artificial", "Llarg",
    "Curt", "Ample", "Estret", "Rodó", "Quadrat", "Esvelt", "Gruixut", "Perfecte", "Imperfecte", "Interessant",
    "Avorrit", "Útil", "Inútil", "Positiu", "Negatiu", "Agraït", "Ingratit", "Variable", "Durador", "Efímer",
    "Permanent", "Transitori", "Agradable", "Desagradable", "Pràctic", "Teòric", "Flexible", "Rígid", "Solitari", "Acompanyat",
    "Poblat", "Despoblat", "Civilitzat", "Salvatge", "Urbà", "Rural", "Industrial", "Artesanal", "Barat", "Car",
    "Luxós", "Senzill", "Net", "Brut", "Ordenat", "Desordenat", "Tardà", "Complex", "Senzill", "Profund",
    "Superficial", "Expansiu", "Retraït", "Eficaç", "Ineficaç", "Càlid", "Gèlid", "Solejat", "Ennuvolat", "Ventós",
    "Templat", "Cru", "Nutritiu", "Insalubre", "Saborós", "Insípid", "Fluid", "Dens", "Complicat", "Fàcil",
    "Divertit", "Monòton", "Exòtic", "Comú", "Viu", "Mort", "Estressant", "Relaxant", "Plen", "Buit",
    "Estudiós", "Gandul", "Precís", "Imprecís", "Formal", "Informal", "Diplomàtic", "Directe", "Atractiu", "Repulsiu",
    "Provocador", "Divers", "Homogeni", "Transparent", "Opac", "Sòlid", "Voluble", "Extrovertit", "Introvertit", "Eufòric",
    "Complaent", "Estricte", "Detallista", "Descuidat", "Pròsper", "Pobre", "Sofisticat", "Tosco", "Carinyós", "Apàtic"
  ];

  return $noms[array_rand($noms)] . '-' . $adjectius[array_rand($adjectius)] . '-' . rand(1, 999);
}

function descarregarImatgePerfil($url, $alies): ?string {
  try {
    $ch = curl_init($url);
  
    // Configurar opciones de cURL para descargar el archivo
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  
    // Ejecutar cURL y almacenar la respuesta
    $imatge = curl_exec($ch);
  
    // if (curl_errno($ch)) {
    //     echo 'Error al descargar la imagen: ' . curl_error($ch);
    //     curl_close($ch);
    //     exit();
    // }
  
    // Obtener información de la URL y el encabezado Content-Type
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $infoImatge = pathinfo($url);
    curl_close($ch);
  
    // Determinar la extensión del archivo desde el Content-Type o desde la URL
    $extensio = '';
    if (isset($infoImatge['extensio'])) {
        $extensio = $infoImatge['extensio'];
    } else {
        // Obtener la extensión desde el tipo de contenido
        if ($contentType == 'image/jpeg') {
            $extensio = 'jpg';
        } elseif ($contentType == 'image/png') {
            $extensio = 'png';
        } elseif ($contentType == 'image/gif') {
            $extensio = 'gif';
        }
    }
  
    $alies = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $alies);
      
    // Reemplazar caracteres especiales con sus equivalentes
    $alies = strtr($alies, [
        'á' => 'a', 'Á' => 'A',
        'é' => 'e', 'É' => 'E',
        'í' => 'i', 'Í' => 'I',
        'ó' => 'o', 'Ó' => 'O',
        'ú' => 'u', 'Ú' => 'U',
        'ñ' => 'n', 'Ñ' => 'N',
        'ü' => 'u', 'Ü' => 'U',
    ]);
  
    // Crear el nombre del archivo con la extensión adecuada
    $nombreArchivo = $alies . '.' . $extensio;
    $rutaImatge = '/uploads/profiles/' . $nombreArchivo;
    $rutaDesti = $_SERVER['DOCUMENT_ROOT'] . $rutaImatge;
  
    // Guardar la imagen en la ruta especificada
    file_put_contents($rutaDesti, $imatge);
  
    return $rutaImatge;
  } catch (Exception $e) {
    Logger::log('Error al descarregar la imatge de perfil desde autenticacio social:' . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
    return null;
  }
}

?>
