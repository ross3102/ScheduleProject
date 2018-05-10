<?php
writeHeader("");
?>
<div class="container row">
    <div class="col s12 l6 offset-l3 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Activate Acount</h2>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="key" id="key">
                <label for="key">Enter the key sent to your email</label>
            </div>
        </div>
        <div class="center-align">
            <a onclick="activate()" class="waves-effect waves-light btn-large blue lighten-1">Activate</a>
        </div>
        <p>Already have an activated account? <a href="../index.php">Log In</a></p>
    </div>
</div>

    <script>

        function activate() {
            key = $("#key").val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "./index.php",
                data: "action=activate&key=" + key,
                complete: function(data) {
                    var json = JSON.parse(JSON.stringify(data));
                    var message = json["responseJSON"]["message"];
                    Materialize.toast(message, 3000);
                }
            });
        }

    </script>

<?php writeFooter() ?>