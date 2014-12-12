var viewIndex = 0;
var viewportwidth;
var viewportheight;
var maxViewSize = 0;
function getCurrentIndex(){
    var loadIndex = 0;
    if(window.location.hash){
        loadIndex = window.location.hash.replace("#", "");
        if( Math.abs(loadIndex) > 0 || Math.abs(loadIndex) < files.length ){
            loadIndex = Math.abs(loadIndex);
        }
    }
    return loadIndex;
}
function onViewLoad(){
    generateThumbs();
     	
    $( "body" ).append( "<div id='preloader' style='display:none;'></div>" );
    refit();
    $(window).bind('resize', refit);
    window.scrollTo(0,0);
    
    $(document.documentElement).keyup(function (event) {

        // handle cursor keys
        if (event.keyCode == 37) {
            // go left
            if( viewIndex-1 > 0 ){
                viewImage(viewIndex-1);
            }
        } else if (event.keyCode == 39) {
            // go right
            if( viewIndex+1 < files.length ){
                viewImage(viewIndex+1);
            }
        } else if( event.keyCode === 8) { 
            window.location = "?";
        }
    });

    $("#view-container-text-toggle").on('click', function(){
        if( $("#view-container-text").hasClass("hidden") ){
            $("#view-container-text").removeClass("hidden");
        } else {
            $("#view-container-text").addClass("hidden");
        }
    });
}

function refit() {
    
    // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
    
    try{
        viewportwidth = window.innerWidth,
        viewportheight = window.innerHeight
    } catch( error ){
        alert("Unsupported browser");
    }

	var minHeight = viewportheight;
	var minWidth = viewportwidth;
    
    maxViewSize = 0; // when doing a refit not to apply for old boundries
    var viewDivHeight = $("#view-container-img").height()*1,
        viewDivWidth = $("#view-container-img").width()*1;

    for(var key in sizeConfig) {
        if( sizeConfig[key].width >= viewDivWidth && sizeConfig[key].height >= viewDivHeight && maxViewSize === 0){
            maxViewSize = key;
    	    minWidth = sizeConfig[key].width;
	        minHeight = sizeConfig[key].height;
        }
    }
    //maxViewSize
    var removeHeight = 0;
    if($(".thumb-container").css("display") === 'block'){
        removeHeight = 180;
    }

    var sizes = {
        'width': viewportwidth+"px",
        'height': ( viewportheight- removeHeight - 50)+"px"
    };

    $(".header .mod").css( "left",  ( (viewportwidth - 70) / 2) + "px");

    $("#view-container").css(sizes);
    $("#view-container-img").css(sizes);
    $("#view-container-loader").css(sizes);
    var loadIndex = getCurrentIndex();
    viewImage(loadIndex);

}

function thumbTpl(pic, index){
    return [
        '<a href="#'+index+'" class="file" id="cnt-'+index+'">',
        '<div class="file-inner">',
        '<img src="./albums/'+album.folder+'/thumbs/'+pic.file+'" alt="" border="0" />',
        '',
        '',
        '</div>',
        '</a>'
    ].join('');
}

function viewTpl(pic, index){
    var size = getViewSubfolder(pic),
        style = 'max-width:'+ ( $("#view-container-img").width()*1 - 70)+"px;"+
            "max-height:"+ ( $("#view-container-img").height()*1 - 70)+"px";
    
    return [
        '<img src="./albums/'+album.folder+'/'+size+pic.file+'" style="'+style+'" alt="" border="0" />'
    ].join('');
}

function generateThumbs(){
    
    var thumbs = "";
    //file: "DSCI3547.JPG", title: "", description: ""

    for(var cnt = 0, len = files.length; cnt < len; cnt++ ){
        thumbs+= thumbTpl(files[cnt], cnt);
    }

    $(".thumb-container .scroll").css("width", ( files.length * 167 ) + "px").html(thumbs);
    
    $(".thumb-container .scroll .file").on('click', function(){
        var index = $(this).attr('id').replace("cnt-", '');
        viewImage(index);

    });
}

function getViewSubfolder( file ){
	var size = '';
    if(file.maxSize) {
        if( file.maxSize >= maxViewSize){
            size = (maxViewSize===0)?'':(maxViewSize+'/');
        } else if( file.maxSize > 0){
            size = '1/';
        }
    }
    return size;
}

function viewNext(){
    if( files.length > viewIndex+1){
        viewImage(viewIndex+1);
    }
}

function viewPrevious(){
    if( viewIndex-1 >= 0){
        viewImage(viewIndex-1);
    }
}

function viewImage(index){
    index = index*1;
    $("#cnt-"+viewIndex).removeClass("active");
    viewIndex = index;
    window.location.hash = "#"+viewIndex;
    $("#cnt-"+viewIndex).addClass("active");

    files[index].file = files[index].file+"?rnd="+Math.random();

    $("#previous-image").hide();
    $("#next-image").hide();

    if( index-1 >= 0){
        $("#previous-image").show();
    }

    if( files.length > index+1){
        $("#next-image").show();
    }

    var tpl = viewTpl(files[index]);
    var img = new Image();
    var size = getViewSubfolder(files[index]);

    img.src = './albums/'+album.folder+'/'+size+files[index].file;

    $("#view-container-loader").css('display', 'block');
    $("#view-container-img").css('display', 'none');
    img.onload = function(){
        $("#view-container-img").html(tpl);
        $("#view-container-loader").css('display', 'none');
        $("#view-container-img").css('display', 'block');
        $(".thumb-container").scrollLeft( 167 * ( index - 1) );
    };
    $("#preloader").empty();
    $("#preloader").append(img);

    if(files[index].title !== "" || files[index].description !== ""){
        $("#view-container-text").html('<h2>'+files[index].title+'</h2><br />'+files[index].description);
    }
    }

function toggleThumbs(){
    //$("#hide-show-thumbs")
    if( $(".thumb-container").css("display") === 'block'){
        $(".thumb-container").css("display", 'none');
        $("#hide-show-thumbs").css('bottom', '0px');
    } else  {
        $(".thumb-container").css("display", 'block');
        $("#hide-show-thumbs").css('bottom', '182px');
    }
    refit();
}
