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
                            <h4 class="c-grey-900 mT-10 mB-30">Add New User</h4>

                            <form id="user_ad_form" action="/admin/ajax/user-add" method="POST"  class="needs-validation not-valid" autocomplete="off" novalidate>

                                <fieldset>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="user_full_name" style="text-transform: " placeholder="e.g. Alara Kaya" required>

                                        <small>Full Name</small>
                                        <div class="invalid-feedback">
                                            Please enter a valid name.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for=""  class="col-sm-2 col-form-label"><strong>Authority <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <select id="selectStatue" class="form-control" name="user_authority" required>
                                            <option value="" disabled hidden>Please Select...</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Authority.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" id="password" class="form-control" name="user_password" style="text-transform: " required>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                                            <input type="checkbox" class="custom-control-input" id="sendMail" name="user_send_mail" value="1" disabled>
                                            <label class="custom-control-label" for="sendMail">Send User His/Her Password</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>E-Mail <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" name="user_email" style="text-transform: " placeholder="e.g. example@example.com" required>

                                        <div class="invalid-feedback">
                                            Please enter a valid email.
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="alert message"></div>
                                <button type="submit" class="btn btn-primary " data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing..." >Submit</button>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                $("form.needs-validation").html("<div class=\"alert alert-success\" >"+data.message+"<br><a href='/users/list'>List Users</a></div>").slideDown();
            }
        });


        $("#password").bind("change",function () {
            var sendMail = $("#sendMail");

            if( $(this).val() === "" ){
                sendMail.prop("checked",false)
                sendMail.prop("disabled",true);
            }else{
                sendMail.prop("disabled",false);
            }
        });

    </script>


