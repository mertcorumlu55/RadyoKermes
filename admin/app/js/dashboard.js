var radio_server_online = 0;
var stream_online = 0;
var autodj_online = 0;
var chat_server_online = 0;
var world_map = $('#world-map-marker');
var dataTable,mapObj;

$(document).ready(function () {
    dataTable = $('#peers').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "searching": false,
        pageLength: 9
    });

    world_map.vectorMap({
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
        zoomOnScroll:0,
        scaleColors:["#b6d6ff","#005ace"],
        selectedColor:"#dc53df",
        enableZoom:1,
        hoverColor:"#fff"
    });
    mapObj = world_map.vectorMap('get', 'mapObject');
    mapObj.setFocus({scale: 8, region:"TR", animate: true});

    get_radio_data();
    window.setInterval(function () {
        get_radio_data();
    },1000*15 /*SANIYE*/);


    var buttons = $("button.radio-server-button, button.autodj-button, button.chat-server-button");
    buttons.on("click",function () {
        var btn = $(this);
        $.ajax({
            url: "/admin/ajax/linux-command",
            data: {action: $(this).attr("id")},
            beforeSend:function(){
                buttons.prop('disabled', true);
                btn.append('<i class="fa ml-1 fa-circle-o-notch fa-spin"></i>')
            },
            success:function (data) {

                if(data.error === "0"){
                    snackbar_toggle("success",data.message);
                }else if(data.error === "1"){
                    snackbar_toggle("danger",data.message);
                }

                buttons.prop('disabled', false);
                btn.find("i").remove();
                get_radio_data(world_map,dataTable);
            },
            error:function () {
                snackbar_toggle("danger","Bir Hata Oluştu");
                buttons.prop('disabled', false);
                btn.find("i").remove();
            }
        });

    });

    $("#radyo_konu").submit(function (a) {
        a.preventDefault();
        var radyo_konu = $(this);
        var radyo_konu_button = $("#radyo_konu_button");
        var radyo_konu_text = $("#radyo_konu_text");

        radyo_konu_button.prop('disabled', true);
        radyo_konu_button.append('<i class="fa ml-1 fa-circle-o-notch fa-spin"></i>');
        radyo_konu_text.text("anan");
        $.ajax({
            url: "/admin/ajax/radyo-konu-edit",
            type: "POST",
            data: radyo_konu.serializeArray(),
            success:function (e) {
                radyo_konu_button.prop('disabled', false);
                radyo_konu_button.find("i").remove();
                if(e.error === true){
                    snackbar_toggle("danger",e.message);
                    radyo_konu_text.val(radyo_konu_text.attr("value"));
                    get_radio_data();
                }else{
                    snackbar_toggle("success","Radyo başlığı güncellendi");
                }
            },
            error:function () {
                radyo_konu_text.val(radyo_konu_text.attr("value"));
                radyo_konu_button.prop('disabled', false);
                radyo_konu_button.find("i").remove();
                snackbar_toggle("danger","Başlık güncellenirken bir hata oluştu")
            }
        });
    });

});

function get_radio_data(){

    get_server_info();

    $.ajax({
        url: "/admin/ajax/get-info?json=1",
        beforeSend: function(){
            $(".server-info .loading").removeClass("d-none");
        },
        success:function (data) {
                $(".server-info .loading").addClass("d-none");
                stream_online = data.online;
                $("#listeners").text(data.listeners + "/512");

                if(stream_online === 1){
                    $("div.radyo-konu").slideDown();
                    $("#song").text(data.title);
                }else{
                    $("div.radyo-konu").slideUp();
                    $("#song").text(data.track);
                }
        },
        error:function () {
            $(".server-info .loading").addClass("d-none");
            console.error("Radyo bilgileri getirilirken bir hata oluştu.");
        }

    });

    $.ajax({
        url: "/admin/ajax/listener-information",
        data : {online: stream_online},
        beforeSend: function(){
            $(".listener-info .loading").removeClass("d-none");
        },
        success:function (data) {
            $(".listener-info .loading").addClass("d-none");

            if(data.error === 1 || data.type === "no_stream"){
                dataTable.clear().draw();
                mapObj.removeAllMarkers();
                return;
            }
            dataTable.clear();
            mapObj.removeAllMarkers();

            var markers = [];
            $.each(data,function(key,ipinfo){
                markers.push({ latLng: [ipinfo.latitude, ipinfo.longitude], name: ipinfo.ip+" | "+ ipinfo.useragent });
                dataTable.row.add([ipinfo.country,ipinfo.ip,ipinfo.useragent]);
            });
            dataTable.draw();
            mapObj.addMarkers(markers,[]);
            },
        error:function () {
            $(".listener-info .loading").addClass("d-none");
            console.error("Dinleyici bilgileri getirilirken bir hata oluştu.");
        }
    });

}

function get_server_info() {
    var radio_server_status = $("#radio_server_status");
    var autodj_status = $("#autodj_status");
    var chat_server_status = $("#chat_server_status");

    $.ajax({
        url: "/admin/ajax/linux-command",
        data: {action: "check_servers"},
        success:function (data) {
            if(data.radio_server.online === "1"){
                radio_server_online = 1;
                radio_server_status.removeClass();
                radio_server_status.addClass("text-success");
                radio_server_status.text("ONLINE");
            }else{
                radio_server_online = 0;
                radio_server_status.removeClass();
                radio_server_status.addClass("text-danger");
                radio_server_status.text("OFFLINE");
            }

            if(data.autodj.online === "1"){
                autodj_online = 1;
                autodj_status.removeClass();
                autodj_status.addClass("text-success");
                autodj_status.text("ON");
            }else{
                autodj_online = 0;
                autodj_status.removeClass();
                autodj_status.addClass("text-danger");
                autodj_status.text("OFF");
            }

            if(data.chat_server.online === "1"){
                if(chat_server_online === "0" && reconnect_counter >= 10){
                    connect_chatserver();
                }
                chat_server_online = 1;
                chat_server_status.removeClass();
                chat_server_status.addClass("text-success");
                chat_server_status.text("ON");
            }else{
                chat_server_online = 0;
                chat_server_status.removeClass();
                chat_server_status.addClass("text-danger");
                chat_server_status.text("OFF");
            }

        },
        error:function () {
            console.error("Sunucu durumları getirilirken bir hata oluştu.")
        }
    });
}