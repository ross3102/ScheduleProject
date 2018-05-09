<?php
writeHeader("");
?>
<div class="container row">
    <div class="col s12 l8 offset-l2 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Sign Up</h2>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="text" name="first_name" id="first_name" required>
                <label for="first_name">First Name</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="text" name="last_name" id="last_name" required>
                <label for="last_name">Last Name</label>
            </div>
            <div class="input-field col s12">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-field col s12 m6">
                <input type="password" name="confirm" id="confirm" required>
                <label for="confirm">Confirm Password</label>
            </div>
        </div>
        <div class="center-align">
            <a onclick="signUp()" class="waves-effect waves-light btn-large blue lighten-1">Sign Up</a>
        </div>
        <p>Already have an account? <a href="./index.php?action=show_log_in">Log In</a></p>
    </div>
</div>

    <script>
        function signUp() {
            username = $("#username").val();
            first_name = $("#first_name").val();
            last_name = $("#last_name").val();
            email = $("#email").val();
            password = $("#password").val();
            confrm = $("#confirm").val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "./index.php",
                data: "action=sign_up&username=" + username + "&first_name=" + first_name + "&last_name=" + last_name + "&email=" + email + "&password=" + password + "&confirm=" + confrm,
                complete: function(data) {
                    var json = JSON.parse(JSON.stringify(data));
                    // var loc = json["responseJSON"]["location"];
                    // if (loc != null)
                    //     location.href = loc;
                    // else {
                        var message = json["responseJSON"]["message"];
                        Materialize.toast(message, 3000);
                    // }
                }
            });
        }
    </script>

<?php writeFooter() ?>