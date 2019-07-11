<?php
writeHeader("");
?>
    <div class="container row">
        <div class="col s12 l6 offset-l3 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
            <h2 class="title">Resend Verification</h2>
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" name="email" id="email">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="center-align">
                <a onclick="resend()" class="waves-effect waves-light btn-large blue lighten-1">Resend</a>
            </div>
            <p>Received the email? <a href="./index.php?action=show_activate">Activate</a></p>
            <p>Already have an activated account? <a href="../index.php">Log In</a></p>
        </div>
    </div>

    <script>

        function resend() {
            email = $("#email").val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "./index.php",
                data: "action=resend&email=" + email,
                complete: function(data) {
                    var json = JSON.parse(JSON.stringify(data));
                    var message = json["responseJSON"]["message"];
                    M.toast({html: message});
                }
            });
        }

    </script>

<?php writeFooter() ?>