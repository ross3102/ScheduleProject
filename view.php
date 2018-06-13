<?php
writeHeader("");
?>
<div class="container row">
    <div class="col s12 offset-s0 l6 offset-l3 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Log In</h2>
        <div class="row">
            <div class="input-field col s12">
                <input placeholder="" type="text" name="username" id="username">
                <label for="username">Username or Email</label>
            </div>
            <div class="input-field col s12">
                <input placeholder="" type="password" name="password" id="password">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="center-align">
            <a onclick="logIn()" class="waves-effect waves-light btn-large blue lighten-1">Log In</a>
        </div>
        <p>Don't have an account? <a href="./index.php?action=show_sign_up">Sign Up</a></p>
    </div>
</div>

    <script>
        function logIn() {
            username = $("#username").val();
            password = $("#password").val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "./index.php",
                data: "action=log_in&username=" + username + "&password=" + password,
                complete: function(data) {
                    var json = JSON.parse(JSON.stringify(data));
                    var loc = json["responseJSON"]["location"];
                    if (loc != null)
                        location.href = loc;
                    else {
                        var message = json["responseJSON"]["message"];
                        Materialize.toast(message, 3000);
                    }
                }
            });
        }
    </script>

<?php writeFooter() ?>