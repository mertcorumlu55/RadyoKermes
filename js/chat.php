<?php
header("Content-Type: text/javascript");
include "../inc/loader.php";
$logged = $auth->isLogged();
?>
var message_send_input = $('#chat-message');
var chat_box = $('#chat-box');
var clients_box = $("#online-clients-box");

$(function () {
	$('#frmChat').on("submit",function(event){
		event.preventDefault();
		ws.send("chat_message",{msg: message_send_input.val()});
		message_send_input.val('');
	});

    connect_chatserver();
    <?php

    if($logged){
        ?>
        $(document).on('click','.delete-message', function(){
        $(this).prop("disabled",true);
        $(this).append("<i class='fa fa-circle-o-notch fa-spin ml-1'></i>");
        ws.send("message_delete",{id: $(this).attr("id")});
        });

        $(document).on('click','.ban-user', function(e){
        e.preventDefault();
        ban_user_popup($(this).data("ip"), $(this).attr("id"));
        });

        $(document).on('click','.ban-user-in-popup', function(e){
        e.preventDefault();
        $(this).prop("disabled",true);
        $(this).append("<i class='fa fa-circle-o-notch fa-spin ml-1'></i>");
        ws.send("ban_user",{ip: $(this).data("ip"),time: $("#ban-time").val(), resource_id: $(this).data("id") });
        });
        <?php
    }
    ?>
});

function scroll_bottom(){
        chat_box.scrollTop(chat_box[0].scrollHeight);
}

function add_chat_message(name,color,msg,id){
    <?php

    if($logged){
        ?>
        chat_box.append('<div class="chat-box-message" id="'+id+'"><div class="chat-box-message-user" style="color:'+color+';">'+name+'</div><div class="chat-box-message-text">'+msg+'</div><button class="btn btn-danger delete-message" id="'+id+'">Sil</button></div>');
    <?php
    }else{
        ?>
        chat_box.append('<div class="chat-box-message" id="'+id+'"><div class="chat-box-message-user" style="color:'+color+';">'+name+'</div><div class="chat-box-message-text">'+msg+'</div></div>');
    <?php
    }
    ?>
}

function add_user(<?=($logged)? "admin," : ""?>name, color<?=($logged)? ",ip, id": " "?>){
    <?php

    if($logged){
        ?>
        if(admin){
        clients_box.append("<div class='online-client' style='color:"+color+";'>"+name+"</div>");
        }else{
        clients_box.append("<div class='online-client' style='color:"+color+";'>"+name+'<a class="text-danger ban-user ml-2" data-ip="'+ip+'" id="'+id+'">(Ban)</a></div>');
        }
        <?php
    }else{
        ?>
        clients_box.append("<div class='online-client' style='color:"+color+";'>"+name+"</div>");
        <?php
    }
    ?>
        }

    <?php

    if($logged){
    ?>
function ban_user_popup(ip,id){
    $.fancybox.defaults.touch = false;
    $.fancybox.defaults.smallBtn = true;
    $.fancybox.open("<div><div style='width: fit-content; margin:auto'><select class='form-control float-left w-auto' id='ban-time'>\n" +
    "    <option value=\"1\">Banı Kaldır</option>\n" +
    "    <option value=\"300\">5 Dakika</option>\n" +
    "    <option value=\"900\">15 Dakika</option>\n" +
    "    <option value=\"1800\">30 Dakika</option>\n" +
    "    <option value=\"3600\">1 Saat</option>\n" +
    "    <option value=\"0\">Sınırsız</option>\n" +
        '    </select><button class="btn btn-danger float-left ban-user-in-popup ml-2" data-ip="'+ip+'" data-id="'+id+'">Banla</button></div></div>');
}
        <?php
    }
    ?>

var reconnect_counter = 0;
var clearBan;
function connect_chatserver(){
	window.ws = $.websocket("ws://<?=$auth_config->chat_server?>", {
		open: function() {
                reconnect_counter = 0;
                <?php
                if($logged){

                ?>
                chat_box.html("");
                    <?php
                }
                ?>
                chat_box.append('<div class="chat-message text-success font-weight-bold">Bağlantı sağlandı.</div>');
            <?php
            if($logged){

                ?>
                $(".username_container").css("display","none");
                ws.send("register", {"name": "(Admin) <?=$auth->getCurrentUser()["full_name"]?>", "color": "red", session_hash: "<?=$_COOKIE["radyo_kermes_session"]?>" });
                <?php
            }else{
                ?>
                if(typeof $.cookie('chat_username') === 'undefined'){
                $("#chat_user").on("submit",function (event) {
                event.preventDefault();
                $.cookie('chat_username', $("input[name=chat-user]").val());
                $(".username_container").css("display","none");
                ws.send("register", {"name": $.cookie('chat_username')});
                });
                }else {
                $("div.username_container").css("display","none");
                ws.send("register", {"name": $.cookie('chat_username')});
                }
            <?php
            }

        if($logged){
            ?>
            ws.send("fetch");
            <?php
        }
        ?>
		},
		close: function() {
            clients_box.html("");
            if(reconnect_counter == 10){
            chat_box.append('<div class="chat-message text-danger font-weight-bold">Sunucu ile bağlantı sağlanamadı.</div>');
            scroll_bottom();
            return;
            }
            chat_box.append('<div class="chat-message text-danger font-weight-bold">Sunucu ile bağlantı kesildi. Yeniden Deneniyor...</div>');
            scroll_bottom();
            setTimeout(function(){connect_chatserver();},5000);
            reconnect_counter++;
		},
		events: {
            <?php
            if($logged){
                ?>
                fetch: function(e) {
                $.each(e.data, function(i, elem){
                add_chat_message(elem.name, elem.color, elem.msg, elem.uniqid);
                });
                scroll_bottom();
                },
                message_delete_error: function(e){
                alert(e.data.message);
                },
                ban_user_success: function(e){
                $.fancybox.close();
                },
                ban_user_error: function(e){
                $.fancybox.close();
                alert(e.data.message);
                },
                <?php
            }
            ?>
            message_delete: function(e){
            $("div.chat-box-message[id="+e.data.id+"]").remove()
            },
			onliners: function(e){
				clients_box.html("");
				$.each(e.data, function(i, elem){
					add_user(<?=($logged)? "elem.is_admin," : ""?>elem.name, elem.color<?=($logged)? ", elem.ip" : ""?>,elem.resource_id);
				});
			},
			single: function(e){
                    data = e.data;
                    var scroll = false;
                    if($(chat_box).scrollTop() + $(chat_box).innerHeight() + 200 >= $(chat_box)[0].scrollHeight) {
                    scroll = true;
                    }
                    add_chat_message(data.name, data.color, data.message, data.uniqid);
                    if(scroll){
                    scroll_bottom();
                    }
            },
            ban_user: function(e){
                chat_box.append('<div class="chat-message text-danger font-weight-bold">Mesaj Yazmanız '+e.data.deadline_date+' \'a kadar yasaklandı.</div>');
                $("#chat-message, #btnSend").prop("disabled", true);
                scroll_bottom();
                clearTimeout(banClear);
                if(e.data.deadline != 0){
                        var banClear = setTimeout(function(){
                        chat_box.append('<div class="chat-message text-success font-weight-bold">Yasağınız kalktı.</div>');
                        scroll_bottom();
                        $("#chat-message, #btnSend").prop("disabled", false);
                        },e.data.deadline*1000 - $.now() );
                    }

            },
            error: function(e){
            console.error(e.data.message);
            }


}
	});
}