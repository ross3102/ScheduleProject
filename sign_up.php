<?php
writeHeader("");
?>
<div class="container row">
    <div class="col s12 m8 offset-m2 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Sign Up</h2>
        <form id="signUpForm" action="." method="post">
            <input type="hidden" name="action" value="sign_up">
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" name="user_name" id="user_name">
                    <label for="user_name">User Name</label>
                </div>
                <div class="input-field col s6">
                    <input type="password" name="password" id="password">
                    <label for="password">Password</label>
                </div>
                <div class="input-field col s6">
                    <input type="password" name="confirm" id="confirm">
                    <label for="confirm">Confirm Password</label>
                </div>
                <div class="input-field col s12">
                    <input type="email" name="email" id="email">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="center-align">
                <a onclick="$('#signUpForm').submit();" class="waves-effect waves-light btn-large blue lighten-1">Sign Up</a>
            </div>
        </form>
        <p>Already have an account? <a href="./index.php?action=show_log_in">Log In</a></p>
    </div>
</div>

<?php writeFooter() ?>