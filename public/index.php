<?php

// Inclusion des dépendances installées avec composer
require __DIR__ . '/../vendor/autoload.php';

// Inclusion du fichier contenant les fonctions et configurations générales du site
require __DIR__ . '/../configs/functions.php';

// Inclusion du fichier contenant les paramètres personnalisables du site (comme els accès àa la BDD par exemple)
require __DIR__ . '/../configs/params.php';


// Trycatch général qui capturera toutes les erreurs et exceptions pouvant arriver sur le site ("Throwable" capture tout ce qui peux être lancé avec un "throw") )
try{

    // Inclusion du fichier routes.php qui contient toutes les urls du site (routes) et qui chargera les contrôleurs pour chacunes des routes
    require __DIR__ . '/../configs/routes.php';

} catch(Throwable $e){ ?>
    <div style="background-color: #ffa2a2; padding: 15px;">
        <h1><b>Erreur PHP !</b></h1>
        <hr>
        <p><b>Fichier</b> : <?= $e->getFile() ?></p>
        <p><b>Ligne</b> : <?= $e->getLine() ?></p>
        <p><b>Message</b> : <span style="font-size: 20px;"><?= $e->getMessage() ?></span></p>
        <hr>
        <!-- Affichage de la pile d'erreur dans un dump au cas où on aurait besoin de plus de détails sur l'erreur affichée -->
        <?php dump($e->getTrace()); ?>
    </div>
    <?php
}