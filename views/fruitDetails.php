<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= ucfirst(htmlspecialchars( $fruit->getName() )); ?> - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="col-12 text-center"><?= ucfirst(htmlspecialchars( $fruit->getName() )); ?> - Fiche Wikifruit</h1>
        </div>
        <div class="row">

            <div class="col-12">

                <?php

                if(isConnected()){
                    ?>

                    <p class="my-4 text-center"><a href="<?= PUBLIC_PATH . 'fruits/modifier/?id=' . $fruit->getId(); ?>"><i class="fas fa-edit me-2"></i>Modifier le fruit</a></p>
                    <p class="my-4 text-center"><a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fruit ?')" href="<?= PUBLIC_PATH . 'fruits/supprimer/?id=' . $fruit->getId(); ?>"><i class="fas fa-times me-2"></i>Supprimer le fruit</a></p>

                    <?php
                }

                ?>

                <div class="card text-center">
                    <h2 class="card-header">
                        <?= ucfirst(htmlspecialchars($fruit->getName())); ?>
                    </h2>
                    <div class="card-body">
                        <h3 class="card-title">Fruit "<span class="text-primary"><?= htmlspecialchars($fruit->getColor()) ?></span>" venant du pays "<span class="text-primary"><?= ucfirst(htmlspecialchars($fruit->getOrigin())) ?></span>" coûtant <span class="text-primary"><?= htmlspecialchars($fruit->getPricePerKilo()) ?>€</span></h3>
                        <p class="card-text my-5">Description : <?= htmlspecialchars($fruit->getDescription()) ?></p>
                        <a href="<?= PUBLIC_PATH . 'fruits/liste/' ?>" class="btn btn-primary">Revenir à la liste des fruits</a>
                    </div>
                    <div class="card-footer text-muted">
                        Ce fruit a été ajouté sur le site par <?= ucfirst(htmlspecialchars($fruit->getUser()->getFirstname())) ?>
                    </div>
                </div>

            </div>
            
        </div>

    </div>

    <?php include VIEWS_DIR . 'partials/footer.php' ?>
</body>
</html>