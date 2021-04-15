<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suppression d'un fruit - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="col-12 text-center">Suppression d'un fruit</h1>
        </div>
        <div class="row">
            <p class="alert alert-success fw-bold text-center">Le fruit a bien été supprimé !<br><a href="<?= PUBLIC_PATH . 'fruits/liste/'; ?>">Revenir à la liste des fruits</a></p>
        </div>

    </div>

    <?php include VIEWS_DIR . 'partials/footer.php' ?>
</body>
</html>