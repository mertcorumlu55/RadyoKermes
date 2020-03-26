$(document).on("change","input[type=file]",function () {

    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        //get the file size and file type from file input field
        var fsize = $("input[type=file]")[0].files[0].size;
        var ftype = $("input[type=file]")[0].files[0].type;

        switch(ftype)
        {
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/pdf':

                if(fsize>1048576 * 10) //do something if file size more than 10 mb (1048576)
                {
                    alert("Your file is larger than 10 Mb");
                    $("input[type=file]").val("");
                }

                break;
            default:
                alert("This file type is not supported.");
                $("input[type=file]").val("");
        }


    }else{
        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
    }

});