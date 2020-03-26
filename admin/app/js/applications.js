
    function application_evaluate(a,b){

    var button;
    if(b === "1"){
        button = $(".button-approve");
    }else{
        button = $(".button-reject");
    }

        show_loading(button);

    var sendmail = $("#sendEmail").is(':checked');

        $.ajax({
            method:"GET",
            url:"/app/ajax/application-evaluate",
            data:{"id":a,"value":b,"sendEmail":sendmail},
            error:function(){
                $(".alert.message").addClass("alert-danger").html("An Error Occured.Please Contact Administrator.").slideDown();
                hide_loading(button);
            },
            success:function (data) {
                hide_loading(button);
                if(data.error === true){
                    $(".alert.message").addClass("alert-danger").html(data.message+ " "+ "Please Contact Administrator.").slideDown();
                    return 0;
                }

                $(".popup-content").html("<div class=\"alert alert-success text-center\" >"+data.message+"<br><a href=\"javascript:close_popup($('div.popup'),false)\">You Can Close This Dialog From Here.</a></div>");

                $("div[data-id='"+data.id+"']").removeClass("btn-warning");
                $("div[data-id='"+data.id+"']").removeClass("btn-danger");
                $("div[data-id='"+data.id+"']").removeClass("btn-success");

                if(data.state === "1"){
                    $("div[data-id='"+data.id+"']").addClass("btn-success");
                    $("div[data-id='"+data.id+"']").html("Approved");

                }else if(data.state === "2") {
                    $("div[data-id='"+data.id+"']").addClass("btn-danger");
                    $("div[data-id='"+data.id+"']").html("Rejected");
                }



            }
        });

    }

    function show_loading(a){
    a.data("original-text",a.html());
    a.attr("disabled", true);
    a.html(a.data("loading-text"));
    }

    function hide_loading(a){
        a.html(a.data("original-text"));
        a.attr("disabled", false);
    }

