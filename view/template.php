<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../public/plugins/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../public/myChanges.css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <![endif]-->
        <title><?= $pageTitle ?></title>
    </head>
    <body>
        <div class="fondBleu">
            <div class="container">
                <div class="bg-dark row navperso">
                    <ul class="col-12 row ulnav">
                        <li class="col-sm col-12">
                            <a href="https://frederic-malard.com">
                                portfolio
                            </a>
                        </li>
                        <li class="col-sm col-12">
                            <a href="https://louvre.frederic-malard.com">
                                louvre
                            </a>
                        </li>
                        <li class="col-sm col-12">
                            <a href="https://blog.frederic-malard.com">
                                blog personnel
                            </a>
                        </li>
                        <li class="col-sm col-12">
                            blog écrivain
                        </li>
                    </ul>
                </div>
                <header class="row">
                    <h1 class="enTete col-xxl-12 col-xl-12 col-sm-12"><a href="index.php">BILLET SIMPLE POUR L'ALASKA</a></h1>
                </header>
                <?= $content ?>
                <footer class="row">
                    <ul class="list-unstyled centrer col-xxl-12 col-xl-12 col-sm-12 ulfooter" style="margin-bottom : 0em !important;">
                        <li>l'auteur : Jean Forteroche</li>
                        <li>mail : jean.forteroche@gmail.com</li>
                    </ul>
                    <a href="connexion.php" class="btn btn-secondary m-auto" style="margin-bottom : 2em !important; margin-top : 0em !important;">Connexion a l'interface administrateur</a>
                </footer>
            </div>
        </div>
    </body>
</html>