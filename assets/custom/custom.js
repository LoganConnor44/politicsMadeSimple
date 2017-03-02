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

function getStatesFromPHP(){
    $.ajax({
        url: window.politicsMadeSimple.baseUrl + 'index.php/Simple/ajaxAllStates',
        type : 'GET',
        dataType:'json',
        contentType: "application/json;charset=utf-8",
        success: function(statesObj){
            destroyIconAndReplace();
            createStateSelect(statesObj);

        }});
}

function createStateSelect(statesObj){
    var appendHere = document.getElementById('appendSelectHere');
    var content = document.createElement('div');
    var row = document.createElement('div');
    var inputField = document.createElement('div');
    var select = document.createElement('select');
    var option = document.createElement('option');
    var label = document.createElement('label');
    content.setAttribute('class', 'card-content blue darken-1');
    row.setAttribute('class', 'row');
    inputField.setAttribute('class', 'input-field col s12');
    select.setAttribute('name', 'stateSelect');
    select.setAttribute('form', 'legislators');
    select.setAttribute('id', 'stateSelect');
    option.setAttribute('value', '');
    label.innerHTML = 'Select State';
    for(var state in statesObj){
        var option = document.createElement('option');
        option.setAttribute('value', state);
        option.innerHTML = statesObj[state];
        select.appendChild(option);
    }
    inputField.appendChild(select);
    inputField.appendChild(label);
    row.appendChild(inputField);
    content.appendChild(row);
    appendHere.appendChild(content);
    $('#appendSelectHere').hide().slideDown('fast');
    $('html, body').animate({
        scrollTop: 1000
    }, 2000);

    //Tell materialize to intialize the select
    $(document).ready(function() {
        $('select').material_select();
    });
    return true;
}

function destroyIconAndReplace(){
    var anchor = document.getElementById('repurposeAnchor');
    var newIcon = document.createElement('i');
    $('#stateSearchIcon').switchClass('scale-in', 'scale-out', 1500, function deleteElement(){
        this.remove();
    });
    anchor.setAttribute('type', 'submit');
    newIcon.setAttribute('class', 'material-icons scale-transition scale-out');
    newIcon.setAttribute('id', 'newIcon');
    newIcon.setAttribute('onClick', 'document.getElementById("legislators").submit()');
    newIcon.innerHTML = 'send';
    anchor.appendChild(newIcon);
    $('#newIcon').switchClass('scale-out', 'scale-in', 'fast');
}



$(document).ready(function() {
    for(var i = 0; i <= 40; i++){
        var initialElements = document.getElementsByClassName(randState());
        $(initialElements).css('color', newColor());
    }
    window.setInterval(function(){
        var randomElement = document.getElementsByClassName(randState());
        $(randomElement).css('color', newColor());
    }, 1500);

	//Allows Side Navigation From MaterializeCSS
	$(".button-collapse").sideNav({
		menuWidth: 150,
		draggable: true
	});
});
