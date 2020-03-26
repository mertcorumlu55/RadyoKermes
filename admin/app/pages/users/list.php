<?php
/**
 * Created by PhpStorm.
 * User: MERT
 * Date: 10/05/2018
 * Time: 16:34
 */
?>

<!-- ### $App Screen Content ### -->
<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">




            <div class="row">

                <div class="col-md-12" style="padding:0;">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <style>
                            .DataTable tr,td{
                                vertical-align: middle;
                            }
                        </style>
                        <table class="DataTable table table-striped table-bordered dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                            <thead>

                            <tr>
                                <th>ID</th>
                                <th data-priority="1">Authority</th>
                                <th data-priority="2">Full Name</th>
                                <th>E-mail</th>
                                <th>Telephone</th>
                                <th>Register Date</th>
                                <th></th>

                            </tr>

                            </thead>
                            <tbody>

                            <?php

                            try{

                                $query = $sql->prepare("SELECT `id`, `full_name`, `email`, `telephone`, `authority`, `dt` FROM `phpauth_users` ");
                                $query->execute();
                                //$content = $query->fetch(PDO::FETCH_ASSOC);

                                while($content = $query->fetch(PDO::FETCH_ASSOC)){
                                
                                ?>
                                    <tr>
                                        <td><?=$content["id"]?></td>
                                        <td>
                                            <?php
                                            if($content["authority"] == "Admin"){
                                                ?>
                                                <button class="btn alert-success">Admin</button>
                                            <?php
                                            }else if($content["authority"] == "User"){
                                                ?>
                                                <button class="btn alert-warning">User</button>

                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?=$content["full_name"]?></td>
                                        <td><?=$content["email"]?></td>
                                        <td><?=$content["telephone"]?></td>
                                        <td><?=$content["dt"]?></td>
                                        <td><button class="btn btn-primary" onclick=" open_popup('/ajax/user-edit?id=<?=$content["id"]?>') ">Edit</button></td>
                                    </tr>
                                    
                                <?php
                                }
                            }catch(PDOException $e){
                                trigger_error($e->errorInfo[2],E_USER_WARNING);
                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
        </div>

        <script>
            $(document).ready( function () {
                $('.DataTable').DataTable({
                    "order":[[0,"asc"]]
                });
            } );
        </script>
        <script src="/app/js/jquery.fancybox.min.js"></script>
        <script src="/app/js/popup.js"></script>

    </div>
</main>


