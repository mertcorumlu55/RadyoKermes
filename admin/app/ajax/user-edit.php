<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:36
 */
include("../../../../inc/loader.php");
    if(parse_url(@$_SERVER["HTTP_REFERER"])["path"] != "/users/list"){
        http_response_code(400);
        include "../pages/404.php";
        exit;
    }

if (!$auth->isLogged()) {
    http_response_code(403);
    exit;
}

$userInfo = $auth->getCurrentUser();
if(!is_authorized($userInfo["authority"], array("Admin", "Moderator"))){
    http_response_code(403);
    exit;
}

    if($_POST){
        //DO SQL JOBS

        $return = array(
            "error" => true,
            "message" => ""
        );


        try {

            $sql->beginTransaction();

            $insertArray = array();

            $insertArray["full_name"] = post("user_full_name");
            $insertArray["email"] = post("user_email");
            $insertArray["telephone"] = post("user_telephone");
            $insertArray["authority"] = post("user_authority");
            $password = post("user_password");
            $sendPasswordMail = false;

           if(!empty($password)) {
               $insertArray["password"] = $auth->getHash($password);

               if (post("user_send_mail") == 1) {
                   $sendPasswordMail = 1;
               }

           }

            $return = $auth->updateUser(post("user_id"), $insertArray);

            //HANDLE UPDATE ERRORS
            if ($return["error"] == true) {
                $sql->rollback();
                return_error($return);
            }


            //SEND PASSWORD MAIL
            if ($sendPasswordMail) {

                $check = sendMail(
                    $auth_config,
                    post("user_email"),
                    post("user_full_name"),
                    $auth_config->password_mail_subject,
                    sprintf(
                        file_get_contents("../pages/static/PasswordMail.html"),
                        $auth_config->site_url,
                        $auth_config->site_url,
                        post("user_email"),
                        $password,
                        $auth_config->site_url,
                        $auth_config->site_reply_email,
                        $auth_config->site_reply_email

                    )

                );


                //IF MAIL NOT SENT
                if ($check["error"] == true) {
                    $sql->rollback();
                    $return = $check;
                    return_error($return);
                }

            }


            //NO ERROR HANDLED, SUCCESFULL
            $sql->commit();
            $return = array(
                "error" => false,
                "message" => $auth->__lang("edit_user_success")
            );
            return_error($return);


        } catch (PDOException $e) {
            $return["message"] = $e->errorInfo[2];
            $sql->rollBack();
            return_error($return);
        }


        exit;
    }

    /*
     * EDIT FORM STARTS HERE
     */

    if( empty(get("id")) ){
        http_response_code(400);
        exit;
    }

    $userID = get("id");

    try{

        $query = $sql->prepare("SELECT `id`, `full_name`, `email`, `telephone`, `authority`, `dt` FROM `phpauth_users` WHERE `phpauth_users`.`id` = '{$userID}' LIMIT 1");
        $query->execute();
        $content = $query->fetch(PDO::FETCH_ASSOC)
?>


        <div class="container-fluid" style="padding:0;">
            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <h4 class="c-grey-900 mT-10 mB-30">Edit User</h4>

                        <form id="user_edit_form" action="/ajax/user-edit" method="POST"  class="needs-validation" autocomplete="off" novalidate>

                            <fieldset>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>ID </strong></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" style="text-transform: " name="user_id" value="<?=$content["id"]?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Register Date </strong></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" style="text-transform: "  value="<?=date('d/m/Y H:i:s ',strtotime($content["dt"]))?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Name <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="user_full_name" style="text-transform: " placeholder="e.g. Alara Kaya" value="<?=$content["full_name"]?>" required>

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
                                            <option value="Admin" <?=($content["authority"]=="Admin" ? "selected" : "")?> >Admin</option>
                                            <option value="User" <?=($content["authority"]=="User" ? "selected" : "")?>>User</option>

                                        </select>

                                        <div class="invalid-feedback">
                                            Please select a Authority.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>E-Mail <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" name="user_email" style="text-transform: " placeholder="e.g. example@example.com" value="<?=$content["email"]?>" required>

                                        <div class="invalid-feedback">
                                            Please enter a valid email.
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Telephone <span class="text-danger">*</span></strong></label>

                                    <div class="col-sm-4">
                                        <input type="tel" class="form-control input-medium bfh-phone" data-format="ddd ddd dd dd"  placeholder="555 444 33 22" name="user_telephone" value="<?=$content["telephone"]?>" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid telephone.
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4>Change Users Password</h4>
                                <div class="form-group row">

                                    <label for="" class="col-sm-2 col-form-label"><strong>Password </strong></label>

                                    <div class="col-sm-4">
                                        <input type="password" id="password" class="form-control" name="user_password" style="text-transform: ">
                                        <small>If You Don't Set A Password,Users Password Will Not Be Changed</small>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox" style="padding-left: 0.3rem">
                                            <input type="checkbox" class="custom-control-input" id="sendMail" name="user_send_mail" value="1" disabled>
                                            <label class="custom-control-label" for="sendMail">Send User His/Her Password</label>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-sm-4 float-right">
                                        <div class="btn alert-danger" onclick="delete_user(<?=$content["id"]?>)" >Delete User</div>
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
        <script>
            function delete_user(id){
                var a = confirm("Are you sure you want to delete this user and all its information?");
                if(a){
                    $.ajax({
                        type: "POST",
                        url: "/ajax/user-delete",
                        data: {"user_id":id},
                        error:function () {
                            alert("An Error Occured.");
                        },

                        success: function (data) {
                            alert(data.message);
                            if(!data.error){
                                location.reload();
                            }
                        }
                    });
                }
            }


            $("#password").bind("change",function () {

                if( $(this).val() === "" ){
                    $("#sendMail").prop("checked",false)
                    $("#sendMail").prop("disabled",true);
                }else{
                    $("#sendMail").prop("disabled",false);
                }
            });

        </script>

        <script src="/js/form-validator.js"></script>
        <script>
            form_validate({
                do_before: function(){
                    $("#password").val("");
                },
                do_error: function(){},
                do_success: function(){},
                error_true: function(data){
                    $(".alert.message").removeClass("alert-success").addClass("alert-danger").html(data.message).slideDown();
                },
                error_false: function (data) {
                    $(".alert.message").removeClass("alert-danger").addClass("alert-success").html(data.message+"<br><a href='/users/list'>List Users</a>").slideDown();
                }
            });
        </script>

<?php

    }catch (PDOException $e){
        echo $e->errorInfo[2];
        http_response_code(503);
        exit;
    }
        ?>

