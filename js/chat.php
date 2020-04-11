<?php
header("Content-Type: text/javascript");
include "../inc/loader.php";
$logged = $auth->isLogged();
?>
var message_send_input = $('#chat-message');
var chat_box = $('#chat-box');
var clients_box = $("#online-clients-box");
var chatbox_container = $("div.chatbox");
var file_dragover = $("div.file-dragover");
var file_input = $("#file_image");
var files_to_send = [];
var files_data = [];
var images_to_send = $("div.images-to-send");

$(function () {
	$('#frmChat').on("submit",function(event){
		event.preventDefault();
		if(files_to_send.length === 0){
            if(!message_send_input.val() == ""){
                ws.send("chat_message",{msg: message_send_input.val()});
            }else{
                console.error("Mesaj kutusu boş olamaz");
            }
        }

        if(files_to_send.length > 0){

            $.when.apply(this, files_upload()).done(function(){
                ws.send("chat_message_img",{msg: message_send_input.val() , images: files_data});
            });

        }



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

    chatbox_container.on("dragover dragleave drop", function (e) {
        e.preventDefault();
        if(e.type === "dragover"){
            if(file_dragover.hasClass("d-none")){
                file_dragover.removeClass("d-none");
            }
        }else{
            if(!file_dragover.hasClass("d-none")){
                file_dragover.addClass("d-none");
            }

            if(e.type === "drop"){
                files_add(e.originalEvent.dataTransfer.files);
            }
        }

    });

    file_input.on("change",function (e) {
        e.preventDefault();
        files_add(e.originalEvent.target.files);
    });

    $(document).on("click", "div.images-to-send .image i.fa", function (e) {
        e.preventDefault();
        var image_object = $(this).parent(true);
        $.each(files_to_send, function (key, value) {

            if(value.image_object.is(image_object)){
                files_to_send.splice(key,1);
                value.image_object.remove();
                if(files_to_send.length === 0){
                    if(!images_to_send.hasClass("d-none")){
                        images_to_send.addClass("d-none");
                    }
                }
                return false;
            }
        });

    });



});

function files_add(files){
    if(images_to_send.hasClass("d-none")){
        images_to_send.removeClass("d-none");
    }
    file_input.attr("type","text");
    file_input.attr("type","file");

    for( var i = 0; i < files.length; i++) {
        var image_object = $("<div>", {class: "image"});
        image_object.html(" <i class=\"fa fa-times\"></i>\n" +
            "                            <img class=\"blur\" alt=\"\" src=\"\" />\n" +
            "                            <div class=\"progress\">\n" +
            "                                <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>\n" +
            "                            </div>");
        images_to_send.append(image_object);

        (function (image_object) {
            var reader = new FileReader();
            reader.onload = function (a) {
                image_object.find("img").attr("src", a.target.result);
            }
            reader.readAsDataURL(files[i]);
        })(image_object)

       files_to_send.push({file: files[i], image_object: image_object});

    }

}

function files_upload(){

    files_data = [];
    var asyncs = [];
    for( var i = 0; i < files_to_send.length; i++) {
        var image_object = files_to_send[i].image_object;
        var formData = new FormData();
        formData.append("file", files_to_send[i].file);
        var ajax;
        (function(i,image_object){

            ajax = $.ajax({
                url: "/admin/ajax/upload_img",
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                error: function(){
                  console.error("Resimler Sunucuya Yüklenirken Bir Hata Oluştu");
                },
                success: function (e) {
                    if(e.error){
                        console.error(e.message)
                    }else{
                       files_data.push({img_path: e.file_path, img_id: e.file_id})
                    }
                },
                xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (e) {
                    if(e.lengthComputable){
                       var percentComplete = Math.round(e.loaded/e.total*100);
                       image_object.find(".progress-bar").css("width", percentComplete + "%").text(percentComplete + "%").attr("aria-valuenow",percentComplete);
                    }
                })
                return xhr;
            }

            });


        })(i,image_object);
        asyncs.push(ajax);
    }

    return asyncs;

}


function scroll_bottom(){
        chat_box.scrollTop(chat_box[0].scrollHeight);
}

function add_chat_message(name,color,msg,id, with_image){
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
                    add_chat_message(data.name, data.color, data.message, data.uniqid, false);
                    if(scroll){
                    scroll_bottom();
                    }
            },
            single_with_image:function(e){
                data = e.data;
                var scroll = false;
                if($(chat_box).scrollTop() + $(chat_box).innerHeight() + 200 >= $(chat_box)[0].scrollHeight) {
                    scroll = true;
                }
                add_chat_message(data.name, data.color, data.message, data.uniqid, true);
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