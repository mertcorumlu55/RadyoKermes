
function open_popup(url){
    $.fancybox.defaults.touch = false;
    $.fancybox.defaults.smallBtn = true;
    $.fancybox.defaults.spinnerTpl = '<div style=\"padding:20px;\" class="fancybox-loading"></div>';

        $.fancybox.open("<div><div style=\"padding:10px;\" class=\"popup-content\"></div></div>",{css:{
        padding:"35px"
        }});

    $.ajax({
        method:"GET",
        url: url,
        crossDomains:true,
        beforeSend:function () {
            $.fancybox.getInstance().showLoading();
        },
        success: function (data) {
            $.fancybox.getInstance().hideLoading();
            $(".popup-content").html(data);
        },
        error:function () {
            $.fancybox.getInstance().hideLoading();
            $(".popup-content").html('<div class="alert alert-danger text-center">An Error Occured.Please Contact Administrator.</div>');
        }
    });

    }




