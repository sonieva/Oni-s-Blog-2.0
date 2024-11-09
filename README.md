# Oni's Blog 2.0

## Descripció del projecte

Oni's Blog 2.0 és una aplicació web centrada en la gestió i visualització d'articles sobre gats, on els usuaris poden registrar-se, iniciar sessió, afegir, editar i eliminar els seus propis articles. Els articles es poden visualitzar tant a la pàgina principal com al tauler de control de cada usuari. També inclou una vista prèvia interactiva dels articles abans de ser publicats, així com la capacitat de visualitzar-ne el contingut complet a través d'un diàleg modal.

## Funcionalitats principals

- **Registre i Autenticació d'Usuaris**: Els usuaris poden crear un compte, iniciar sessió i recordar les seves credencials mitjançant cookies.
- **Gestió d'Articles**: Afegir, modificar i eliminar articles des del tauler de control (dashboard).
- **Vista Prèvia**: Mentre es crea o edita un article, es pot veure una vista prèvia en temps real del títol, el cos i la imatge de l'article.
- **Modal per a la lectura completa**: Els articles que sobrepassen els 100 caràcters es poden expandir per veure'ls completament en una finestra modal.
- **Paginació**: Visualització dels articles amb paginació i opció per triar el nombre d'articles per pàgina.
- **Sessió d'usuari amb temps de caducitat**: La sessió de l'usuari caduca després de 40 minuts d'inactivitat.
- **Gestió d'imatges**: Suport per a la pujada d'imatges associades als articles, incloent validació d'extensions permeses.

```
onis-blog/
│
├── config/
│   ├── Config.php
│   ├── utils.php
│   └── session-lifetime.php
│
├── controller/
│   └── article.controller.php
│   └── pagination.controller.php
│
├── model/
│   ├── Connexio.php
│   ├── Usuari/
│   │   ├── Usuari.php
│   │   └── UsuariDAO.php
│   └── Article/
│       ├── Article.php
│       └── ArticleDAO.php
|
├── resources/
│   └── Pt04_Santi_Onieva.sql
│
├── view/
│   ├── auth/
│   │   ├── login.view.php
│   │   └── signup.view.php
│   ├── components/
│   │   ├── header.php
│   │   ├── llista-articles.php
│   │   └── pagination-buttons.php
│   ├── inici.view.php
│   ├── dashboard.view.php
│   └── perfil.view.php
│
├── api/
│   ├── get-article.php
│   ├── update-profile.php
│   └── preview-article.php
│
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
│
└── uploads/
```


## Credencials d'usuaris existents

| Usuari | Correu electrònic            | Contrasenya     |
|--------|------------------------------|-----------------|
| admin  | admin@oni.es               | P@ssw0rd        |

> **Nota**: Les contrasenyes es guarden de manera segura amb `password_hash()`.

## Requeriments

- **PHP** 8.2 o superior
- **MySQL** 8
- **Servidor web** (Apache, Nginx, etc.)
- **Docker** (Opcional, per a un desplegament fàcil amb Docker i Docker Compose)

## Valors a cambiar

Per un funcionament correcte, cal cambiar els següents valors:
- Connexio.php
```php
private $host = 'db'; // Cal posar la IP del servidor
private $dbName = 'Pt04_Santi_Onieva';
private $user = 'root'; // Si cal, s'ha de canviar l'usuari
private $password = 'p@ssw0rd'; // i la contrasenya
```