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
                                <th>Post ID</th>
                                <th data-priority="1">Question Owner</th>
                                <th data-priority="2">Question</th>
                                <th>Answer</th>
                                <th>Answer Owner</th>
                                <th>Post Date</th>
                                <th>Answer Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>

                            <?php

                            try{

                                $query = $sql->prepare("SELECT
                                                                   `post_id`, `question`, `answer`, `status`, `post_date`, `answer_date`,
                                                                   `author`.`full_name` AS `author_name`,
                                                                   `user`.`full_name` AS `user_name`
                                                                FROM `posts`
                                                                LEFT JOIN `phpauth_users` as `user` on `posts`.`user_id` = `user`.`id`
                                                                LEFT JOIN `phpauth_users` as `author` on `posts`.`author_id` = `author`.`id` ");
                                $query->execute();
                                //$content = $query->fetch(PDO::FETCH_ASSOC);

                                while($content = $query->fetch(PDO::FETCH_ASSOC)){
                                
                                ?>
                                    <tr>
                                        <td><?=$content["post_id"]?></td>
                                        <td><?=$content["user_name"]?></td>
                                        <td><?=$content["question"]?></td>
                                        <td><?=$content["answer"]?></td>
                                        <td><?=$content["author_name"]?></td>
                                        <td><?=(empty($content["post_date"]) ? "" : date('d/m/Y H:i:s ',strtotime($content["post_date"])))?></td>
                                        <td><?=(empty($content["answer_date"]) ? "" : date('d/m/Y H:i:s ',strtotime($content["answer_date"])))?></td>
                                        <td>
                                            <?php
                                            if($content["status"] == "pending"){
                                                ?>
                                                <button class="btn alert-warning" onclick=" open_popup('/ajax/post-answer?post_id=<?=$content["post_id"]?>') ">Pending: Answer</button>
                                                <?php
                                            }else if($content["status"] == "closed"){
                                                ?>
                                                <button class="btn alert-danger">Closed</button>

                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><button class="btn btn-primary" onclick=" open_popup('/ajax/post-edit?post_id=<?=$content["post_id"]?>') ">Edit</button></td>
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
                    "order":[[0,"asc"]],
                    columnDefs: [ {
                        targets: [2,3],
                        render: $.fn.dataTable.render.ellipsis( 60 )
                    } ]
                });
            } );
        </script>
        <script src="/app/js/jquery.fancybox.min.js"></script>
        <script src="/app/js/popup.js"></script>

    </div>
</main>


