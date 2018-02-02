    <article class="col-xxl-6 col-xl-12 col-sm-12">
        <form id="getNewPostForm" method="post">
            <p>
                <label for="newPostTitle">
                    * titre : 
                </label>
                <input type="text" name="newPostTitle" id="newPostTitle" />
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
                <input type="radio" name="publish" value="oui" id="oui" checked required />
                <label for="oui">
                    oui
                </label><br />
                <input type="radio" name="publish" value="non" id="non" required />
                <label for="non">
                    non, publier le :
                </label><br />
                <input type="date" name="datePublication" id="datePublication" />
                <input type="time" name="timePublication" id="timePublication" />
            </p>
            <p>
                Doit expirer...<br />
                <input type="radio" name="expire" value="jamais" id="jamais" checked required />
                <label for="jamais">
                    jamais
                </label><br />
                <input type="radio" name="expire" value="dateExpire" id="dateExpireRadio" required />
                <label for="dateExpireRadio">
                    non, publier le :
                </label><br />
                <input type="date" name="dateExpire" id="dateExpire" />
                <input type="time" name="timeExpire" id="timeExpire" />
            </p>
            <p>
                <input type="submit" value="send" />
            </p>
            <p>
                * : champs obligatoires
            </p>
        </form>
        <script type="text/javascript" src="../plugins/jquery.min.js"></script>
        <script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="../plugins/tinymce/init-tinymce.js"></script>
    </article>
</section>
<script type="text/javascript">
    $(document).ready(function(){
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
    });
</script>