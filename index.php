<?php include("inc/loader.php");?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title><?=$auth_config->site_title?></title>

    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/green-audio-player.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
        <div class="container text-center page-container">
            <div class="text-center">

                <blockquote class="blockquote text-center">
                    <h1 class="mb-0 h1" style="color:whitesmoke">Radyo Kermes</h1>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Pala Remzi Kermes</cite>'in ışığında...</footer>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Deniz ve Bülent</cite> tarafından projelendirildi,</footer>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Teknik Servis Barzo</cite> tarafından geliştirildi.</footer>

                </blockquote>
                <br/>

                <div class="row player">
                    <div class="col-sm-12 d-flex">
                        <div class="albumImg d-none">
                            <img src="" alt="" class="artwork"/>
                        </div>
                            <div class="radio-player">
                                <audio>
                                    <source src="http://<?=$auth_config->radio_server?>:<?=$auth_config->radio_port?>/live" type="audio/mp3">
                                </audio>
                            </div>
                    </div>

                </div>

                <br/>


                <div class="col-12 chatbox p-0 mb-3" style="position: relative">
                    <div class="file-dragover d-none">
                        <div class="file-dragover-inner">
                            <i class="fa fa-cloud-upload"></i>
                            <p>Resmi Yüklemek İçin Sürükleyip Bırakın</p>
                        </div>
                    </div>
                    <div class="username_container">
                        <div class="username_inner">
                            <div class="username_inputs">
                                <form id="chat_user">
                                    <label for="chat-user"></label><input type="text" name="chat-user" id="chat-user" placeholder="İsim" class="chat-input" required/>
                                    <input type="submit" style="border-radius: 0; padding: 9.5px; margin: 0" class="btn btn-success" id="userName"  name="send-username" value="Başla">
                                </form>
                            </div>
                        </div>
                    </div>

                <form style="text-align: left;" name="frmChat" id="frmChat">
                    <div class="row">
                        <div class="col-8 pr-0">
                            <div id="chat-box"></div>
                        </div>
                        <div class="col-4 pl-0">
                            <div id="online-clients-box"></div>
                        </div>
                    </div>
                    <div class="images-to-send d-none">

                    </div>
                    <label class="chat-input" for="chat-message">
                        <input type="text" name="chat-message" id="chat-message" placeholder="Mesaj" class="chat-input chat-message" />
                        <span class="file-wrapper">
                          <input type="file" id="file_image" name="image" accept=".jpg,.png,.jpeg" multiple/>
                          <span class="button fa fa-image"> </span>
                        </span>
                    </label>
                    <input class="btn btn-success" type="submit" id="btnSend" style="margin: 0" name="send-chat-message" value="Gönder" >
                </form>

                </div>

            </div>
        </div>

</body>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="js/green-audio-player.js"></script>
<script src="js/ws.js"></script>
<script src="js/chat.js"></script>

<script>
    $(document).ready(function () {
        new GreenAudioPlayer('.radio-player', { showTooltips: true, showDownloadButton: false, enableKeystrokes: true, autoplay:true });
        reload_player_info();
        window.setInterval(reload_player_info,1000*10 /*SANIYE*/);
    });

    function reload_player_info() {

        $.ajax({
            url: "admin/ajax/get-info?json=1",
            success: function (data) {
                $(".controls__current-time").text("");
                $("span.controls__current-time").append("<h5></h5>");
                $(".controls__progress").css("width","100%");
                $(".controls__total-time").text("");
                $(".controls__total-time").append("<h5></h5>");

                if(data.online){
                    $("div.albumImg").addClass("d-none");
                    $(".controls__total-time h5").text("ONLINE ");
                    $(".controls__current-time h5").text(data.title);
                    $(".controls__total-time").append('<i class="fa fa-podcast text-danger blink_me"></i>');
                }else{
                    $("div.albumImg").removeClass("d-none");
                    $("img.artwork").attr("src", data.album_img);
                    $("span.controls__current-time").append("<h6></h6>");
                    $(".controls__current-time h5").text(data.track);
                    $(".controls__current-time h6").text(data.artist + ' (' + data.album + ')');
                    $(".controls__total-time h5").text("OFFLINE");
                }

            },
            error: function () {
                console.error("Radyo bilgileri getirilirken bir hata oluştu");
            }
        });

    }

</script>

</html>
