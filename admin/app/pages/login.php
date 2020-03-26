<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />

    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-formhelpers.css">
    <link rel="stylesheet" href="css/stylesheet.css"/>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body class="app">
<div id='loader'>
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
<div class="peers ai-s fxw-nw h-100vh">
    <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r m-auto" style='min-width: 320px;'>
        <h4 class="fw-300 c-grey-900 mB-40">Admin Login</h4>

        <form action="ajax/login" method="POST" id="login_form" class="needs-validation not-valid"  novalidate>
            <fieldset>

                <div class="alert message" style="display: none"></div>
                <div class="form-group">
                    <label for="InputEmail1">Email address</label>
                    <input type="email" class="form-control" id="InputEmail1" placeholder="Enter email" name="user_email" required>
                    <div class="invalid-feedback">
                        Please enter an email.
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputPassword1">Password</label>
                    <input type="password" class="form-control" id="InputPassword1" placeholder="Password" name="user_password" required>
                    <div class="invalid-feedback">
                        Please enter a password.
                    </div>
                </div>

                <div class="form-check">

                    <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                        <input type="checkbox" class="custom-control-input" id="Check1" name="remember_me" value="1">
                        <label class="custom-control-label" for="Check1">Remember Me</label>
                    </div>

                </div>
                <br>

                <div class="form-group row captcha ml-auto <?php echo $auth->isBlocked()=="verify" ?  "" : "d-none" ?>">
                    <div class="g-recaptcha" data-sitekey="<?=$auth_config->recaptcha_site_key?>" ></div>
                </div>

                <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." class="btn btn-primary">Log In</button>

            </fieldset>
        </form>



    </div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/form-validator.js"></script>
<script>
    form_validate({
        do_before: function(){
            grecaptcha.reset();
        },
        do_error: function(){},
        do_success: function(data){
            if(data.captcha === "verify"){
                $(".captcha").removeClass("d-none");
            }else if(data.captcha === "allow"){
                $(".captcha").addClass("d-none");
            }
        },
        error_true: function(data){
            $(".alert.message").removeClass("alert-success").addClass("alert-danger").html(data.message).slideDown();
        },
        error_false: function (data) {
            $("form.needs-validation").addClass("alert alert-success").html(data.message).slideDown();
            location.reload();
        }
    });
</script>
</body>
</html>
