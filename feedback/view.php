<?php writeHeader() ?>

    <div class="container">
        <h3 class="title">Feedback</h3>
        <form action="." method="post">
            <div class="row">
            <input type="hidden" name="action" value="send">
                <div class="input-field col s12">
                    <input type="text" id="name" name="name">
                    <label for="name">Your Name</label>
                </div>
            </div>
        </form>
    </div>

    <script>

    </script>

<?php writeFooter() ?>