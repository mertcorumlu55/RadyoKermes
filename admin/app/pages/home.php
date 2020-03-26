<main class="main-content bgc-grey-100">
    <div class="alert alert-success" id="snackbar">Some text some message..</div>
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">

    <div class="row gap-20 masonry pos-r">

        <!--SERVER INFO-->
        <div class="masonry-item  w-100">
            <div class="row gap-20">
                <!-- #SUNUCU DURUMU ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Sunucu Durumu</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong class="text-success">ONLINE</strong></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- #ANLIK DİNLEYİCİ ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Anlık Dinleyici</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong id="listeners">-/512</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #ÇALAN ŞARKI ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Çalan Şarkı</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong id="song">-</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #AUTODJ DURUMU ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">AutoDJ(TEST AŞAMASINDA)</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="alert text-center"><strong>ON</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--SERVER ACTIONS-->
        <div class="masonry-item  w-100">
            <div class="row gap-20">
                <!-- #SUNUCU ==================== -->
                <div class='col-md-6'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">SUNUCU (TEST AŞAMASINDA)</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <div class="holder m-auto" style="width: fit-content;">
                                        <button class="btn btn-success server-button" id="server_start">Sunucuyu Başlat</button>
                                        <button class="btn btn-danger" id="server_stop">Sunucuyu Durdur</button>
                                        <button class="btn btn-warning" id="server_restart">Sunucuyu Yeniden Başlat</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- #AUTODJ ==================== -->
                <div class='col-md-6'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">AUTODJ (TEST AŞAMASINDA)</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <div class="holder m-auto" style="width: fit-content;">
                                                <button class="btn btn-success">AutoDJ Başlat</button>
                                                <button class="btn btn-danger">AutoDJ Durdur</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            </div>
        </div>

        <!--LISTENER INFO-->
        <div class="masonry-item col-12">
            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="peers fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed w-60p@lg+ w-100@lg- p-20">
                        <div class="layers">
                            <div class="layer w-100 mB-10">
                                <h6 class="lh-1">Dinleyiciler</h6>
                            </div>
                            <div class="layer w-100">
                                <div id="world-map-marker" style="width: 100%; height: 500px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="peer bdL p-20 w-40p@lg+ w-100p@lg-">
                        <div class="layers">
                            <table id="peers" class="DataTable table  dataTable no-footer display responsive no-wrap" cellspacing="0" cellpadding="0">

                                <thead>
                                <tr>
                                    <th data-priority="3">Ülke</th>
                                    <th data-priority="1">IP</th>
                                    <th data-priority="2">Browser</th>
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
    </div>
</main>
<script src="/admin/app/js/jquery-jvectormap-2.0.5.min.js"></script>
<script src="/admin/app/js/jquery-jvectormap-world-merc.js"></script>
<script>

        $(document).ready( function () {
            var dataTable = $('#peers').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "searching": false,
                pageLength: 9
            });

            $('#world-map-marker').vectorMap({
                map: 'world_merc',
                backgroundColor:"#fff",
                borderColor:"#fff",
                borderOpacity:.25,
                borderWidth:0,
                color:"#e6e6e6",
                regionStyle:{initial:{fill:"#e4ecef"}},
                markerStyle:{
                    initial:{
                        r:4,
                        fill:"#fff",
                        "fill-opacity":1,
                        stroke:"#000",
                        "stroke-width":2,
                        "stroke-opacity":.4
                    }},
                series:{regions:[{values:{TR:120},scale:["#9c27b0","#a741b0"]}]},
                normalizeFunction:"polynomial",
                hoverOpacity:null,
                zoomOnScroll:!1,
                scaleColors:["#b6d6ff","#005ace"],
                selectedColor:"#dc53df",
                enableZoom:!1,
                hoverColor:"#fff"
            });
            var mapObj = $('#world-map-marker').vectorMap('get', 'mapObject');
            mapObj.setFocus({scale: 8, region:"TR", animate: true});

            get_radio_data(dataTable,mapObj);
            setInterval(function () {
                get_radio_data(dataTable,mapObj);
            },10000);


            $("button.server-button").on("click",function (e) {
                e.preventDefault();
                snackbar_toggle();
            });


        });

        function get_radio_data(dataTable,mapObj){


            $.ajax({
                url: "/admin/ajax/get_info?json=1",
                success:function (data) {
                    $("#listeners").text(data.listeners + "/512");
                    $("#song").text(data.track);

                }

                });

        $.ajax({
            url: "/admin/ajax/listener-information",
            success:function (data) {
                var markers = [];
                dataTable.clear();
                $.each(data,function(key,ipinfo){
                    markers.push({ latLng: [ipinfo.latitude, ipinfo.longitude], name: ipinfo.ip+" | "+ ipinfo.useragent });
                    dataTable.row.add([ipinfo.country,ipinfo.ip,ipinfo.useragent]);
                });

                mapObj.addMarkers(markers,[]);
                dataTable.draw();}
        });

        }


    </script>


