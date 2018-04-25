<?php
writeHeader("");
?>
<div class="container row">
    <div class="col s12 l6 offset-l3 z-depth-3" style="margin-top: 20px; padding: 0 50px 20px;">
        <h2 class="title">Log In</h2>
        <form id="logInForm" action="." method="post">
            <input type="hidden" name="action" value="log_in">
            <div class="row">
                <div class="input-field col s12">
                    <input type="email" name="email" id="email">
                    <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                    <input type="password" name="password" id="password">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="center-align">
                <a onclick="$('#logInForm').submit();" class="waves-effect waves-light btn-large blue lighten-1">Log In</a>
            </div>
        </form>
        <p>Don't have an account? <a href="./index.php?action=show_sign_up">Sign Up</a></p>
    </div>
</div>

<?php writeFooter() ?>