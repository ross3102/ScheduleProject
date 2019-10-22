<?php
writeHeader("");
?>
<div class="container">
    <div class="col s12 l6 offset-l3 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Log In</h2>
        <form class="row" onsubmit="event.preventDefault(); logIn()">
            <div class="input-field col s12">
                <input placeholder="" type="text" name="username" id="username">
                <label for="username">Username or Email</label>
            </div>
            <div class="input-field col s12">
                <input placeholder="" type="password" name="password" id="password">
                <label for="password">Password</label>
            </div>
            <div class="center-align">
                <button type="submit" class="waves-effect waves-light btn-large blue lighten-1">Log In</button>
            </div>
        </form>
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
                        M.toast({html: message});
                    }
                }
            });
        }
    </script>

<?php writeFooter() ?>