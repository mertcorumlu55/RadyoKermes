<main class="main-content bgc-grey-100">
    <div id="snackbar"></div>
    <div id="mainContent">

        <div class="container-fluid" style="padding:0;">

    <div class="row gap-20 masonry pos-r">

        <!--SERVER INFO-->
        <div class="masonry-item w-100 server-info position-relative">
            <div class="loading d-none">
                <div class="loading-holder">
                    <i class="fa fa-circle-o-notch fa-spin "></i>
                </div>
            </div>
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
                                    <p class="text-center"><strong id="radio_server_status">-</strong></p>
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
                                    <p class="text-center"><strong id="listeners">-/512</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #ÇALAN ŞARKI ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Başlık</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="text-center"><strong id="song">-</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- #AUTODJ DURUMU ==================== -->
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">AutoDJ</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <p class="text-center"><strong id="autodj_status">-</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Radyo Konu-->
        <div class="masonry-item  w-100 radyo-konu" style="display: none">
            <div class="row gap-20">
                <!-- #RADIO ==================== -->
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Yayın: <span class="text-success">AÇIK</span></h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed pl-5 pr-5">
                                    <div class="holder m-auto pl-5 pr-5">
                                        <form class="form d-flex w-100" id="radyo_konu">
                                            <label for="radyo_konu_text" class="m-0">Yayın Başlığı</label><input type="text" class="form-control" id="radyo_konu_text" name="radyo_konu" placeholder="Konu" value="<?=$auth_config->radyo_konu?>" />
                                            <button type="submit" class="btn btn-primary ml-1" id="radyo_konu_button">Güncelle</button>
                                        </form>
                                    </div>
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
                <!-- #RADIO ==================== -->
                <div class='col-md-4'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Radyo Sunucusu</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <div class="holder m-auto" style="width: fit-content;">
                                        <button class="btn btn-success radio-server-button" id="radio_server_start">Başlat</i></button>
                                        <button class="btn btn-danger radio-server-button" id="radio_server_stop">Durdur</button>
                                        <button class="btn btn-warning radio-server-button" id="radio_server_restart">Yeniden Başlat</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- #AUTODJ ==================== -->
                <div class='col-md-4'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">AutoDJ</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <div class="holder m-auto" style="width: fit-content;">
                                                <button class="btn btn-success autodj-button" id="autodj_start">Başlat</button>
                                                <button class="btn btn-danger autodj-button" id="autodj_stop">Durdur</button>
                                                <button class="btn btn-warning autodj-button" id="autodj_restart">Yeniden Başlat</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <!-- #ChatServer ==================== -->
                <div class='col-md-4'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h6 class="lh-1">Chat Server</h6>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <div class="peer peer-greed">
                                    <div class="holder m-auto" style="width: fit-content;">
                                        <button class="btn btn-success chat-server-button" id="chat_server_start">Başlat</button>
                                        <button class="btn btn-danger chat-server-button" id="chat_server_stop">Durdur</button>
                                        <button class="btn btn-warning chat-server-button" id="chat_server_restart">Yeniden Başlat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--CHAT-->
        <div class="masonry-item col-12 listener-info position-relative">

            <!-- #Site Visits ==================== -->
            <div class="bd bgc-white">
                <div class="peers fxw-nw@lg+ ai-s">
                    <div class="peer peer-greed w-100p@lg+ w-100@lg- p-20">
                    <div class="chat-server-status p-10 border mb-2 mt-2" style="border-radius: 4px">Chat Server: <strong id="chat_server_status">-</strong></div>
                        <div class="col-12 chatbox p-0 mb-5" style="position: relative">


                            <div class="row">
                                <div class="col-9 pr-0">
                                    <div id="chat-box"></div>
                                </div>
                                <div class="col-3 pl-0">
                                    <div id="online-clients-box"></div>
                                </div>
                            </div>
                            <form style="text-align: left;" name="frmChat" id="frmChat">
                                <input type="text" name="chat-message" id="chat-message" placeholder="Mesaj"  class="chat-input chat-message" required/>
                                <input class="btn btn-success" type="submit" id="btnSend" style="margin: 0" name="send-chat-message" value="Gönder" >
                             </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--LISTENER INFO-->
        <div class="masonry-item col-12 listener-info position-relative">
            <div class="loading d-none">
                <div class="loading-holder">
                    <i class="fa fa-circle-o-notch fa-spin "></i>
                </div>
            </div>
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