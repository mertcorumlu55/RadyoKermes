function logout(){

    $.ajax({
        url:"/app/ajax/logout",
        type:"post",
        success :function () {
            location.reload();
        }
    });

}

function file_printed(id){

    if(confirm("Are you sure marking this file as printed?")){
        $.ajax({
            url : "/app/ajax/file-evaluate-post",
            type : "POST",
            data : {"type":"file_evaluate","unique_id": id,"file_status":"4"},
            error:function () {
                alert("An Error Occured");
            },
            success:function (data) {

                if(data.error === true){
                    alert(data.message);
                }else{
                   location.reload();
                }

            }
        });
    }



}

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