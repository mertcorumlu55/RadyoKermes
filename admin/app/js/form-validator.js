//FORM VALIDATOR
function form_validate(func = {do_before: function(){}, do_error: function(){}, do_success: function(data){}, error_false: function(data){}, error_true: function(data){}   }) {

    var button = $("button[type=submit]");
    var form_validate = $("form.needs-validation");
    var alertBox = $(".alert.message");


        var forms = document.getElementsByClassName('needs-validation');

        var validation = Array.prototype.filter.call(forms, function(form) {

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('not-valid');
                }else if(form.checkValidity() === true){

                    form.classList.remove("not-valid");

                    $.ajax({
                        type: "POST",
                        url: form_validate.attr("action"),
                        data: form_validate.serializeArray(),
                        beforeSend:function () {
                            show_loading(button);
                            //BEFORE SEND
                            func.do_before();
                        },
                        error:function () {
                            hide_loading(button);
                            alertBox.addClass("alert-danger").removeClass("alert-success").html("An Error Occured.Please Contact Administrator.").slideDown();
                            //AJAX ERROR
                            func.do_error();
                        },
                        success: function (data) {
                            hide_loading(button);
                            //AJAX SUCCESS
                            func.do_success(data);

                            if(data.error === true){
                                //IF ERROR TRUE
                                func.error_true(data);
                                return 0;
                            }

                            //IF ERROR == FALSE
                            func.error_false(data);
                        }
                    });

                }
                form.classList.add('was-validated');
            }, false);
        });

}

function show_loading(a){
    $("fieldset").attr("disabled",true);
    a.data("original-text",a.html());
    a.attr("disabled", true);
    a.html(a.data("loading-text"));
}

function hide_loading(a){
    $("fieldset").attr("disabled",false);
    a.html("Submit");
    a.attr("disabled", false);
}
