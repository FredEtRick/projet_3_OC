    <article class="col-xxl-6 col-xl-12 col-sm-12">
        <form id="getNewPostForm" method="post">
            <p>
                <textarea class="tinymce" id="tinymceNewPost"></textarea>
            </p>
            <p>
                Publier immédiatement ?<br />
                <input type="radio" name="publish" value="oui" id="oui" /><label for="oui"> oui</label><br />
                <input type="radio" name="publish" value="non" id="non" /><label for="non"> non, publier le :</label><br />
                <input type="datetime" name="datePublication" />
            </p>
            <p>
                <input type="submit" value="send" />
            </p>
        </form>
        <script type="text/javascript" src="../plugins/jquery.min.js"></script>
        <script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="../plugins/tinymce/init-tinymce.js"></script>
        <!--
            déplacer plus tard le script en bas de page et l'inclure (ici ou dans controler) en complétant la ligne suivante
            <script type="text/javascript" src="../plugins/"></script>
        -->
    </article>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $("#getNewPostForm").submit(function(e){
            var content = tinymce.get("tinymceNewPost").getContent();
            //$()
            console.log(content);
            return false;
        })
    });
</script>