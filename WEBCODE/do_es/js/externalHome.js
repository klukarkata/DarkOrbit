function changePic(ziel, wert) {
    document.getElementById(ziel).style.backgroundImage = "url("+wert+")";
}

function showLang() {
    document.getElementById("choose_lang").style.display = "block";
}
function hideLang () {
    document.getElementById("choose_lang").style.display = "none";
}

/* ## layersteuerung ## */

function show_preview (itemID, buttonID){
    pe.stop();

    if ($("div_flashtrailer").style.visibility == "visible") {
        controlMovie('trailer','stop');
    } else if ($("div_ingame").style.visibility == "visible") {
        controlMovie('ingame','stop');
    }

    $("div_flashtrailer").style.visibility = "hidden";
    if ($('div_gewinne')) {
        $("div_gewinne").style.visibility = "hidden";
    }
    $("div_infos").style.visibility = "hidden";
    $("div_ingame").style.visibility = "hidden";

    $(current_item).style.visibility = "hidden";
    $(current_button).className = "mm_box_std";

    current_item = itemID;
    current_button = buttonID;

    $(current_item).style.visibility = "visible";
    $(current_button).className = "mm_box_active";

    if ($("div_flashtrailer").style.visibility == "visible") {
        if (itemID == "div_flashtrailer") {
            controlMovie('trailer','play');
        }
    }
    if ($("div_ingame").style.visibility == "visible") {
        if (itemID == "div_ingame") {
            controlMovie('ingame','play');
        }
    }
}
/* ## layersteuerung ## */

/* ## FLASHSTEURUNG ## */
function findFlash (flash) {
    if (document.all) {
        if (document.all[flash]) {
            return document.all[flash];
        }
        if (window.opera) {
            var movie = eval(window.document + flash);
            if (movie.SetVariable) {
                return movie;
            }
        }
        return;
    }
    if(document.layers) {
        if(document.embeds) {
            var movie = document.embeds[flash];
            if (movie.SetVariable) {
                return movie;
            }
        }
        return;
    }
    if (!document.getElementById) {
        return;
    }

    var movie = document.embeds[flash];////document.getElementById(flash);
    if (movie.SetVariable) {
        return movie;
    }

    var movies = movie.getElementsByTagName('embed');
    if (!movies || !movies.length) {
        return;
    }

    movie = movies[0];
    if (movie.SetVariable) {
        return movie;
    }
    return;
}

function getFlashMovie(movieName) {
    var isIE = navigator.appName.indexOf("Microsoft") != -1;
    return (isIE) ? window[movieName] : document[movieName];
}

function controlMovie(target,rawAction) {
    var actionStr = rawAction;

    //findFlash(target).controlMovieInFlash(actionStr);
    window.setTimeout('findFlash("'+target+'").controlMovieInFlash("'+actionStr+'")', 500);
}
/* ## FLASHSTEURUNG ## */

/* ## Rotator ## */
var item_no = 0;

function show_item(itemID, buttonID) {
    //alert('show item ' + item_id);
    if(itemID == current_item) {
        //alert('active ' + current_item);
        return;
    }

    document.getElementById(current_item).style.visibility = "hidden";
    document.getElementById(current_button).className = "mm_box_std";

    current_item = itemID;
    current_button = buttonID;

    document.getElementById(current_item).style.visibility = "visible";
    document.getElementById(current_button).className = "mm_box_active";
}

var pe = new PeriodicalExecuter(playNext, 5);
//new PeriodicalExecuter(playNext, 5);

function playNext() {
    show_item(items[item_no], buttons[item_no]);
    item_no++;
    item_no %= items.length;
}
/* ## Rotator ## */

function stopRotator () {
    pe.stop();
}

/* ## Screenshots ## */
var screen_number = 1;
var screen_maxNumber = 7;
function changeScreen(where) {
    pe.stop();
    if (where == "up") {
        if (screen_number<screen_maxNumber) {
            screen_number++;
        } else {
            screen_number=1;
        }
    } else {
        if (screen_number>1) {
            screen_number--;
        } else {
            screen_number = screen_maxNumber;
        }
    }
    document.getElementById("screenshot").innerHTML = '<img src="'+CDN+'do_img/global/intro/screenshot_'+screen_number+'.jpg" width="426" height="160" alt="" />';
}
/* ## Screenshots ## */

/* ## Gewinne ## */
var prize_number = 1;
var prize_maxNumber = 1;
var text = "";
function changePrize(where) {
    pe.stop();
    if (where == "up") {
        if (prize_number<prize_maxNumber) {
            prize_number++;
        } else {
            prize_number=1;
        }
    } else {
        if (prize_number>1) {
            prize_number--;
        } else {
            prize_number = prize_maxNumber;
        }
    }
    document.getElementById("prizes").style.backgroundImage = CDN+'do_img/global/intro/prizes_'+prize_number+'.png';
    document.getElementById("prizes").innerHTML = "{/literal}{$res.intro_prize_1_text}{literal}";
}
/* ## Screenshots ## */


function preloadImgExternal() {
    document.Vorladen = new Array();

    for(var i = 0; i < imageList.length; i++) {
        document.Vorladen[i] = new Image();
        document.Vorladen[i].src = imageList[i];
    }
}

function showOpenId() {
    $('loginForm_default').style.display = 'none';
    $('loginForm_openId_container').style.display = 'block';
}

function hideOpenId() {
    $('loginForm_openId_container').style.display = 'none';
    $('loginForm_default').style.display = 'block';
}
