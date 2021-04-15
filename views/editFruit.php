<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un fruit - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="text-center">Modifier un fruit - WikiFruit</h1>
        </div>
        <div class="row">
            <?php

            if(isset($success)){
                echo '<p class="alert alert-success fw-bold text-center">' . $success . '<br><a href="' . PUBLIC_PATH . 'fruits/liste/">Revenir à la liste des fruits</a></p>';
            } else {

                if(isset($errors['server'])){
                    echo '<p class="alert alert-danger fw-bold text-center">' . $errors['server'] . '</p>';
                }

                ?>

                    <form method="POST" action="<?= PUBLIC_PATH . 'fruits/modifier/?id=' . htmlspecialchars($_GET['id']); ?>" class="col-12 col-md-6 offset-md-3">

                        <div class="mb-3">
                            <label for="name" class="form-label">ID</label>
                            <input disabled id="name" class="form-control" type="text" value="<?= htmlspecialchars($fruitToUpdate->getId()); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input id="name" class="form-control<?= isset($errors['name']) ? ' is-invalid' : ''; ?>" name="name" type="text" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($fruitToUpdate->getName()); ?>">
                            <?= isset($errors['name']) ? '<div class="invalid-feedback">' . $errors['name'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Couleur</label>
                            <input id="color" class="form-control<?= isset($errors['color']) ? ' is-invalid' : ''; ?>" name="color" type="text" value="<?= isset($_POST['color']) ? htmlspecialchars($_POST['color']) : htmlspecialchars($fruitToUpdate->getColor()); ?>">
                            <?= isset($errors['color']) ? '<div class="invalid-feedback">' . $errors['color'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="origin" class="form-label">Pays d'origine</label>
                            <input id="origin" class="form-control<?= isset($errors['origin']) ? ' is-invalid' : ''; ?>" name="origin" type="text" value="<?= isset($_POST['origin']) ? htmlspecialchars($_POST['origin']) : htmlspecialchars($fruitToUpdate->getOrigin()); ?>">
                            <?= isset($errors['origin']) ? '<div class="invalid-feedback">' . $errors['origin'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="price-per-kilo" class="form-label">Prix au kilo</label>
                            <input id="price-per-kilo" class="form-control<?= isset($errors['price-per-kilo']) ? ' is-invalid' : ''; ?>" name="price-per-kilo" type="text" value="<?= isset($_POST['price-per-kilo']) ? htmlspecialchars($_POST['price-per-kilo']) : htmlspecialchars($fruitToUpdate->getPricePerKilo()); ?>">
                            <?= isset($errors['price-per-kilo']) ? '<div class="invalid-feedback">' . $errors['price-per-kilo'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control<?= isset($errors['description']) ? ' is-invalid' : ''; ?>" name="description" id="description" cols="30" rows="10"><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($fruitToUpdate->getDescription()); ?></textarea>
                            <?= isset($errors['description']) ? '<div class="invalid-feedback">' . $errors['description'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="col-12 btn btn-success" value="Modifier le fruit">
                        </div>

                    </form>

                <?php

            }

            ?>
        </div>

    </div>

    <?php include VIEWS_DIR . 'partials/footer.php' ?>
</body>
</html>