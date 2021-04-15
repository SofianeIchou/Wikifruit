<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Erreur 404 - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="col-12 text-center">Erreur 404 : page introuvable</h1>
        </div>
        <div class="row">
            <p class="alert alert-warning fw-bold text-center">Désolé cette page n'existe pas !</p>
            <p class="text-center"><img src="<?= PUBLIC_PATH . 'images/404.png' ?>" alt=""></p>
        </div>

    </div>

    <?php include VIEWS_DIR . 'partials/footer.php' ?>
</body>
</html>