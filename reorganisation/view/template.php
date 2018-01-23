<!DOCTYPE html> <!-- obstart etc sera dans chaque vue -->
<html>
    <head>
        <meta charset="utf8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../view/mychanges.css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <![endif]-->
        <title><?= $pageTitle ?></title>
    </head>
    <body>
        <div class="fondBleu">
            <div class="container">
                <header class="row">
                    <h1 class="enTete col-xxl-12 col-xl-12 col-sm-12"><a href="index.php?">BILLET SIMPLE POUR L'ALASKA</a></h1>
                </header>
                <?= $content ?>
                <footer class="row">
                    <ul class="list-unstyled centrer col-xxl-12 col-xl-12 col-sm-12 ulfooter">
                        <li>l'auteur : Jean Forteroche</li>
                        <li>mail : jean.forteroche@gmail.com</li>
                    </ul>
                </footer>
            </div>
        </div>
    </body>
</html>