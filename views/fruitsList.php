<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des fruits - Wikifruit</title>
    <?php include VIEWS_DIR . 'partials/header.php' ?>
</head>
<body>
    <?php include VIEWS_DIR . 'partials/menu.php'; ?>

    <div class="container">

        <div class="row my-5">
            <h1 class="col-12 text-center">Liste des fruits - Wikifruit</h1>
        </div>
        <div class="row">

            <?php

            if(empty($fruitsList)){
                echo '<p class="alert alert-info fw-bold text-center">Il n\'y a pas de fruit à afficher pour le moment !</p>';
            } else {
                ?>
                    
                <table class="table table-primary text-center col-12 table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fruit</th>
                        <th scope="col">Pays</th>
                        <th scope="col">Prix /kg</th>
                        <th scope="col">Fiche</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($fruitsList as $fruit){
                            ?>
                                <tr>
                                    <td><?= ucfirst(htmlspecialchars($fruit->getId())) ?></td>
                                    <td><?= ucfirst(htmlspecialchars($fruit->getName())) ?></td>
                                    <td><?= ucfirst(htmlspecialchars($fruit->getOrigin())) ?></td>
                                    <td><?= htmlspecialchars($fruit->getPricePerKilo()) ?>€</td>
                                    <td><a href="<?= PUBLIC_PATH . 'fruits/fiche/?id=' . $fruit->getId() ?>">Voir la fiche</a></td>
                                </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                
                <?php
            }
            
            ?>
            
        </div>

    </div>

    <?php include VIEWS_DIR . 'partials/footer.php' ?>
</body>
</html>