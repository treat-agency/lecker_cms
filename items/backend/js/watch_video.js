
 $(document).ready( function () {
    $('#title').text(title);

    if(src.includes("mp4")){
        src = "/items/uploads/Multimediale/converted_videos/" + src;
        $("#vid1").attr("src",src).show();
        src2 = src.replace("mp4","webm")
        $("#vid2").attr("src",src2).show();
        $("iframe").hide();
    }
    else{
        $("iframe").attr("src","https://www.youtube.com/embed/" + src).show();
        $("video").hide();
    }
} );
