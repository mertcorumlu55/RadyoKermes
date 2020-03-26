<?php

/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */


?>
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">
            <!--                    <h4 class="c-grey-900 mT-10 mB-30">Data Tables</h4>-->
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">

                        <form action="/admin/ajax/settings-edit" method="POST" class="needs-validation not-valid"
                              autocomplete="off" novalidate>

                            <?php

                            try{

                                $query = $sql->prepare("SELECT * FROM `phpauth_config`");
                                $query->execute();
                                $content = array();
                                while($temp = $query->fetch(PDO::FETCH_ASSOC)){
                                    $content[$temp["setting"]] = $temp["value"];
                                }

                            }catch (PDOException $e){
                                echo '<div class="alert-danger">'.$e->errorInfo[2].'</div>';
                            }

                            ?>

                            <fieldset>

                                <h4 class="c-grey-900 mT-10 mB-30">Site Info</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>URL</strong></label>

                                    <div class="col-sm-4">
                                        <input type="url" class="form-control" name="site_url" value="<?=$content["site_url"]?>" required/>
                                        <small class="text-danger">Please don't change if you have no idea.</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Name</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="site_name" value="<?=$content["site_name"]?>" required/>
                                        <small>Name of site.</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Title</strong></label>

                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" name="site_title" value="<?=$content["site_title"]?>" required>
                                        <small>Title of site.</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Email</strong></label>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" name="site_email" value="<?=$content["site_email"]?>" required/>
                                        <small>Contact email of site.</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Reply Email</strong></label>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" name="site_reply_email" value="<?=$content["site_reply_email"]?>" required/>
                                        <small>Reply email of site.</small>
                                    </div>
                                </div>
                                <hr>

                                <h4 class="c-grey-900 mT-10 mB-30">Radio Server</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Server</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="radio_server" value="<?=$content["radio_server"]?>" required/>
                                        <small>Radyo Sunucusu Adresi</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Port</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="radio_port" value="<?=$content["radio_port"]?>" required/>
                                        <small>Radyo Sunucusu Portu</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password</strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name="radio_password" value="<?=$content["radio_password"]?>" required>
                                        <small>Radyo Sunucusu Admin Şifresi</small>
                                    </div>
                                </div>

                                <hr>

                                <h4 class="c-grey-900 mT-10 mB-30">IpGeoLocation API Key</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>API Key</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ipgeolocation_apikey" value="<?=$content["ipgeolocation_apikey"]?>" required/>
                                    </div>
                                </div>

                                <hr>

                                <h4 class="c-grey-900 mT-10 mB-30">SMTP</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>SMTP</strong></label>

                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                                            <input type="checkbox" class="custom-control-input" id="smtpStatus" name="smtp_status" value="1" <?=((bool) $content["smtp"] ? "checked" : "")?>>
                                            <label class="custom-control-label" style="margin-left:5%;" for="smtpStatus">SMTP on/off</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for=""  class="col-sm-2 col-form-label"><strong>Debug </strong></label>

                                    <div class="col-sm-4">
                                        <select id="selectDebug" class="form-control smtp" name="smtp_debug" required>
                                            <option disabled hidden>Please Select...</option>
                                            <option value="0" <?=((int) $content["smtp_debug"] == 0 ? "selected" : "")?>>0</option>
                                            <option value="1" <?=((int) $content["smtp_debug"] == 1 ? "selected" : "")?>>1</option>
                                            <option value="2" <?=((int) $content["smtp_debug"] == 2 ? "selected" : "")?>>2</option>
                                            <option value="3" <?=((int) $content["smtp_debug"] == 3 ? "selected" : "")?>>3</option>

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Debug Level.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Host</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control smtp" name="smtp_host" value="<?=$content["smtp_host"]?>" required>
                                        <small >SMTP Host</small>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for=""  class="col-sm-2 col-form-label"><strong>Port </strong></label>

                                    <div class="col-sm-4">
                                        <select id="selectPort" class="form-control smtp" name="smtp_port" required>
                                            <option disabled hidden>Please Select...</option>
                                            <option value="25" <?=((int) $content["smtp_port"] == 25 ? "selected" : "")?>>25</option>
                                            <option value="587" <?=((int) $content["smtp_port"] == 587 ? "selected" : "")?>>587</option>
                                            <option value="465" <?=((int) $content["smtp_port"] == 465 ? "selected" : "")?>>465</option>

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Port.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for=""  class="col-sm-2 col-form-label"><strong>Security </strong></label>

                                    <div class="col-sm-4">
                                        <select id="selectSecurity" class="form-control smtp" name="smtp_security" required>
                                            <option value="" disabled hidden>Please Select...</option>
                                            <option value="ssl" <?=((int) $content["smtp_security"] == "ssl" ? "selected" : "")?>>SSL</option>
                                            <option value="tls" <?=((int) $content["smtp_security"] == "tls" ? "selected" : "")?>>TLS</option>

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Security Type.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>SMTP Auth</strong></label>

                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                                            <input type="checkbox" class="custom-control-input smtp" id="smtpAuth" name="smtp_auth" value="1" <?=((bool) $content["smtp_auth"] ? "checked" : "")?>>
                                            <label class="custom-control-label" style="margin-left:5%;" for="smtpAuth">STMP Auth on/off</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Username</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control smtp-auth" name="smtp_username" value="<?=$content["smtp_username"]?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password</strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" class="form-control smtp-auth" name="smtp_password" value="<?=$content["smtp_password"]?>" required>
                                    </div>
                                </div>
                                <hr>

                                <h4 class="c-grey-900 mT-10 mB-30">Re-Captcha</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Re-Captcha</strong></label>

                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                                            <input type="checkbox" class="custom-control-input" id="captchaStatus" name="recaptcha_enabled" value="1" <?=((bool) $content["recaptcha_enabled"] ? "checked" : "")?>>
                                            <label class="custom-control-label" style="margin-left:5%;" for="captchaStatus">Re-Captcha on/off</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Site Key</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control captcha" name="recaptcha_site_key" value="<?=$content["recaptcha_site_key"]?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Secret Key</strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" class="form-control captcha" name="recaptcha_secret_key" value="<?=$content["recaptcha_secret_key"]?>" required>
                                    </div>
                                </div>
                                <hr>

                                <h4 class="c-grey-900 mT-10 mB-30">Facebook Api</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>App ID</strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control facebook" name="fb_app_id" value="<?=$content["fb_app_id"]?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>App Secret</strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" class="form-control facebook" name="fb_app_secret" value="<?=$content["fb_app_secret"]?>" required>
                                    </div>
                                </div>


                                <hr>
                                <div class="alert message"></div>
                                <button type="submit" class="btn btn-primary "
                                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing...">
                                    Submit
                                </button>

                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

    var csmtp = $("input[name=smtp_status]");
    var cauth = $("input[name=smtp_auth]");
    var smtp = $(".smtp");
    var auth = $(".smtp-auth");
    var captcha = $(".captcha");
    var captcha_check = $("input#captchaStatus");
    $(function () {


        check_smtp();
        check_capctha();

        csmtp.bind("change", function () {
            check_smtp();
        });

        cauth.bind("change", function () {

            if($(cauth).prop("checked")){
                auth.prop("disabled",false);
            }else{
                auth.prop("disabled",true);
            }

        });

        captcha_check.bind("change", function () {

            check_capctha();

        })



    });


    function check_smtp(){

        if($(csmtp).prop("checked")){

            smtp.prop("disabled",false);

            if($(cauth).prop("checked")){
                auth.prop("disabled",false);
            }

        }else{

            smtp.prop("disabled",true);
            auth.prop("disabled",true);

        }
    }

    function check_capctha() {

        if(captcha_check.prop("checked")){
            captcha.prop("disabled",false);
        }else{
            captcha.prop("disabled",true);
        }

    }


</script>

<script src="/admin/js/form-validator.js"></script>
<script>
    form_validate({
        do_before: function(){},
        do_error: function(){},
        do_success: function(){},
        error_true: function(data){
            $(".alert.message").removeClass("alert-success").addClass("alert-danger").html(data.message).slideDown();
        },
        error_false: function (data) {
            $(".alert.message").removeClass("alert-danger").addClass("alert-success").html(data.message).slideDown();
        }
    });
</script>


