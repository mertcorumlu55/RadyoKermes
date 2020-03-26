<main class="main-content bgc-grey-100">
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">

    <div class="row gap-20 masonry pos-r">

        <div class="masonry-item  w-100">
            <div class="row gap-20">
                <!-- #Toatl Visits ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Moderators</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong></strong></p>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm"></span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-deep-purple-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Total Page Views ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Advisors</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong></strong></p>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm"></span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-green-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Unique Visitors ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Chairs</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong></strong></p>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm">%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-light-blue-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #Bounce Rate ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Delegates</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong></strong></p>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm">%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-blue-gray-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->

            <div class="bd bgc-white">
                <div class="fxw-nw@lg+ ">
                    <div class="peer peer-greed p-20">

                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Your Pending Files</h6>
                            </div>

                            <div class="layer w-100">
                                <div class="row">

                                    <?php
                                    /*
                                    if($files->rowCount() < 1){
                                        ?>
                                        <div class="alert alert-warning">You Have No Pending Files</div>
                                        <?php
                                    }else {

                                        ?>
                                        <table id="files" class="DataTable chair-table table dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">
                                            <thead>
                                            <tr>
                                                <th >Unique ID</th>
                                                <th data-priority="1">File Name</th>
                                                <th >Submitted By</th>
                                                <th >Country</th>
                                                <th data-priority="2">Status</th>
                                                <th data-priority="3"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            while ($data = $files->fetch(PDO::FETCH_ASSOC)) {


                                                ?>

                                                <tr>
                                                    <td><strong><?= $data["unq_id"] ?></strong></td>
                                                    <td>
                                                        <i class="fa
                                            <?php
                                                        switch ($data["file_type"]) {
                                                            case "application/pdf":
                                                                echo "fa-file-pdf-o";
                                                                break;

                                                            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                                                            case "application/msword":
                                                                echo "fa-file-word-o";
                                                                break;
                                                        }
                                                        ?>
                                            "></i>

                                                        <a href="/get_file?id=<?= $data["file_id"] ?>"><?= $data["file_name"] ?></a>

                                                    </td>
                                                    <td>
                                                        <strong>

                                                            (<?php
                                                            switch ($data["auth"]) {

                                                                case 0;
                                                                    echo '<span class="text-secondary">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 1;
                                                                    echo '<span class="text-danger">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 2;
                                                                    echo '<span class="text-success">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 3;
                                                                    echo '<span class="text-warning">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;

                                                                case 4;
                                                                    echo '<span class="text-primary">' . $Auth_Statues[$data["auth"]] . '</span>';
                                                                    break;


                                                            }
                                                            ?>)
                                                        </strong>
                                                        <?= $data["name"] . " " . $data["surname"] ?></td>
                                                    <td>
                                                        <div
                                                            class=" <?= $data["flag"] != "" ? "flag flag-" . strtolower($data["flag"]) : "" ?>"
                                                            style="vertical-align: middle"></div> <?= $data["country_name"] ?>
                                                    </td>
                                                    <td><?= $file_status_button[$data["status"]] ?>
                                                        <?= ($data["is_reso"] == "1" ? "<i class=\"fa fa-star text-warning ambassador\" data-toggle=\"tooltip\" title=\"Plenary Session Resolution\" ></i>" : "") ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary"
                                                                onclick="location.replace('/files/list')">Go To Files
                                                        </button>
                                                    </td>

                                                </tr>

                                                <?php
                                            }


                                            ?>


                                            </tbody>
                                        </table>
                                        <?php
                                    }
*/
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Next Session</h6>
                            </div>
                            <div class="layer w-100">
                                <div id="world-map-marker">


                                        <table id="sessions" class="DataTable chair-table table  dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">

                                            <thead>
                                            <tr>
                                                <th data-priority="1">Session Name</th>
                                                <th >Session Start</th>
                                                <th>Session End</th>
                                                <th data-priority="2"></th>
                                            </tr>
                                            </thead>
                                            <tbody>








                                            </tbody>
                                        </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="peers fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Statistics</h6>
                            </div>
                        </div>
                        <div class="layers">
                            <div class="layer w-100">
                                <!-- Progress Bars -->
                                <div class="layers" style="padding:0 30px 0 30px">
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Session Attendance Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm">%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-light-blue-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Ambassador Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm"></span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-blue-gray-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="layer w-100">
                                        <small class="fw-600 c-grey-700">Files Approved Percentage</small>
                                        <span class="pull-right c-grey-600 fsz-sm">%</span>
                                        <div class="progress mT-10">
                                            <div class="progress-bar bgc-green-500" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:%;"> <span class="sr-only">50% Complete</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
        </div>
    </div>
</main>

    <script>
        $(document).ready( function () {
            $('#files').DataTable({
                "bPaginate": false,
                bFilter: false,
                bInfo: false,
                responsive: true

            });
            $('#sessions').DataTable({
                "bPaginate": false,
                bFilter: false,
                bInfo: false,
                responsive: true

            });
        } );

        $("div.counter").each(function (index,data) {
            var time = $(this).data("seconds");
            var object = $(this);
            object.find("strong").html(time_to_string(time) + "Left" );
            setInterval(function () {
                if(time === 0){
                    location.reload();
                    return;
                }
                time--;
                object.find("strong").html(time_to_string(time) + "Left");
            },1000);

        });

        function time_to_string(time){
            var string="";
            var minutes = number_format(Math.floor((time % 3600) / 60));
            if(minutes > 0){
                string += minutes+ " Minute "
            }
            var seconds = number_format(Math.floor((time % 60)));
            string += seconds+ " Second ";
            return string;
        }

        function number_format(n){
            return n > 9 ? "" + n: "0" + n;
        }

    </script>


