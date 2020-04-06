
$(document).ready( function () {
    $(document).on("click","button.delete-button",function () {

        if( $(this).data("id") !== "" && $(this).data("type") !== ""){

            if(!confirm("Are you sure you want to delete this " + $(this).data("type") + "?" )){
                return;
            }
            $.ajax({
                method:"GET",
                url:"/app/ajax/delete",
                data:{
                    "type": $(this).data("type"),
                    "id" : $(this).data("id")
                },
                error:function () {
                    alert("An Error Occured.Please Contact Administrator.");
                },
                success:function (data) {

                    if(data !== "" ){
                        alert(data.message);
                        window.location.reload();
                    }

                }

            });

        }

    });
});

function logout(){

    $.ajax({
        url:"/admin/app/ajax/logout",
        type:"post",
        success :function () {
            location.reload();
        }
    });

}

function snackbar_toggle(type,message) {
    // Get the snackbar DIV
    var a = $("#snackbar");
    // Add the "show" class to DIV
    a.removeClass();
    a.text(message);
    a.addClass("alert");
    a.addClass("alert-"+type);
    a.addClass("show");
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ a.removeClass("show") }, 6000);
}

