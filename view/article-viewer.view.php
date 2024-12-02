<?php
// Santi Onieva

require_once '../model/Article/ArticleDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /');
    exit();
  }

  $articleDAO = new ArticleDAO();
  $article = $articleDAO->getArticlePerId($_GET['id']);

  if (!$article) {
    header('Location: /');
    exit();
  }  
?> 
  
  <!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oni's Blog 2.0 | <?= $article->getTitol() ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f1e5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .article-container {
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .article-image {
            width: 100%;
            height: auto;
        }

        .article-content {
            padding: 20px;
        }

        .article-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #f15b2a;
        }

        .article-details {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }

        .article-details small {
            display: block;
            margin-top: 3px;
        }

        .article-body {
            margin-top: 15px;
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        @media (max-width: 600px) {
            .article-container {
                width: 100%;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="article-container">
        <img src="<?= $article->getRutaImatge() ?>" alt="<?= $article->getTitol() ?>" class="article-image">
        <div class="article-content">
            <h1 class="article-title"><?= $article->getTitol() ?></h1>
            <div class="article-details">
                <small>Publicat: <?= $article->getDataCreacio()->format('j/m/o') ?></small>
                <?php if ($article->getDataModificacio()): ?>
                    <small>Modificat: <?= $article->getDataModificacio()->format('j/m/o') ?></small>
                <?php endif; ?>
                <small>Per: <strong><?= $article->getAutor()->getAlies() ?></strong></small>
            </div>
            <div class="article-body">
                <?= htmlspecialchars_decode($article->getCos()) ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
} else {
  header('Location: /view/errors/403.html');
  exit();
}