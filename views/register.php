<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="text-center">Inscription - WikiFruit</h1>
        </div>
        <div class="row">
            <?php

            if(isset($success)){
                echo '<p class="alert alert-success">' . $success . '</p>';
            } else {

                if(isset($errors['server'])){
                    echo '<p class="alert alert-danger">' . $errors['server'] . '</p>';
                }

                ?>

                    <form method="POST" action="<?= PUBLIC_PATH . 'creer-un-compte/' ?>" class="col-12 col-md-6 offset-md-3">

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
                            <label for="confirm-password" class="form-label">Confirmation du mot de passe</label>
                            <input id="confirm-password" class="form-control<?= isset($errors['confirm-password']) ? ' is-invalid' : ''; ?>" name="confirm-password" type="password">
                            <?= isset($errors['confirm-password']) ? '<div class="invalid-feedback">' . $errors['confirm-password'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input id="firstname" class="form-control<?= isset($errors['firstname']) ? ' is-invalid' : ''; ?>" name="firstname" type="text" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['firstname']) : ''; ?>">
                            <?= isset($errors['firstname']) ? '<div class="invalid-feedback">' . $errors['firstname'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input id="lastname" class="form-control<?= isset($errors['lastname']) ? ' is-invalid' : ''; ?>" name="lastname" type="text" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['lastname']) : ''; ?>">
                            <?= isset($errors['lastname']) ? '<div class="invalid-feedback">' . $errors['lastname'] . '</div>' : ''; ?>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="col-12 btn btn-success" value="Créer mon compte">
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