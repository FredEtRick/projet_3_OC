    <article class="col-xxl-6 col-xl-12 col-sm-12">
        <form id="getNewPostForm" method="post" action="<?= $formAction ?>">
            <p>
                <label for="newPostTitle">
                    * titre : 
                </label>
                <input type="text" name="newPostTitle" id="newPostTitle" value="<?= $titleValue ?>" />
            </p>
            <p>
                <label for="tinymceNewPost">
                    * contenu :
                </label><br />
                <textarea name="tinymceNewPost" class="tinymce" id="tinymceNewPost">
                </textarea>
            </p>
            <p>
                Publier immédiatement ?<br />
                <input type="radio" name="publish" value="oui" id="oui" <?= $ouiChecked ?> required />
                <label for="oui">
                    oui
                </label><br />
                <input type="radio" name="publish" value="non" id="non" <?= $nonChecked ?> required />
                <label for="non">
                    non, publier le :
                </label><br />
                <input type="date" name="datePublication" id="datePublication" /> 
                <input type="time" name="timePublication" id="timePublication" value="<?= $timePubInput ?>" /><br />
                <span class="grisItalique">(date au format français : jj/mm/aaaa. Exemple : 01/01/2019)<br />
                    (heure au format : hh:mm. Exemple : 21:30)</span>
            </p>
            <p>
                Doit expirer...<br />
                <input type="radio" name="expire" value="jamais" id="jamais" <?= $jamaisChecked ?> required />
                <label for="jamais">
                    jamais
                </label><br />
                <input type="radio" name="expire" value="dateExpire" id="dateExpireRadio" <?= $dateExpireRadioChecked ?> required />
                <label for="dateExpireRadio">
                    non, expire le :
                </label><br />
                <input type="date" name="dateExpire" id="dateExpire" />
                <input type="time" name="timeExpire" id="timeExpire" value="<?= $timeExpireInput ?>" /><br />
                <span class="grisItalique">(date au format français : jj/mm/aaaa. Exemple : 01/01/2019)<br />
                    (heure au format : hh:mm. Exemple : 21:30)</span>
            </p>
            <p>
                <input type="submit" value="publier" />
            </p>
            <p>
                * : champs obligatoires
            </p>
            <p id="messageJs">
                
            </p>
        </form>
        <script type="text/javascript" src="../public/plugins/jquery.min.js"></script>
        <script type="text/javascript" src="../public/plugins/tinymce/tinymce.min.js"></script>
        <?php
            require_once "public/plugins/tinymce/init-tinymce.php";
        ?>
        <script type="text/javascript">
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            var isFirefox = typeof InstallTrigger !== 'undefined';
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
            var isIE = /*@cc_on!@*/false || !!document.documentMode;
            var isEdge = !isIE && !!window.StyleMedia;
            var isChrome = !!window.chrome && !!window.chrome.webstore;
            var isBlink = (isChrome || isOpera) && !!window.CSS;
            
            if (isSafari)
            {
                document.getElementById("datePublication").setAttribute("value", "<?= $datePubInputFr ?>");
                document.getElementById("dateExpire").setAttribute("value", "<?= $dateExpireInputFr ?>");
                document.getElementById("messageJs").innerHTML = 'safari ' + '<?= $datePubInputFr ?>' + '<?= $dateExpireInputFr ?>';
            }
            else if (isChrome)
            {
                document.getElementById("datePublication").setAttribute("value", "<?= $datePubInputEn ?>");
                document.getElementById("dateExpire").setAttribute("value", "<?= $dateExpireInputEn ?>");
                document.getElementById("messageJs").innerHTML = 'chrome ' + '<?= $datePubInputEn ?>';
            }
            else
            {
                document.getElementById("messageJs").innerHTML = 'autre';
            }
            
            function insertContent()
            {
                $("#getNewPostForm").submit(function(e){
                    var changing = false;
                    var content = tinymce.get("tinymceNewPost").getContent();
                    if ($("#newPostTitle").val() == '')
                    {
                        if (!$("#warningTitle").length)
                            $("<p style=\"color:red;margin-top:0px;\" id=\"warningTitle\">Veuillez renseigner un titre pour le billet !</p>").insertAfter($("#newPostTitle"));
                        changing = true;
                    }
                    if (!$("#newPostTitle").val() == '' && $("#warningTitle").length)
                    {
                        $("#warningTitle").remove();
                        changing = true;
                    }
                    if (content == '')
                    {
                        if (!$("#warningTiny").length)
                            $("<p style=\"color:red;margin-top:0px;\" id=\"warningTiny\">Veuillez renseigner un contenu pour le billet !</p>").insertAfter($("#tinymceNewPost"));
                        changing = true;
                    }
                    if (content != '' && $("#warningTiny").length)
                    {
                        $("#warningTiny").remove();
                        changing = true;
                    }
                    if ($("#non").prop("checked") && ($("#datePublication").val() == '' || ($("#timePublication").val() == '')))
                    {
                        if (!$("#warningPublication").length)
                            $("<p style=\"color:red;margin-top:0px;\" id=\"warningPublication\">Veuillez renseigner la date et l'heure de publication !</p>").insertAfter($("#timePublication"));
                        changing = true;
                    }
                    if (($("#oui").prop("checked") || (!$("#datePublication").val() == '' && !$("#timePublication").val() == '')) && $("#warningPublication").length)
                    {
                        $("#warningPublication").remove();
                        changing = true;
                    }
                    if ($("#dateExpireRadio").prop("checked") && ($("#dateExpire").val() == '' || ($("#timeExpire").val() == '')))
                    {
                        if (!$("#warningExpire").length)
                            $("<p style=\"color:red;margin-top:0px;\" id=\"warningExpire\">Veuillez renseigner la date et l'heure d'expiration !</p>").insertAfter($("#timeExpire"));
                        changing = true;
                    }
                    if (($("#jamais").prop("checked") || (!$("#dateExpire").val() == '' && !$("#timeExpire").val() == '')) && $("#warningExpire").length)
                    {
                        $("#warningExpire").remove();
                        changing = true;
                    }
                    /*if ($("#datePublication").val() == '')
                    {
                        if (!$("#warningPublication").length)
                            $("<p style=\"color:red;margin-top:0px;\" id=\"warningPublication\">Veuillez renseigner la date de publication !</p>").insertAfter($("#datePublication"));
                        changing = true;
                    }
                    if ($("#datePublication").val() == '' && $("#warningPublication").length)
                    {
                        $("#warningPublication").remove();
                        changing = true;
                    }*/
                    return !changing;
                })
            }
            $(document).ready(function(){
                insertContent();
            });
        </script>
    </article>
