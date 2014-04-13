$(function(){
    $("#login_form_toggle").on("click", function(){
        if( $("#login_form_toggle").hasClass('notactive') ){
            $("#login_form").fadeIn(500);
            $("#login_form_toggle").removeClass('notactive').addClass('active');
        } else {
            $("#login_form").fadeOut(500);
            $("#login_form_toggle").removeClass('active').addClass('notactive');
        }
    });
});

var mod = {
    rotate: function(direction, file, directory){
        $.post('?rotate=true&direction='+direction, {
            "file": file,
            "directory": directory
        }, function(data){
            viewImage(viewIndex);
        });
    },
    rotateLeft: function(){
        this.rotate("left", files[viewIndex], album.folder);
    },
    rotateRight: function(){
        this.rotate("right", files[viewIndex], album.folder);
    }
};