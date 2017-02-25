function newColor(){
    var colors = [
        "#80DEEA",
        "#4DD0E1",
        "#26C6DA",
        "#00BCD4",
        "#00ACC1",
        "#0097A7",
        "#00838F",
        "#006064"
    ];
    var randomColor = Math.floor(Math.random() * colors.length);
    return(colors[randomColor]);
}

function randState(){
    var states = [
        "al",
        "ak",
        "az",
        "ar",
        "ca",
        "co",
        "ct",
        "de",
        "dc",
        "fl",
        "ga",
        "hi",
        "id",
        "il",
        "in",
        "ia",
        "ks",
        "ky",
        "la",
        "me",
        "md",
        "ma",
        "mi",
        "mn",
        "ms",
        "mo",
        "mt",
        "ne",
        "nv",
        "nh",
        "nj",
        "nm",
        "ny",
        "nc",
        "nd",
        "oh",
        "ok",
        "or",
        "pa",
        "pr",
        "ri",
        "sc",
        "sd",
        "tn",
        "tx",
        "ut",
        "vt",
        "va",
        "wa",
        "wv",
        "wi",
        "wy"
    ];
    var randomState = Math.floor(Math.random() * states.length);
    return(states[randomState]);
}

$(document).ready(function() {
    for(var i = 0; i <= 40; i++){
        var initialElements = document.getElementsByClassName(randState());
        $(initialElements).css('color', newColor());
    }
    window.setInterval(function(){
        var randomElement = document.getElementsByClassName(randState());
        $(randomElement).css('color', newColor());
        console.log(randState());
    }, 1500);
	//Allows Side Navigation From MaterializeCSS
	$(".button-collapse").sideNav();
});
