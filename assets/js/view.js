var previous = false,
view;

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
obj.style.webkitTransition ="all 0.5s";
obj.style.webkitTransformOrigin ="top left";
obj.style.webkitTransform ="translate(0px,0)";

setTimeout(function(){ 
    if(callback){
        callback();
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
    div.style.webkitTransition ="all 0.5s";
    div.style.webkitTransformOrigin ="top left";
    div.style.webkitTransform ="translate(200px,0)";
    //div.style.webkitTransform ="scale(2,2)";
    previous = div;
}