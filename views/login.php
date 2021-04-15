<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="text-center">Connexion - WikiFruit</h1>
        </div>
        <div class="row">
            <?php

            if(isset($success)){
                echo '<p class="alert alert-success fw-bold text-center">' . $success . '</p>';
            } else {

                if(isset($errors['server'])){
                    echo '<p class="alert alert-danger fw-bold text-center">' . $errors['server'] . '</p>';
                }

                ?>

                    <form method="POST" action="<?= PUBLIC_PATH . 'connexion/' ?>" class="col-12 col-md-6 offset-md-3">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : ''; ?>" name="email" type="text" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            <?= isset($errors['email']) ? '<div class="invalid-feedback">' . $errors['email'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" class="form-control<?= isset($errors['password']) ? ' is-invalid' : ''; ?>" name="password" type="password">
                            <?= isset($errors['password']) ? '<div class="invalid-feedback">' . $errors['password'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="col-12 btn btn-success" value="Connexion">
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