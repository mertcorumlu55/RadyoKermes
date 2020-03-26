<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Radyo Kermes</title>

    <link rel="shortcut icon" href="img/fav_icon.html" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/green-audio-player.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



</head>

<body>
        <div class="container text-center" style="margin-top:100px">
            <div class="text-center">

                <blockquote class="blockquote text-center">
                    <h1 class="mb-0 h1" style="color:whitesmoke">Radyo Kermes</h1>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Pala Remzi Kermes</cite>'in ışığında...</footer>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Deniz ve Bülent</cite>tarafından projelendirildi,</footer>
                    <footer class="blockquote-footer" style="color:whitesmoke"><cite title="Source Title">Teknik Servis Barzo</cite>tarafından geliştirildi.</footer>

                </blockquote>
                <br/>
                <br/>

                <div class="row player">
                    <div class="col-sm-12 d-flex">
                        <div class="albumImg">
                            <img src="" alt="" class="artwork"/>
                        </div>
                            <div class="ready-player-1">
                                <audio>
                                    <source src="http://radyokermes.com:8000/;" type="audio/mpeg">
                                </audio>
                            </div>
                    </div>

                    <!--
                    <div class="col-sm-2">
                        <a class="btn social spotify border border-white lg mr-1" target="_blank" href="">
                                    <span class="icon">
                                        <i class="fa fa-spotify"></i>
                                    </span>
                        </a>

                        <a class="btn social itunes border border-white lg ml-1" target="_blank" href="">
                                    <span class="icon">
                                        <i class="fa fa-apple"></i>
                                    </span>
                        </a>

                    </div>-->
                </div>

                <br/>


                <div class="col-12 chatbox p-0 mb-5" style="position: relative">
                    <div class="username_container">
                        <div class="username_inner">
                            <div class="username_inputs">
                                <form id="chat_user">
                                    <input type="text" name="chat-user" id="chat-user" placeholder="İsim" class="chat-input"  required/>
                                    <input type="submit" style="border-radius: 0; padding: 9.5px; margin: 0" class="btn btn-success" id="userName"  name="send-username" value="Başla">
                                </form>
                            </div>
                        </div>
                    </div>
                <form style="text-align: left;" name="frmChat" id="frmChat">
                    <div id="chat-box"></div>
                    <input type="text" name="chat-message" id="chat-message" placeholder="Mesaj"  class="chat-input chat-message" required/>
                    <input class="btn btn-success" type="submit" id="btnSend" style="margin: 0" name="send-chat-message" value="Gönder" >
                </form>

                </div>

            </div>
        </div>

</body>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="js/green-audio-player.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new GreenAudioPlayer('.ready-player-1', { showTooltips: true, showDownloadButton: false, enableKeystrokes: true });
    });

    reload_player_info();
    setInterval(reload_player_info,5000);

    function reload_player_info() {

        $.ajax({
            url: "test/get_info.php?json=1",
            success: function (data) {
                //$("span.controls__current-time").text();
                $("img.artwork").attr("src", data.album_img);
                $(".controls__current-time").text("");
                $("span.controls__current-time").append("<h5></h5>");
                $("span.controls__current-time").append("<h6></h6>");
                $(".controls__current-time h5").text(data.track);
                $(".controls__current-time h6").text(data.artist + ' (' + data.album + ')');
                $(".controls__progress").css("width","100%");
                /*$(".spotify").attr("href",data.spotify_url);
                $(".itunes").attr("href",data.itunes_url);*/


                $(".controls__total-time").text("");
                $(".controls__total-time").append("<h5></h5>");
                if(data.activeStreams >= 1){

                    $(".controls__total-time h5").text("ONLINE ");
                    $(".controls__total-time").append('<i class="fa fa-podcast text-danger blink_me"></i>');

                }else{

                    $(".controls__total-time h5").text("OFFLINE");
                }

            },
            error: function () {
                console.log(data);
            }
        });

    }

</script>
<script>
    function showMessage(messageHTML) {
        $('#chat-box').append(messageHTML);
    }

    $(document).ready(function(){

        if(typeof $.cookie('chat_username') === 'undefined'){

            $("#chat_user").on("submit",function (event) {
                event.preventDefault();
                $.cookie('chat_username', $("input[name=chat-user]").val()/*,{expires: 1}*/);
                $(".username_container").css("display","none");
                establish_connection();
            });

        }else {

            $("div.username_container").css("display","none");
            establish_connection();
        }
    });



function establish_connection(){
    var websocket = new WebSocket("ws://radyokermes.com:8090");

    websocket._original_send_func = websocket.send;
    websocket.send = function(data) {
        if(this.readyState === 1)
            this._original_send_func(data);
    }.bind(websocket);

    websocket.onopen = function() {
        websocket.send(JSON.stringify({
            data_type: "user_joined",
            chat_user: $.cookie('chat_username')
        }));
    };

    websocket.onmessage = function(event) {
        var Data = JSON.parse(event.data);
        showMessage("<div class='chat_message "+Data.message_type+"'>"+Data.message+"</div>");
        $('#chat-message').val('');
        $('#btnSend').blur();
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

    };

    websocket.onerror = function(){
        showMessage("<div class='error'>Bağlantı Kurulurken Bir Hata Oluştu</div>");
    };

    websocket.onclose = function(){
        showMessage("<div class='error'>Bağlantınız Kesildi</div>");
    };

    $('#frmChat').on("submit",function(event){
        event.preventDefault();
        var messageJSON = {
            data_type: "message",
            chat_user: $.cookie('chat_username'),
            chat_message: $('#chat-message').val()
        };
        websocket.send(JSON.stringify(messageJSON));
    });
}



</script>

</html>
