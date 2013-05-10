function redirect(destination, newWindow, target)
{
    if (destination)
    {
        if (newWindow && target === undefined)
        {
            window.open(destination, '_blank');
        }
        else if (target !== undefined) {
            window.open(destination, target);
        }
        else
        {
            window.open(destination, '_self');
        }


    }
    else
    {
        return false;
    }
}

function redirectToExternalHome()
{
    redirect('/index.es?action=externalHome&loginError=99');
}

function openShopCategory(category)
{
    redirect('/indexInternal.es?action=internalDock&category=' + category);
}


function translate(s)
{
    return s;
}

var browserType = 'unknown';
if (navigator.userAgent.match(/Opera/)) {
    browserType = 'opera';
} else if (navigator.userAgent.match(/MSIE/)) {
    browserType = 'ie';
} else if (navigator.userAgent.match(/Mozilla/)) {
    browserType = 'ns';
}


function domGet(id)

{

    if (typeof(id) != 'string') {

        return id;

    } else {

        return document.getElementById(id);

    }

}



function domGetChild(obj, id)

{

    for (var i=0; i<obj.childNodes.length; i++) {

        var n = obj.childNodes[i];

        if (n.nodeType != 1) continue;

        if (n.id == id) return n;

        var r = domGetChild(n, id);

        if (r != false) return r;

    }

    return false;

}



function domGetBody()

{

    var tmp = document.getElementsByTagName('BODY');

    return tmp[0];

}



function domGetOffset(obj)

{

    obj = domGet(obj);

    var offset = {
        x:0,
        y:0
    };

    if (obj.offsetX) return {
        x:obj.offsetX,
        y:obj.offsetY
    };

    while (obj) {

        offset.x += obj.offsetLeft;

        offset.y += obj.offsetTop;

        obj = obj.offsetParent;

    }

    return offset;

}



function domFireEvent(obj, name)

{

    if (browserType == 'ns') {

        //      var evnt = createEventObject(); //obj.ownerDocument.createEventObject();

        //      evnt.initEvent(name.slice(2), false, false);

        //      obj.dispatchEvent(evnt);

        /*

        if (!event) event = obj.ownerDocument.createEventObject();

        event.initEvent(name.slice(2), false, false);

        obj.dispatchEvent(event);

         */

        if (typeof(obj[name]) == 'function') {

            obj[name]();

        } else if (obj.getAttribute(name)) {

            eval(obj.getAttribute(name));

        }

    } else {

        obj.fireEvent(name, window.event);

    }

}



function domAttachEvent(obj, name, handler)

{

    if (browserType == 'ns') {

        obj.addEventListener(name.slice(2), handler, false);

    } else {

        obj.attachEvent(name, handler);

    }

}



function domDetachEvent(obj, name, handler)

{

    if (browserType == 'ns') {

        obj.removeEventListener(name.slice(2), handler, false);

    } else {

        obj.removeEvent(name, handler);

    }

}



function domOnLoad(handler)

{

    domAttachEvent(window, 'onload', handler);

}



function domEventGetCoords()

{

    if (window.event) {

        return {
            x:window.event.clientX,
            y:window.event.clientY
        };

    } else {

        return {
            x:window.nsevent.pageX,
            y:window.nsevent.pageY
        };

    }

}



function domEventGetTarget()

{

    if (window.event) {

        return window.event.srcElement;

    } else {

        return window.nsevent.target;

    }

}



function domEventPreventDefault()

{

    if (window.event) {

        window.event.returnValue = false;

    } else {

        window.nsevent.preventDefault();

    }

}



function domEventCancelBubble()

{

    if (window.event) {

        window.event.cancelBubble = true;

    } else {

        window.nsevent.stopPropagation();

    }

}



function domGetParent(obj, tagName)

{

    if (!tagName) {

        while (obj && obj.nodeType && obj.nodeType != 1) obj = obj.parentNode;

    } else {

        while (obj && obj.tagName && obj.tagName.toLowerCase() != tagName.toLowerCase()) obj = obj.parentNode;

    }

    return obj;

}



function domGetPrevious(obj, tagName)

{

    obj = domGet(obj);

    while (true) {

        if (obj.nodeType == 1) {

            if (typeof(tagName) == 'object') {

                for (var i=0; i<tagName.length; i++) if (tagName[i].toLowerCase() == obj.tagName.toLowerCase()) return obj;

            } else if (typeof(tagName) == 'string') {

                if (tagName.toLowerCase() == obj.tagName.toLowerCase()) return obj;

            } else {

                return obj;

            }

        }

        if (obj.previousSibling) {

            obj = obj.previousSibling;

        } else if (obj.parentNode) {

            obj = obj.parentNode;

        } else {

            return null;

        }

    }

}



function domGetNext(obj, tagName)

{

    obj = domGet(obj);

    while (true) {

        if (obj.nodeType == 1) {

            if (typeof(tagName) == 'object') {

                for (var i=0; i<tagName.length; i++) if (tagName[i].toLowerCase() == obj.tagName.toLowerCase()) return obj;

            } else if (typeof(tagName) == 'string') {

                if (tagName.toLowerCase() == obj.tagName.toLowerCase()) return obj;

            } else {

                return obj;

            }

        }

        if (obj.nextSibling) {

            obj = obj.nextSibling;

        } else if (obj.parentNode) {

            obj = obj.parentNode;

        } else {

            return null;

        }

    }

}



function domSetAlpha(obj, alpha)

{

    obj = domGet(obj);

    if (document.addEventListener) {

        obj.style.MozOpacity = parseInt(alpha)/100;

    } else {

        obj.style.filter = 'alpha(opacity='+parseInt(alpha)+', finishopacity=0, style=0)';

    }

}



function domRemove(obj)

{

    obj = domGet(obj);

    obj.parentNode.removeChild(obj);

}











var gDomSetFlashVarQueue = new Array();

var gDomSetFlashVarTimer = false;



function domSetFlashVarTimer()

{

    if (gDomSetFlashVarQueue.length == 0) {

        clearInterval(gDomSetFlashVarTimer);

        gDomSetFlashVarTimer = false;

        return;

    }

    var queueItem = gDomSetFlashVarQueue.pop();

    try {

        queueItem.obj.SetVariable(queueItem.name, queueItem.value);

    } catch (e) {

    }

    try {

        queueItem.obj.SetVariable('c.'+queueItem.name, queueItem.value);

    } catch (e) {

    }

    queueItem.count--;

    if (queueItem.count > 0) {

        gDomSetFlashVarQueue.unshift(queueItem);

    }

}



function domSetFlashVar(id, name, value)

{

    var obj = false;

    if (document.embeds) obj = document.embeds[id];

    if (!obj) obj = document.getElementById(id);

    if (!obj) return;

    var queueItem = new Object();

    queueItem.obj = obj;

    queueItem.name = name;

    queueItem.value = value;

    queueItem.count = 3;

    gDomSetFlashVarQueue.unshift(queueItem);

    if (!gDomSetFlashVarTimer) {

        gDomSetFlashVarTimer = setInterval('domSetFlashVarTimer()', 20);

    }

}

function setShopdetailsText(textfieldName, textfieldValue){
    var flashMovieName = "shopdetails";
    var obj = false;
    obj = document.getElementById(flashMovieName);

//    if (document.embeds) obj = document.embeds[flashMovieName];
//
//    if (!obj) obj = document.getElementByName(flashMovieName);

    if (!obj) return;

    obj.setProperties(textfieldName, textfieldValue);

}





if (browserType == 'ns') {

    document.addEventListener('mousedown', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('mouseup', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('mousemove', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('click', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('keyup', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('keydown', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('keypressed', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('blur', function(e) {
        window.nsevent=e;
    }, true);

    document.addEventListener('focus', function(e) {
        window.nsevent=e;
    }, true);

}



////////////////////////////////////////////////////////////////////////////////

function popup(width, height, name, url)
{
    if (!url) {
        var a = domGetParent(domEventGetTarget(), 'A');
        if (a) url = a.href;
    }
    if (url) {
        if (!name) name = '';
        var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
        if (w) {
            w.focus();
            if (window.event || window.nsevent) {
                domEventPreventDefault();
                domEventCancelBubble();
            }
            return false;
        }
    }
    return false;
}
function popupAbo(width, height, name, url)
{
    if (!url) {
        var a = domGetParent(domEventGetTarget(), 'A');
        if (a) url = a.href;
    }
    if (url) {
        if (!name) name = '';
        var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
        if (w) {
            w.focus();
            if (window.event || window.nsevent) {
                domEventPreventDefault();
                domEventCancelBubble();
            }
            return false;
        }
    }
}

function popupClose(reload)
{
    if (window.opener) {
        if (reload) if (window.opener.location) window.opener.location.reload();
        window.close();
    } else {
        history.back();
    }
}



////////////////////////////////////////////////////////////////////////////////

function changeButtons(welchen) {
    var image = welchen.src;
    var endung = (image.substr(image.length-3,3));
    if((image.substr(image.length-5,1)) == 0)  var teil = 1;
    else teil = 0;
    var newImage = (image.substring(0,image.length-5)) + teil + "." +endung;
    welchen.src = newImage;
}
/*
var F1;
function popup(ziel,breite,hoehe) {
    if(F1 && !F1.closed) {
        F1.close();
    }
    F1 = window.open(ziel, "Fenster1", "width="+breite+",height="+hoehe+",left=0,top=0");
}
 */


function bilderVorladen() {
    document.Vorladen = new Array();
    if(document.images) {
        for(var i = 0; i < bilderVorladen.arguments.length; i++) {
            document.Vorladen[i] = new Image();
            document.Vorladen[i].src = bilderVorladen.arguments[i];
        }
    }
}

function popMap(width, height, name, url)
{
    if (!url) {
        var a = domGetParent(domEventGetTarget(), 'A');
        if (a) url = a.href;
    }
    if (url) {
        if (!name) name = '';
        var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
        if (w) {
            w.focus();
            if (window.event || window.nsevent) {
                domEventPreventDefault();
                domEventCancelBubble();
            }
            return false;
        }
        else
        {
            nextpage =confirm('Bitte Deaktiviere bei deinem Browser den Popupblocker. Dieser verhindert das die Karte geladen wird. Soll nun die Karte ohne Popup angezeigt werden');
            if (nextpage) window.location.href=url;
        }
    }
}

// ############################################################
// Seitenabdeckung bei infolayern #############################
// ############################################################
function showBusyLayer() {
    var busyLayer = document.getElementById("busy_layer")
    if (busyLayer != null) {
        busyLayer.style.visibility = "visible";
        // Would be nicer to have something like window.height, but that does not work with all browsers.
        busyLayer.style.height = "850px";
    }
}

function hideBusyLayer() {
    var busyLayer = document.getElementById("busy_layer")
    if (busyLayer != null) {
        busyLayer.style.visibility = "hidden";
        busyLayer.style.height = "0px";
    }
}


/***********************************************
 * Bookmark site script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
 * This notice MUST stay intact for legal use
 * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
 ***********************************************/
function bookmarkDO(title,url){
    if (window.sidebar) {// firefox
        window.sidebar.addPanel(title, url, "");
    } else if(window.opera && window.print) { // opera
        var elem = document.createElement('a');
        elem.setAttribute('href',url);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    } else if(document.all) {// ie
        window.external.AddFavorite(url, title);
    }
}

function hideQuestDetails()
{
    $('questDetails').innerHTML = '<img src="'+CDN+'do_img/global/intro/loader_anim.gif" alt="" style="position: absolute; left: -118px; top: 28px;" />';
};

function toggleQuestChildrenVisibility(idToToggle, idOfImage, type)
{
    $('list_' + idToToggle).toggle();
    if ($('list_' + idToToggle).style.display == 'none')
    {
        $(type + '_' + idOfImage).src = CDN+'do_img/global/quests/condition_closed.gif';
    }
    else
    {
        $(type + '_' + idOfImage).src = CDN+'do_img/global/quests/condition_open.gif';
    }
}

function preloadImg() {
    document.Vorladen = new Array();

    if(document.images) {
        for(var i = 0; i < preloadImg.arguments.length; i++) {
            document.Vorladen[i] = new Image();
            document.Vorladen[i].src = preloadImg.arguments[i];
        }
    }
}

function questDetailToggle()
{
    $('questDetailTasks').toggle();
    $('questDetailDescription').toggle();
    if (!$('questDetailTasks').visible())
    {
        $('questDetailToggle').style.backgroundImage = 'url(' + CDN + '../do_img/global/quests/toggle_list.png)';
    }
    else
    {
        $('questDetailToggle').style.backgroundImage = 'url(' + CDN + '../do_img/global/quests/toggle_text.png)';
    }
}


function closeLayer (layer) {
    $(layer).style.display = 'none';
    hideBusyLayer();
}

function referToURL(webURL)
{
    if(webURL.indexOf("//") == 0) {
        webURL = webURL.substr(1,webURL.length);
    }

    if (window.opener) {
        window.opener.location.href = webURL;
        window.opener.focus();
    } else if(document.isOpenSocial) {
        showGame(document.webHost + '/' + webURL + "&openSocial=1");
    }
}

function referToExternalURL(webURL)
{
    if (window.opener) {
        window.opener.location.href = webURL;
        window.opener.focus();
    }
}

function openContextHelp() {
    showHelp();
}

function showHangar () {
    if (window.opener) {
        window.opener.location.href = 'indexInternal.es?action=internalDock';
        window.opener.focus();
    } else {
// todo: öffne neue seite mit dock-startseite
}
}

function showPetFuel () {
    if (window.opener) {
        window.opener.location.href = 'indexInternal.es?action=internalDock&category=petGear&itemId=PET_FUEL';
        window.opener.focus();
    } else {
// todo: öffne neue seite mit dock-startseite
}
}


/* Breaking News */
function BreakingNews()
{
    this.breakingNewsInterval = false;
    this.currentIconID        = 0;
    this.maxIconID            = 0;
    this.keys                 = false;
    this.images               = false;
    this.titles               = false;
    this.links                = false;
    this.durations            = false;
    this.secondsCounter       = 0;
    this.titlePosition        = 12;

    breakingNewsObject = this;

    this.setMaxIconID = function(iconCount)
    {
        this.maxIconID = iconCount - 1;
        if (this.maxIconID == 0) {
            $('breakingNewsIconContainer').hide();
        }
    };

    this.setKeys = function(array)
    {
        this.keys = array;
    };

    this.setImages = function(array)
    {
        this.images = array;
    };

    this.setTitles = function(array)
    {
        this.titles = array;
    };

    this.setLinks = function(array)
    {
        this.links = array;
    };

    this.setDurations = function(array)
    {
        this.durations = array;
    };

    this.init = function()
    {
        this.currentIconID = this.maxIconID;
        this.hardRedraw();
        window.setInterval('breakingNewsObject.scrollTitle()', 50);
    };

    this.start = function()
    {
        if (this.breakingNewsInterval == false && this.maxIconID > 0) {
            this.breakingNewsInterval = window.setInterval('breakingNewsObject.changeHighlight()', 1000);
        }
    };

    this.stop = function()
    {
        window.clearInterval(this.breakingNewsInterval);
        this.breakingNewsInterval = false;
    };

    this.changeHighlight = function()
    {
        this.secondsCounter++;
        if (this.durations[this.currentIconID] <= this.secondsCounter) {
            this.secondsCounter = 0;
            this.currentIconID--;
            if (this.currentIconID < 0) this.currentIconID = this.maxIconID;
            this.smoothRedraw();
            this.titlePosition = 12;
        }
    };

    this.smoothRedraw = function()
    {
        var myArray = $$('.breakingNewsTitle');
        for (var i = 0; i < myArray.length; i++) {
            myArray[i].innerHTML = ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ';
        }

        var helperDiv = $('breakingNewsContainer').cloneNode(true);
        helperDiv.setAttribute('id', 'breakingNewsContainerHelper');
        helperDiv.style.display = 'none';
        helperDiv.style.backgroundImage = 'url(do_img/global/events/' + this.images[this.currentIconID] + ')';

        $('breakingNewsContainer').parentNode.appendChild(helperDiv);

        Effect.Fade('breakingNewsContainer', {
            duration: 0.5
        } );
        Effect.Appear('breakingNewsContainerHelper', {
            duration: 0.5
        } );
        window.setTimeout('$(\'breakingNewsContainer\').remove(); $(\'breakingNewsContainerHelper\').setAttribute(\'id\', \'breakingNewsContainer\');', 1100);

        $('currentIconID').value = this.keys[this.currentIconID];
        $('breakingNewsContainerFrame').onclick = function() {
            showNews($('currentIconID').value)
        }

        this.redrawIcons();
    };

    this.hardRedraw = function()
    {
        var myArray = $$('.breakingNewsTitle');
        for (var i = 0; i < myArray.length; i++) {
            myArray[i].innerHTML = ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ' + this.titles[this.currentIconID] + ' --- ';
        }

        $('breakingNewsContainer').style.backgroundImage = 'url(do_img/global/events/' + this.images[this.currentIconID] + ')';
        if ($('breakingNewsContainerHelper')) $('breakingNewsContainerHelper').style.backgroundImage = 'url(do_img/global/events/' + this.images[this.currentIconID] + ')';

        $('currentIconID').value = this.keys[this.currentIconID];
        $('breakingNewsContainerFrame').onclick = function() {
            showNews($('currentIconID').value)
        }

        this.redrawIcons();
        this.titlePosition = 12;
    };

    this.redrawIcons = function()
    {
        $$('.breakingNewsIcon').each(
            function(e)
            {
                e.style.border = '1px solid black';
            }
            );
        $('breakingNewsIcon' + (this.currentIconID + 1)).style.border = '1px solid #dcdcdc';
    };

    this.scrollTitle = function()
    {
        this.titlePosition -= 2;

        var titles = $$('.breakingNewsTitle');
        for (var i = 0; i < titles.length; i++) {
            titles[i].setStyle( {
                left: this.titlePosition + 'px'
            } );
        }
    };

    this.over = function(id)
    {
        this.currentIconID = id - 1;
        this.stop();
        this.hardRedraw();
    };

    this.out = function()
    {
        this.start();
    };
}

function clientResolutionChanged(close)
{
    if (opener) {
        xajax_clientResolutionChanged(close);
    }
}

function changeTwoTab(tabID, container) {
    if (tabID == 'last') {
        $('tab_first_'+container).className = 'tab_first skylab_font_tab_unselected';
        $('tab_last_'+container).className = 'tab_end skylab_font_tab_selected';
        $('tab_first_'+container).style.backgroundColor = '#1f2021';
        $('tab_last_'+container).style.backgroundColor = '#3C3E3F';
        $('tab_separator_first_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_select_right.jpg)';
        $('tab_endseparator_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_end_select.png)';
    } else if(tabID == 'first') {
        $('tab_first_'+container).className = 'tab_first skylab_font_tab_unselected';
        $('tab_last_'+container).className = 'tab_end skylab_font_tab_unselected';
        $('tab_first_'+container).style.backgroundColor = '#3C3E3F';
        $('tab_last_'+container).style.backgroundColor = '#1f2021';
        $('tab_separator_first_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_select_left.jpg)';
        $('tab_endseparator_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_end_unselect.png)';
    }
}

function changeThreeTab(tabID, container) {
    if (tabID == 'last') {
        $('tab_first_'+container).className = 'tab_first skylab_font_tab_unselected';
        $('tab_second_'+container).className = 'tab_first skylab_font_tab_unselected';
        $('tab_last_'+container).className = 'tab_end skylab_font_tab_selected';
        $('tab_first_'+container).style.backgroundColor = '#1f2021';
        $('tab_second_'+container).style.backgroundColor = '#1f2021';
        $('tab_last_'+container).style.backgroundColor = '#3C3E3F';
        $('tab_separator_first_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_middle_unselected.jpg)';
        $('tab_separator_second_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_middle_selected_right.jpg)';
        $('tab_endseparator_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_end_select.png)';
    } else if(tabID == 'first') {
        $('tab_first_'+container).className = 'tab_first skylab_font_tab_selected';
        $('tab_second_'+container).className = 'tab_end skylab_font_tab_unselected';
        $('tab_last_'+container).className = 'tab_end skylab_font_tab_unselected';
        $('tab_first_'+container).style.backgroundColor = '#3C3E3F';
        $('tab_second_'+container).style.backgroundColor = '#1f2021';
        $('tab_last_'+container).style.backgroundColor = '#1f2021';
        $('tab_separator_first_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_select_left.jpg)';
        $('tab_separator_second_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_middle_unselected.jpg)';
        $('tab_endseparator_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_end_unselect.png)';
    } else if(tabID == 'second') {
        $('tab_first_'+container).className = 'tab_first skylab_font_tab_unselected';
        $('tab_second_'+container).className = 'tab_first skylab_font_tab_selected';
        $('tab_last_'+container).className = 'tab_end skylab_font_tab_unselected';
        $('tab_first_'+container).style.backgroundColor = '#1f2021';
        $('tab_second_'+container).style.backgroundColor = '#3C3E3F';
        $('tab_last_'+container).style.backgroundColor = '#1f2021';
        $('tab_separator_first_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_middle_selected_right.jpg)';
        $('tab_separator_second_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_select_left.jpg)';
        $('tab_endseparator_'+container).style.backgroundImage = 'url(do_img/global/pilotSheet/skylab/tab_end_unselect.png)';
    }
}

function sendTransport(mode, text) {
    $('mode').value = mode;
    if(mode == 'fast') {
        Dialog.confirm(text,
        {
            height: 100,
            width:300,
            //className: "alphacube",
            ok:function(win) {
                $('sendTransport').submit();
                return true;
            }
        });
    } else {
        $('sendTransport').submit()
    }
}

function openConfirm(myURI, text) {
    Dialog.confirm(text,
    {
        height: 100,
        width:300,
        //className: "alphacube",
        //okLabel: "OK",
        //cancelLabel: "Cancel",
        ok:function(win) {
            location.href=myURI;
            return true;
        }
    });
}

function openConfirmSkillTreeReset(text) {
    Dialog.confirm(text,
    {
        height: 100,
        width:300,
        //className: "alphacube",
        ok:function(win) {
            xajax_skillTreePurchaseSkillReset();
            return true;
        }
    });
}

function toggleTarget(target) {
    if (target == 'skylab') {
        $('to_ship').src = 'do_img/global/pilotSheet/skylab/to_ship_0.png';
        $('to_skylab').src = 'do_img/global/pilotSheet/skylab/to_skylab_1.png';
        $('but_to_ship').src = 'do_img/global/pilotSheet/skylab/but_left_0.png';
        $('but_to_skylab').src = 'do_img/global/pilotSheet/skylab/but_right_1.png';
        $('target').value = target;
    } else if (target == 'ship') {
        $('to_ship').src = 'do_img/global/pilotSheet/skylab/to_ship_1.png';
        $('to_skylab').src = 'do_img/global/pilotSheet/skylab/to_skylab_0.png';
        $('but_to_ship').src = 'do_img/global/pilotSheet/skylab/but_left_1.png';
        $('but_to_skylab').src = 'do_img/global/pilotSheet/skylab/but_right_0.png';
        $('target').value = target;
    }
}

function closeAllModules() {
    $('module_baseModule_large').hide();
    $('module_baseModule_small').show();
    $('module_solarModule_large').hide();
    $('module_solarModule_small').show();
    $('module_storageModule_large').hide();
    $('module_storageModule_small').show();
    $('module_transportModule_large').hide();
    $('module_transportModule_small').show();
    $('module_prometiumCollector_large').hide();
    $('module_prometiumCollector_small').show();
    $('module_enduriumCollector_large').hide();
    $('module_enduriumCollector_small').show();
    $('module_terbiumCollector_large').hide();
    $('module_terbiumCollector_small').show();
    $('module_prometidRefinery_large').hide();
    $('module_prometidRefinery_small').show();
    $('module_duraniumRefinery_large').hide();
    $('module_duraniumRefinery_small').show();
    $('module_promeriumRefinery_large').hide();
    $('module_promeriumRefinery_small').show();
    $('module_sepromRefinery_large').hide();
    $('module_sepromRefinery_small').show();
    $('module_xenoModule_large').hide();
    $('module_xenoModule_small').show();
}
function closaAllLargeModules() {
    jQuery('#module_baseModule_large').hide();
    jQuery('#module_solarModule_large').hide();
    jQuery('#module_storageModule_large').hide();
    jQuery('#module_transportModule_large').hide();
    jQuery('#module_prometiumCollector_large').hide();
    jQuery('#module_enduriumCollector_large').hide();
    jQuery('#module_terbiumCollector_large').hide();
    jQuery('#module_prometidRefinery_large').hide();
    jQuery('#module_duraniumRefinery_large').hide();
    jQuery('#module_promeriumRefinery_large').hide();
    jQuery('#module_sepromRefinery_large').hide();
}

var textfeld = "";
function sendFocusTransport(textfeldID) {
    textfeld = textfeldID;
    for (j = 0; j < $('sendTransport').elements.length; j++) {
        if($('sendTransport').elements[j].value == "") {
            $('sendTransport').elements[j].value = 0;
        }
    }

    if ($(textfeldID).value == "0") {
        $(textfeldID).value = "";
    }
}

function showModule(moduleName) {
    closeAllModules()
    jQuery('#module_'+moduleName+'_large').show();
    if (moduleName == 'transportModule' && textfeld != "") {
        jQuery(textfeld).focus();
    }
}

function hideModule (moduleName) {
    $('module_'+moduleName+'_large').hide();
    $('module_'+moduleName+'_small').show();
}

function showImprint() {

    // andere layer verschwinden lassen
    document.getElementById("alertBox").style.display = "none";

    showBusyLayer();
    var win = window;
    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
    container_x = document.getElementById("imprint").style.width.substr(0,document.getElementById("imprint").style.width.length-2);
    document.getElementById("imprint").style.left = ((width_x/2) - (container_x/2))+"px";
    document.getElementById("imprint").style.top = "20px";
    document.getElementById('imprint').style.display= "block";
}

function closeInfo(welcher) {
    document.getElementById(welcher).style.display = "none";
    hideBusyLayer();
}

function checkTransportTime(value, isPremium) {

    var countElements = 0;

    for (j = 0; j < $('sendTransport').elements.length; j++) {
        if ($('sendTransport').elements[j].type == 'text') {
            if (isNaN(parseInt($('sendTransport').elements[j].value)) === false) {
                countElements = countElements + parseInt($('sendTransport').elements[j].value);
            }
        }
    }

    // premium users has the half transport time.
    if (isPremium == true) {
        countElements = countElements/2;
    }

    time = (countElements * value);

    var h = Math.floor(time/60);
    var m = Math.round(time%60);

    if (m < 10) {
        m = "0" + m;
    }

    if (m == 60) {
        m = '00';
        h = h + 1;
    }

    // if you send less then 5 item the time would be 0.
    if ( countElements > 0 && h == 0 && m == 0) {
        m = "01";
    }

    if ( countElements > 0) {
        $('timeForTransport').innerHTML = h +":"+ m;
    } else {
        $('timeForTransport').innerHTML = "?";
    }
}

function do_redirect(destination, newWindow) {
    if (destination) {
        if (newWindow) {
            window.open(destination, '_blank');
        } else {
            window.open(destination, '_self');
        }
    } else {
        return false;
    }
}

function clientEvent(string)
{

}

var openSocial = 0;
function bpCloseWindow () {
    if (openSocial == 1) {
        document.location.reload();
    } else {
        self.close();
    }
}

function bpReloadOpener () {
    opener.document.location.reload();
}

function changeView4July(divID) {
    $('july4thFireworksUser').hide();
    $('july4thFireworksFaction').hide();
    $('july4thFireworksClan').hide();
    if (divID == 'july4thFireworksUser') {
        $('july4thFireworksUser').show();
    } else if (divID == 'july4thFireworksFaction') {
        $('july4thFireworksFaction').show();
    } else if (divID == 'july4thFireworksClan') {
        $('july4thFireworksClan').show();

    }
}

function openPayment(type, id) {
    var external = window.open('/indexInternal.es?action=internalPayment&subaction=showDynamicItem&type='+escape(type)+'&itemID='+escape(id), "paymentglobal", "width=840,height=680,left=100,top=200");
    external.focus();
}

function onTechExpired() {
    if (window.opener) {
        window.opener.location.href = "indexInternal.es?action=internalNanoTechFactory";
    }
}

var imgObj = {
    'imgUrl': ""
}

function setImgUrl(key, val) {
    imgObj[key] = val;
}

function getImgUrl(key) {
    return imgObj[key];
}


var pilotSheet = new PilotSheet();
function PilotSheet(){
    this.messageStats = null;
    this.hideInviteButton = function(flag){
        var element = $('inviteButt');
        if(element){
            switch(flag){
                case 'show':
                    element.style.display = 'block';
                    break;
                case 'hide':
                    element.style.display = 'none';
                    break;
            }
        }
    }

    this.ajaxLoader = function(flag){
        var mask = $('pppAjaxLoaderMask');
        var loader = $('pppAjaxLoader');
        switch(flag){
            case 'show':
                mask.style.display = 'block';
                loader.style.display = 'block';
                break;
            case 'hide':
                mask.style.display = 'none';
                loader.style.display = 'none';
                break;
        }
    }

    this.bgMask = function(flag){
        var mask = $('pppAjaxLoaderMask');
        switch(flag){
            case 'show':
                mask.style.display = 'block';
                break;
            case 'hide':
                mask.style.display = 'none';
                break;
        }
    }

    this.successTimer = null;
    this.failureTimer = null;
    this.editMessage = function(flag, stat, type){
        var statDivSucess;
        var statDivFailed;
        var logElement;
        if(type == 'profile'){
            statDivSucess = $('editStatsSuccessProfile');
            statDivFailed = $('editStatsFailedProfile');
        }else if(type == 'statusMessage'){
            statDivSucess = $('editStatsSuccessMess');
            statDivFailed = $('editStatsFailedMess');
        }else if(type == 'bonusLog'){
            logElement = $('bonuslogBookStatus');
        }

        switch(flag){
            case 'show':
                switch(stat){
                    case 'success':
                        if(statDivFailed){
                            if(statDivFailed.hasClassName('showEditStatsFailed')){
                                statDivFailed.removeClassName('showEditStatsFailed');
                                statDivFailed.addClassName('hideEditStatsFailed');
                            }
                        }
                        if(statDivSucess.hasClassName('hideEditStatsSuccess')){
                            statDivSucess.removeClassName('hideEditStatsSuccess');
                            statDivSucess.addClassName('showEditStatsSuccess');
                        }
                        pilotSheet.successTimer = window.setTimeout(function(){
                            pilotSheet.editMessage('hide', 'success', type);
                        }, 5000);
                        break;
                    case 'failed':
                        if(statDivSucess){
                            if(statDivSucess.hasClassName('showEditStatsSuccess')){
                                statDivSucess.removeClassName('showEditStatsSuccess');
                                statDivSucess.addClassName('hideEditStatsSuccess');
                            }
                        }
                        if(statDivFailed.hasClassName('hideEditStatsFailed')){
                            statDivFailed.removeClassName('hideEditStatsFailed');
                            statDivFailed.addClassName('showEditStatsFailed');
                        }
                        pilotSheet.failureTimer = window.setTimeout(function(){
                            pilotSheet.editMessage('hide', 'failed', type);
                        }, 5000);
                        break;
                    case 'noLog':
                        if(logElement){
                            if(logElement.hasClassName('hideBonusLogBook')){
                                logElement.removeClassName('hideBonusLogBook');
                                logElement.addClassName('showBonusLogBook');
                            }
                            window.setTimeout(function(){
                                pilotSheet.editMessage('hide', 'noLog', type);
                            }, 5000);
                        }
                        break;
                }
                break;
            case 'hide':
                switch(stat){
                    case 'success':
                        if(statDivSucess.hasClassName('hideEditStatsSuccess')){
                            return;
                        }
                        if(statDivFailed){
                            if(statDivFailed.hasClassName('showEditStatsFailed')){
                                statDivFailed.removeClassName('showEditStatsFailed');
                                statDivFailed.addClassName('hideEditStatsFailed');
                            }
                        }
                        if(statDivSucess.hasClassName('showEditStatsSuccess')){
                            statDivSucess.removeClassName('showEditStatsSuccess');
                            statDivSucess.addClassName('hideEditStatsSuccess');
                        }
                        break;
                    case 'failed':
                        if(statDivFailed.hasClassName('hideEditStatsFailed')){
                            return;
                        }
                        if(statDivSucess){
                            if(statDivSucess.hasClassName('showEditStatsSuccess')){
                                statDivSucess.removeClassName('showEditStatsSuccess');
                                statDivSucess.addClassName('hideEditStatsSuccess');
                            }
                        }
                        if(statDivFailed.hasClassName('showEditStatsFailed')){
                            statDivFailed.removeClassName('showEditStatsFailed');
                            statDivFailed.addClassName('hideEditStatsFailed');
                        }
                        break;
                    case 'noLog':
                        if(logElement.hasClassName('showBonusLogBook')){
                            logElement.removeClassName('showBonusLogBook');
                            logElement.addClassName('hideBonusLogBook');
                        }
                        break;
                }
                break;
        }
    }
    this.checkedIn = false;

    this.initialiseCustomSelectElements = function(){
        this.checkedIn = false;
    }

    this.handleProfileEditForm = function(id, id1, className, type){
        var element = jQuery('#'+id);
        var editElement = jQuery('#editFormProfileAll');
        var formElement = jQuery('#editFormProfile');
        var closeElement = jQuery('#closeButtonEdit');
        var statDivSucess = jQuery('#editStatsSuccessProfile');
        var statDivFailed = jQuery('#editStatsFailedProfile');
        var formValues = new Array();
        formValues['type'] = 'editProfileForm';
        switch(type){
            case 'show':
               if(!this.checkedIn){
                    Custom.init();
                    this.checkedIn = true;
                }
                if(statDivSucess){
                    if(statDivSucess.hasClass('showEditStatsSuccess')){
                        statDivSucess.removeClass('showEditStatsSuccess');
                        statDivSucess.addClass('hideEditStatsSuccess');
                    }
                    clearTimeout(pilotSheet.successTimer);
                }
                if(statDivFailed){
                    if(statDivFailed.hasClass('showEditStatsFailed')){
                        statDivFailed.removeClass('showEditStatsFailed');
                        statDivFailed.addClass('hideEditStatsFailed');
                    }
                    clearTimeout(pilotSheet.failureTimer);
                }
                //                element.style.display = 'none';
                if(formElement.hasClass('removeForm')){
                    formElement.removeClass('removeForm')
                    closeElement.removeClass('removeForm')
                }
                formElement.addClass('elevateForm');
                closeElement.addClass('elevateForm');
                editElement.css('display', 'block');
                closeElement.css('display', 'block');
                pilotSheet.bgMask('show');
                break;

            case 'hide':
                element.style.display = 'none';
                pilotSheet.ajaxLoader('show');
                break;
        }

    }

    this.handleProfilePage = function(id, type){
        var formValues = new Array();
        formValues['type'] = type;
        var element = jQuery('#'+id);
        var formElement = jQuery('#editFormProfile');
        var editForm = jQuery('#editForm');
        var closeElement = jQuery('#closeButtonEdit');

        switch(type){
            case 'editUserProfile':
                var len = 0;
                var month_00;
                var day_00;
                var year_00;
                var month_0;
                var day_0;
                var year_0;
                var sex_0;
                var country_0;
                var city_0;
                var interest_0;
                var contact_0;

                var inputs = jQuery('#hiddenProfileEles :input');
                jQuery.each(inputs, function(){
                    if(this.name == 'day_00'){
                        day_00  = jQuery(this).val();
                    }
                    if(this.name == 'month_00'){
                        month_00 = jQuery(this).val();
                    }
                    if(this.name == 'year_00'){
                        year_00 = jQuery(this).val();
                    }
                    if(this.name == 'month_0'){
                        month_0 = jQuery(this).val();
                    }
                    if(this.name == 'day_0'){
                        day_0 = jQuery(this).val();
                    }
                    if(this.name == 'year_0'){
                        year_0 = jQuery(this).val();
                    }
                    if(this.name == 'sex_0'){
                        sex_0 = jQuery(this).val();
                    }
                    if(this.name == 'country_0'){
                        country_0 = jQuery(this).val();
                    }
                    if(this.name == 'city_0'){
                        city_0 = jQuery(this).val();
                    }
                    if(this.name == 'interest_0'){
                        interest_0 = jQuery(this).val();
                    }
                    if(this.name == 'contact_0'){
                        contact_0 = jQuery(this).val();
                    }
                });

                 /*   alert(month_00);
                    die();
                var hiddenProfileStuff = $('hiddenProfileEles');
                var day_00 = hiddenProfileStuff['day_00'];
                var month_00 = hiddenProfileStuff['month_00'];
                var year_00 = hiddenProfileStuff['year_00'];
                var day_0 = hiddenProfileStuff['day_0'];
                var month_0 = hiddenProfileStuff['month_0'];
                var year_0 = hiddenProfileStuff['year_0'];
                var sex_0 = hiddenProfileStuff['sex_0'];
                var country_0 = hiddenProfileStuff['country_0'];
                var city_0 = hiddenProfileStuff['city_0'];
                var interest_0 = hiddenProfileStuff['interest_0'];
                var contact_0 = hiddenProfileStuff['contact_0'];*/

                if(formElement.hasClass('elevateForm')){
                    formElement.removeClass('elevateForm')
                    closeElement.removeClass('elevateForm')
                }
                formElement.addClass('removeForm');
                closeElement.addClass('removeForm');

                if(parseInt(day_0) == parseInt(jQuery('#itemSelectedDay').val()) && parseInt(month_0) == parseInt(jQuery('#itemSelectedMonth').val()) && parseInt(year_0) == parseInt(jQuery('#itemSelectedYear').val())){
                    len += 1;
                }

                if(sex_0 == jQuery('#itemSelectedSex').val() || jQuery('#itemSelectedSex').val() == ''){
                    len += 1;
                }
                if(country_0 == jQuery('#itemSelectedCountry').val() || jQuery('#itemSelectedCountry').val() == ''){
                    len += 1;
                }
                if(city_0 == jQuery('#cityTextbox').val() || jQuery('#cityTextbox').val() == ''){
                    len += 1;
                }
                if(interest_0 == jQuery('#interestTextbox').val() || jQuery('#interestTextbox').val() == ''){
                    len += 1;
                }
                if(contact_0 == jQuery('#contactTextbox').val() || jQuery('#contactTextbox').val() == ''){
                    len += 1;
                }
                pilotSheet.bgMask('hide');

                if(len != 6){
                    if(jQuery('#itemSelectedDay').val() == '--' || jQuery('#itemSelectedMonth').val() == '--' || jQuery('#itemSelectedYear').val() == '----'){
                        formValues['age'] = 0;
                    }else{
                        if(parseInt(day_00) == parseInt(jQuery('#itemSelectedDay').val()) && parseInt(month_00) == parseInt(jQuery('#itemSelectedMonth').val()) && parseInt(year_00) == parseInt(jQuery('#itemSelectedYear').val()) || parseInt(year_00) == parseInt(jQuery('#itemSelectedYear').val())){
                            formValues['age'] = 0;
                        }else{
                            formValues['age'] = 1;
                        }

                        formValues['day'] = jQuery('#itemSelectedDay').val();
                        formValues['month'] = jQuery('#itemSelectedMonth').val();
                        formValues['year'] = jQuery('#itemSelectedYear').val();
                    }
                    formValues['sex'] = jQuery('#itemSelectedSex').val();
                    formValues['country'] = jQuery('#itemSelectedCountry').val()
                    formValues['city'] = jQuery('#cityTextbox').val();
                    formValues['interest'] = jQuery('#interestTextbox').val();
                    formValues['contact'] = jQuery('#contactTextbox').val();
                    formValues['actionType'] = 'edited';
                    formValues['imgUrl'] = getImgUrl('imgUrl');

                    pilotSheet.ajaxLoader('show');
                    xajax_pilotSheet(formValues);
                    formValues['type'] = 'showProfilePage';
                    formValues['actionType'] = 'edited';
                    formValues['imgUrl'] = getImgUrl('imgUrl');
                    xajax_pilotSheet(formValues);
                }else{
                    pilotSheet.handleProfilePage('closeButton', 'closeEditProfile')
                    pilotSheet.editMessage("show", "failed", "profile")
                }
                break;
            case 'closeEditProfile':
                if(formElement.hasClass('elevateForm')){
                    formElement.removeClass('elevateForm')
                    closeElement.removeClass('elevateForm')
                }
                formElement.addClass('removeForm')
                closeElement.addClass('removeForm')
                pilotSheet.bgMask('hide');
                if(jQuery('#editFormProfileAll')){
                    jQuery('#editFormProfileAll').css('display', 'none');
                }
                closeElement.css('display', 'none');
                break;
            case 'profilePage':
                pilotSheet.ajaxLoader('show');
                tooltip.destroyEventListerners();
                formValues['type'] = 'showProfilePage';
                formValues['imgUrl'] = getImgUrl('imgUrl');
                xajax_pilotSheet(formValues);
                break;
            case 'statusMessage':
                var statMessForm = $('statsMessForm');
                var hiddenMess = statMessForm['statsMess'];
                var message = element.value;
                if(hiddenMess.getValue() == message){
                    pilotSheet.editMessage("show", "failed", "statusMessage")
                    return;
                }else{
                    hiddenMess.setValue(message);
                    formValues['message'] = message;
                    xajax_pilotSheet(formValues);
                }
                break;
        }
    }

    this.handleSkilltree = function(type, flag){
        var formValues = new Array();
        formValues['type'] = type;
        formValues['imgUrl'] = getImgUrl('imgUrl');
        switch(type){
            case 'showSkilltree':
                tooltip.destroyEventListerners();
                pilotSheet.ajaxLoader('show');
                xajax_pilotSheet(formValues);
                break;
            case 'convertPoints':
                tooltip.destroyEventListerners();
                pilotSheet.ajaxLoader('show');
                var element = $('researchpoints');
                var current = element.innerHTML;
                formValues['currentValue'] = current;
                formValues['label'] = flag;
                xajax_pilotSheet(formValues);
                break;
            case 'deactivateLogButton':
                var logButton = $('researchPoints_button_1');
                var logArrow = $('arrow_logfile_1');
                var researchPointArrow = $('researchPoints_arrow_1');
                logArrow.id = 'arrow_logfile_0';
                researchPointArrow.id = 'researchPoints_arrow_0'
                var logButtonLink = logButton.firstChild;
                logButton.innerHTML = '';

                var logSpan = new Element('span', {
                    'class':'font_inactive'
                });

                logButton.appendChild(logSpan);

                var strongEle = new Element('strong', {});
                logSpan.appendChild(strongEle);
                strongEle.innerHTML= flag;
                logButton.id = 'researchPoints_button_0';
                break;
        }
    }

    this.setSkilltreeScrollbar = function(){
        var skillTreeHorSlider = new Control.Slider('skillTreeHorHandleCover', 'skillTreeHorTrack', {
            onSlide: function(v) {
                pilotSheet.scrollHorizontal(v, $('skillTreeHorScrollable'), skillTreeHorSlider);
            },
            onChange: function(v) {
                pilotSheet.scrollHorizontal(v, $('skillTreeHorScrollable'), skillTreeHorSlider);
            }
        });

        // disable horizontal scrolling if text doesn't overflow the div
        if ($('skillTreeHorScrollable').scrollWidth <= $('skillTreeHorScrollable').offsetWidth) {
            skillTreeHorSlider.setDisabled();
            $('skillTreeHorTrack').hide();
        }

    }

    // scroll the element horizontally based on its width and the slider maximum value
    this.scrollHorizontal = function(value, element, slider){
        element.scrollLeft = Math.round(value/slider.maximum*(element.scrollWidth-element.offsetWidth));
    }

}

var inviteIncentives = new PilotInviteIncentives();
function PilotInviteIncentives(){
    this.initialiseScrollBar = function(){
        /*alert(jQuery('.scroll-pane').html());*/
        jQuery('.scroll-pane').jScrollPane({showArrows: true});
    };

    this.hideInfoLayerPermanently = function(id){
        var userValues = xajax.getFormValues(id);
        var val = document.inviteInfoDisplayOpton.inviteInfoCheckbox.checked;
        if(val){
            var formValues = new Array();
            formValues['type'] = 'hideInviteInfo';
            xajax_pilotInviteIncentives(formValues);
            inviteIncentives.handleIncentives("setInfoValue", 1)
        }else{
            return;
        }
    }

    this.mailInviteCallback = function(data){
        if(typeof(data) == 'undefined'){
            return;
        }else{
            this.handleIncentives('showIncentivePage', 'callback');
        }
    }

    this.handleIncentives = function(type, flag){
        var elementBg = null;
        var inviteInfo = null;
        var inviteInfoInput = null;
        var inviteInfoForm = $('inviteInfoForm');
        var formValues = new Array();
        var busyLayer = $('busy_layer');
        formValues['type'] = type;
        formValues['imgUrl'] = getImgUrl('imgUrl');
        switch(type){
            case 'showIncentivePage':
                formValues['inviteType'] = 'Email';
                formValues['flag'] = flag;

                inviteInfoInput = inviteInfoForm['inviteInfo']
                inviteInfo = $(inviteInfoInput).getValue();
                if(flag != 'callback'){
                    if(inviteInfo != 1 || inviteInfo ==''){
                        inviteIncentives.handleIncentives('showInfoLayer')
                    }
                }

                xajax_pilotInviteIncentives(formValues);
                tooltip.destroyEventListerners();
                pilotSheet.ajaxLoader('show');
                //                }
                break;
            case 'closeInfoLayer':
                inviteIncentives.hideInfoLayerPermanently('inviteInfoDisplayOpton');
                if($('inviteInfoPopup') != null){
                    if($('inviteInfoPopup').hasClassName('showinviteInfoPopup')){
                        $('inviteInfoPopup').removeClassName('showinviteInfoPopup')
                        $('inviteInfoPopup').addClassName('hideinviteInfoPopup');
                    }
                }

                hideBusyLayer();
                break;
            case 'showInfoLayer':
                showBusyLayer();
                if($('inviteInfoPopup') != null){
                    if($('inviteInfoPopup').hasClassName('hideinviteInfoPopup')){
                        $('inviteInfoPopup').removeClassName('hideinviteInfoPopup');
                        $('inviteInfoPopup').addClassName('showinviteInfoPopup');
                    }
                }
                break;
            case 'setInfoValue':
                inviteInfoInput = inviteInfoForm['inviteInfo']
                $(inviteInfoInput).setValue(flag);
                break;
        }

    }
    this.handleInvites = function(type){
        var formValues = new Array();
        formValues['type'] = type;
        formValues['imgUrl'] = getImgUrl('imgUrl');

        switch(type){
            case 'showInvitePage':
                pilotSheet.hideInviteButton('hide');
                if($('editFormProfileAll')){
                    $('editFormProfileAll').style.display = 'none';
                }
                xajax_pilotInviteIncentives(formValues);
                break;
        }
    }

    this.handleRemoveInvitee = function(id, type, flag){
        var element = $(id);
        var formValues = new Array();
        formValues['type'] = type;
        switch(type){
            case 'handleImage':
                if(element.hasClassName('hideRemoveInvitee')){
                    element.removeClassName('hideRemoveInvitee');
                    element.addClassName('showRemoveInvitee');
                }else if(element.hasClassName('showRemoveInvitee')){
                    element.removeClassName('showRemoveInvitee');
                    element.addClassName('hideRemoveInvitee');
                }
                break;
            case 'imageEffect':
                switch(flag){
                    case 'rollin':
                        if(element.hasClassName('hideRemoveInvitee')){
                            element.removeClassName('hideRemoveInvitee');
                            element.addClassName('showRemoveInvitee');
                        }
                        if(element.hasClassName('removeInviteeInActive')){
                            element.removeClassName('removeInviteeInActive');
                            element.addClassName('removeInviteeActive');
                        }else if(element.hasClassName('removeInviteeActive')){
                            return;
                        }
                        break;
                    case 'rollout':
                        if(element.hasClassName('showRemoveInvitee')){
                            element.removeClassName('showRemoveInvitee');
                            element.addClassName('hideRemoveInvitee');
                        }
                        if(element.hasClassName('removeInviteeActive')){
                            element.removeClassName('removeInviteeActive');
                            element.addClassName('removeInviteeInActive');
                        }else if(element.hasClassName('removeInviteeInActive')){
                            return;
                        }
                        break;
                }
                break;
            case 'removeInvitee':
                var parts = id.split('_');
                var userID = parts[1];
                var rightEle = $('middleRight_' + parts[1]);
                formValues['userID'] = userID;
                if(element && rightEle){
                    element.addClassName('hideListElement');
                    rightEle.addClassName('hideListElement');
                }
                xajax_pilotInviteIncentives(formValues);
                break;
        }
    }

    this.handleLogBook = function(id, type, no){
        var logElementDiv = jQuery('#bonusLogBook');
        var logElementClose = jQuery('#closeButtonBonusLog');
        switch(type){
            case 'toggleLink':
                var logLink = jQuery('#'+id);
                if(logLink.hasClass('bonusLogBookLinkActive')){
                    logLink.removeClass('bonusLogBookLinkActive');
                    logLink.addClass('bonusLogBookLinkInActive');
                }else if(logLink.hasClass('bonusLogBookLinkInActive')){
                    logLink.removeClass('bonusLogBookLinkInActive');
                    logLink.addClass('bonusLogBookLinkActive');
                }
                break;
            case 'showLog':
                if(no <= 0){
                    pilotSheet.editMessage('show', 'noLog', 'bonusLog');
                }else{
                    if(logElementDiv.hasClass('hideBonusLogBook')){
                        logElementDiv.removeClass('hideBonusLogBook');
                        logElementDiv.removeClass('removeForm');
                        logElementDiv.addClass('showBonusLogBook');
                        logElementDiv.addClass('elevateForm');
                    }
                    if(logElementClose){
                        if(logElementClose.hasClass('removeForm')){
                            logElementClose.removeClass('removeForm');
                            logElementClose.removeClass('hideBonusLogBook');
                            logElementClose.addClass('showBonusLogBook');
                            logElementClose.addClass('elevateForm');
                        }
                    }
                    pilotSheet.bgMask('show');
                    /*jQuery(".logBookBox").jScrollPane({showArrows: true});*/
                    /* Each time we call the function Scroller.reset, the previous scrollbar is removed and a new one is created
                     * If we are hiding and showing an element, it is important, to make sure that its scrollbar stays thesame, or
                     * else some of the Eventlisteners will not work. That is why Scroller.reset(), is called only once*/
                    /*misc.testForScrollbar('logBookBox');*/
                    /*inviteIncentives.initialiseScrollBar();*/
                }
                break;
            case 'closeLogBook':
                if(logElementDiv){
                    if(logElementDiv.hasClass('showBonusLogBook')){
                        logElementDiv.removeClass('showBonusLogBook');
                        logElementDiv.addClass('hideBonusLogBook');
                        logElementDiv.addClass('removeForm');
                    }
                    if(logElementClose){
                        if(logElementClose.hasClass('elevateForm')){
                            logElementClose.removeClass('elevateForm');
                            logElementClose.removeClass('showBonusLogBook');
                            logElementClose.addClass('hideBonusLogBook');
                            logElementClose.addClass('removeForm');
                        }
                    }
                    pilotSheet.bgMask('hide');
                }
                break;
        }
    }
}

var pilotInvites = new PilotInvites();
function PilotInvites(){
    this.handleInvites = function(type, flag){
        var formValues = new Array();
        var element = $('pilotInvitePage');

        var inviteTab = $('inviteTab');
        var dailyLoginTab = $('loginBonusTab');
        var subTabInvite = $('subTabInvite');
        var subTabDailyLogin = $('subTabLoginBonus');

        var invitePageDiv = $('inviteContent')
        var dailyLoginPageDiv = $('loginBonus');
        formValues['type'] = type;
        formValues['imgUrl'] = getImgUrl('imgUrl');
        switch(type){
            case 'showInvitePage':
                dailyLoginPageDiv.style.display= 'none';
                invitePageDiv.style.display = 'block';
                pilotSheet.hideInviteButton('show');

                dailyLoginTab.removeClassName('inviteTabActive');
                dailyLoginTab.removeClassName('inviteTabRollOver')
                dailyLoginTab.addClassName('inviteTabInActive');
                subTabDailyLogin.removeClassName('subTabLabelActive');
                subTabDailyLogin.addClassName('subTabLabelInActive');

                inviteTab.removeClassName('inviteTabInActive');
                inviteTab.addClassName('inviteTabActive');
                subTabInvite.removeClassName('subTabLabelInActive');
                subTabInvite.addClassName('subTabLabelActive');

                break;
            case 'showLoginBonus':
                var val = parseInt(flag);
                var current = val + 1;
                pilotSheet.hideInviteButton('hide');
                invitePageDiv.style.display = 'none';
                dailyLoginPageDiv.style.display= 'block';

                inviteTab.removeClassName('inviteTabActive');
                inviteTab.removeClassName('inviteTabRollOver');
                inviteTab.addClassName('inviteTabInActive');
                subTabInvite.removeClassName('subTabLabelActive');
                subTabInvite.addClassName('subTabLabelInActive');

                dailyLoginTab.removeClassName('inviteTabInActive');
                dailyLoginTab.addClassName('inviteTabActive');
                subTabDailyLogin.removeClassName('subTabLabelInActive');
                subTabDailyLogin.addClassName('subTabLabelActive');

                if(val <= 5){
                    $('boniProgress').addClassName('boniProgress_' + val);
                    $('boni_' + val).addClassName('boniHeadNextBg');
                    $('boniText_' + val).addClassName('boniHeadCurrent');
                    val = --val;
                    while(val > 0){
                        $('boniHead_' + val).addClassName('boniHeadReceived');
                        $('boniText_' + val).addClassName('boniHeadReceived');
                        $('boniIcon_' + val).addClassName('boniHeadReceivedBg');
                        val = --val;
                    }
                    while(current < 6 ){
                        $('boniHead_' + current).addClassName('boniHeadOpen');
                        $('boniText_' + current).addClassName('boniHeadOpen');
                        current = ++current;
                    }
                }else{
                    for(i=1; i<6; i++){
                        $('boniProgress').addClassName('boniProgress_' + i);
                        $('boniText_' + i).addClassName('boniHeadReceived');
                        $('boniIcon_' + i).addClassName('boniHeadReceivedBg');
                        $('boniHead_' + i).addClassName('boniHeadReceived');
                    }
                }
                break
            case 'hideInvitePage':
                element.removeClassName('pilotInvitePageShow');
                subTabInvite.removeClassName('subTabLabelActive');
                inviteTab.removeClassName('inviteTabActive');
                inviteTab.addClassName('inviteTabInActive');
                element.addClassName('pilotInvitePageHide');
                subTabInvite.addClassName('subTabLabelInActive');
                break;
            case 'handleEmailInvite':
                var emails = new Array('vibanterence@yahoo.com', 'T.Viban@bigpoint.net');
                formValues['invitee'] = emails;
                formValues['inviteType'] = 'Email';
                formValues['message'] = 'Yo come and play with me, cool game';
                xajax_pilotInvite(formValues);
                break;
        }
    }

    this.handleShowInviteMask = function(messLabel, lang){
        jQuery('#exposeMask').css('display', 'block');
        jQuery('#exposeMask').addClass('changeBGColor');

        var buttElement = jQuery('.button-area');
        var formEle = jQuery('#invite-form');
        formEle.css('display', 'block');

        var inviteSend = jQuery('#invite-send');
        inviteSend.html('');

        var imgTag = jQuery(document.createElement('img'))
                .attr({src: 'do_img/global/text_tf.esg?l='+lang+'&s=13&t=pilot_invite_incentive_page_send_invitation&f=eurostyle_tmed&bgcolor=green&color=white'})
                .addClass('imgButtonMailInvite')
                .appendTo(inviteSend);

        var spanEle = jQuery(document.createElement('span')).appendTo(inviteSend);
        var divEle = jQuery(document.createElement('text')).addClass('messLabel').appendTo(spanEle).html(messLabel);

        var inviteNew = jQuery('.invite-new');
        inviteNew.html('');
        var spanEleNew = jQuery(document.createElement('span')).appendTo(inviteNew);
        var imgTagNew = jQuery(document.createElement('img'))
                .attr({src: 'do_img/global/text_tf.esg?l='+lang+'&s=11&t=pilot_invite_incentive_page_invite_more&f=eurostyle_tmed&bgcolor=green&color=white'})
                .addClass('imgButtonMailInvite')
                .appendTo(spanEleNew);
    }
}

var buttonHandler = new ButtonHandler();
function ButtonHandler(){
    this.toggleButtons = function(id, className, labelID, classNameLabel){
        if(!$(id).hasClassName(className + 'Active')){
            $(labelID).classNames().each(
                function(name, index) {
                    if (name.endsWith('InActive')) {
                        $(labelID).removeClassName(name);
                        $(labelID).addClassName(name.sub("InActive", "Active"));
                    } else {
                        $(labelID).removeClassName(name);
                        $(labelID).addClassName(name.sub("Active", "InActive"));
                    }
                }
            );

            $(id).classNames().each(
                function(name, index) {
                    if (name.endsWith('InActive')) {
                        $(id).removeClassName(name);
                        $(id).addClassName(name.sub("InActive", "RollOver"));
                    } else {
                        $(id).removeClassName(name);
                        $(id).addClassName(name.sub("RollOver", "InActive"));
                    }
                }
            );
        }
    }

    this.toggleCloseButton = function(id, className){
        var element = $(id);
        element.cleanWhitespace(element);
        if(!element.hasClassName(className + 'RollOver')){
            element.removeClassName(className + 'InActive');
            element.addClassName(className + 'RollOver');
        }else{
            element.removeClassName(className + 'RollOver');
            element.addClassName(className + 'InActive');
        }
    }

    this.clickedTabButton = function(id, number, className, labelID, classNameLabel){
        var tabArray = new Array();
        var tabLabelArray = new Array();
        var element = $(id);
        var label = $(labelID);
        while(number != 0){
            tabArray.push(className + number);
            tabLabelArray.push(classNameLabel + number);
            number--;
        }
        tabArray.each(function(item){
            if(item != id){
                var itemElement = $(item);
                if(itemElement){
                    if(itemElement.hasClassName('deactivateCursor')){
                        itemElement.removeClassName('deactivateCursor');
                        itemElement.addClassName('activateCursor');
                    }
                    itemElement.removeClassName(className + 'Active')
                    itemElement.removeClassName(className + 'RollOver')
                    itemElement.addClassName(className + 'InActive');
                }
            }
        });

        tabLabelArray.each(function(item){
            if(item != id){
                var itemElement = $(item);
                if(itemElement){
                    itemElement.removeClassName(classNameLabel + 'Active')
                    itemElement.addClassName(classNameLabel + 'InActive');
                }
            }
        });

        element.removeClassName(className + 'RollOver')
        element.removeClassName(className + 'InActive');
        element.removeClassName('activateCursor');
        element.addClassName(className + 'Active');
        element.addClassName('deactivateCursor');
        label.removeClassName(classNameLabel + 'InActive');
        label.addClassName(classNameLabel + 'Active');

    }
}

var misc = new Miscellaneous();

function Miscellaneous(){
    this.createJsCssElement = function(filename, filetype){
        var fileref;
        switch(filetype){
            case 'js':
                fileref=document.createElement('script')
                fileref.setAttribute("type","text/javascript")
                fileref.setAttribute("src", filename)
                break;
            case'css':
                fileref=document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", filename)
                break;
        }
        return fileref;
    }

    this.replaceJsCssFile = function(oldFilename, newFilename, filetype){
        var targetAttribute;
        var elementsOfInterest;
        var newElement;

        switch(filetype){
            case 'js':
                targetAttribute = 'src';
                elementsOfInterest = $$('script');
                break;
            case 'css':
                targetAttribute = 'href';
                elementsOfInterest = $$('link');
                break;
        }

        elementsOfInterest.each(function(item){
            var itemElement = $(item);
            if(itemElement && itemElement.getAttribute(targetAttribute) != null && itemElement.getAttribute(targetAttribute).indexOf(oldFilename) != -1){
                newElement = misc.createJsCssElement(newFilename, filetype);
                itemElement.parentNode.replaceChild(newElement, itemElement);
            }
        });
    }

    this.addJsCssFile = function(newFilename, filetype){

        var targetAttribute;
        var elementsOfInterest;
        var newElement;

        switch(filetype){
            case 'js':
                targetAttribute = 'src';
                elementsOfInterest = $$('script');
                break;
            case 'css':
                targetAttribute = 'href';
                elementsOfInterest = $$('link');
                break;
        }
        var itemElement = $(elementsOfInterest[0]);
        newElement = misc.createJsCssElement(newFilename, filetype);
        itemElement.parentNode.appendChild(newElement);
    }


    this.removeJsCssFile = function(filename, filetype){
        var targetAttribute;
        var elementsOfInterest;
        var newElement;
        switch(filetype){
            case 'js':
                targetAttribute = 'src';
                elementsOfInterest = $$('script');
                break;
            case 'css':
                targetAttribute = 'href';
                elementsOfInterest = $$('link');
                break;
        }

        elementsOfInterest.each(function(item){
            var itemElement = $(item);
            if(itemElement && itemElement.getAttribute(targetAttribute) != null && itemElement.getAttribute(targetAttribute).indexOf(filename) != -1){
                itemElement.parentNode.removeChild(itemElement);
            }
        });
    }

    this.customScrollbar = function(){
        var scrollbar = new Control.ScrollBar('scrollbar_content','scrollbar_track');
    }

    this.customScrollbarLog = function(){
        var scrollbarLogBook = new Control.ScrollBar('scrollbar_content_logBook','scrollbar_track_logBook');
    }
}

function openExternal (address) {
    var external = window.open(address.replace(/\+/g,"%2B"), "paymentglobal", "width=840,height=680,left=100,top=200");
    external.focus();
}

function schliessen(layerID) {
    $(layerID).hide();
    hideBusyLayer();
}
function checkKey(code) {
    if (code==27) {
        if ($("infoPopup").style.display = "block") {
            $("infoPopup").style.display = "none";
            hideBusyLayer();
        }
    }
}

function showMessageDeleteOtherQuests(text) {
    alert(text);
}

function number_format( number, decimals, dec_point, thousands_sep ) {

    var n = number, prec = decimals, dec = dec_point, sep = thousands_sep;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    sep = sep == undefined ? ',' : sep;

    var s = n.toFixed(prec),
        abs = Math.abs(n).toFixed(prec),
        _, i;

    if (abs > 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec || '.');
    } else {
        s = abs.replace('.', dec_point);
    }

    return s;
}

function isChrome() {
    return  navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
}
