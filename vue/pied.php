<?php
    function pied($js)
    {
?>
                <footer class="row">
                    <ul class="list-unstyled centrer col-xxl-12 col-xl-12 col-sm-12 ulfooter">
                        <li>l'auteur : Jean Forteroche</li>
                        <li>mail : jean.forteroche@gmail.com</li>
                    </ul>
                </footer>
            </div>
        </div>
        <?php
            if ($js != '')
            { 
                try
                {
                    require $_SERVER['DOCUMENT_ROOT'] . '/vue/' . $js . '.php';
                }
                catch (Exception $e)
                {
                    echo '<p>erreur : ' . $e->getMessage() ; '</p>';
                }
            }
        ?>
    </body>
</html>
<?php
    }
?>