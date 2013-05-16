var previous = false,
view;

function onViewLoad(){
    if(window.location.hash && window.location.hash.length > 1){
        expand( document.getElementById(window.location.hash.replace("#", "")));
    }
}

function view(id) {
    var div = document.getElementById(id);
    if(previous!==false && div.id != previous.id){
        collapse(previous, function(){
            expand(div);
        });
    }else if(div.id != previous.id){
        expand(div);
    }
}

function collapse( obj, callback ){
    obj.className = "file collapse";
    setTimeout(function(){ 
        if(callback){
            callback();
            obj.className = "file";
        }
    }, 500);
}

function expand( div ){

    var view = document.getElementById('view'),
        expandDiv = div.getElementsByClassName('view-big')[0];

    var bigImg = expandDiv.getElementsByClassName('img')[0];

    var previousBig = view.childNodes[0];
    if(previousBig && previousBig.tagName) {
        document.getElementById(previousBig.id.replace('-big', '')).appendChild(previousBig);
    }

    window.location.hash = div.id;

    var preload = new Image();
    preload.src = bigImg.getAttribute('picsrc');
    setTimeout(function(){
            var imgRatio = preload.width / preload.height,
                viewRatio = view.offsetWidth / view.offsetHeight;

            if( viewRatio > imgRatio ) {
                bigImg.width = view.offsetHeight * imgRatio;
            } else {
                bigImg.height = view.offsetWidth / imgRatio;
            }
            view.appendChild(expandDiv);

            var imgDiv = expandDiv.getElementsByClassName('thumb')[0],
                titleDiv = expandDiv.getElementsByClassName('title')[0];

            imgDiv.style.width = view.offsetWidth+"px";
            imgDiv.style.height = view.offsetHeight+"px";

            titleDiv.style.width = bigImg.width+"px";
            titleDiv.style.top = (view.offsetHeight-40)+'px';

            //titleDiv.style.height = bigImg.height+'px';
            bigImg.src = bigImg.getAttribute('picsrc');
    }, 500);
    div.className = "file expand";

    previous = div;
}