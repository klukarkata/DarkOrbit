/*
Class: Scroller
    Adds a scrollbar to a specific div. The scrollbar is implemented using a Script.aculo.us slider.
    The class reparents the original div, creates a slider and ties the reparented div to the slider,
    setting any properties necessary on the divs to make it all work. The scrollbar can be styled using
    CSS. The track of the scrollbar has class 'scroll-track', 'scroll-track-top' and 'scroll-track-bot',
    the thumb has class 'scroll-handle', 'scroll-handle-top' and 'scroll-handle-bot'.

properties:
    myIndex - an integer used to generate a unique ID for use in, for example, div ids.
    outerBox - the div that holds the scrollpane + scrollbar
    innerBox - the div that holds the scrollpane
    innerHeight - the height of the inner box.
    viewportHeight - the height of the view onto the scrolled div.
    track - a div that holds the script.aculo.us slider (the scrollbar)
    trackHeight - the height of the slider
    handle - the div for the 'thumb' of the scrollbar
    handleHeight - the height of the thumb
    slider - the script.aculo.us slider itself
    ieDecreaseBy - a fudge factor used when calculating the width of innerBox

*/
var Scroller = Class.create();

/*
property: Scroller.ids
    A cache of Scrollers indexed by the ID of the original div.
 */
Scroller.ids = new Object();

/*
property: Scroller.i
    A unique ID generator.
 */
Scroller.i = 0;

Scroller.prototype = {
    /*
    constructor: initialize
        Wrap the passed div in a scrollpane.

    parameters:
        el - the div to add a scrollbar to.
     */
    initialize: function(el) {
        this.outerBox = el;
        this.decorate();
    },

    /*
  function: decorate
    create the necessary elements to implement the scrollbar and wire up events.
   */
    decorate: function() {
        $(this.outerBox).makePositioned(); // Fix IE

        // Seed a unique ID
        Scroller.i = Scroller.i + 1;
        this.myIndex = Scroller.i;

        //wrap the existing content in an intermediate inner box
        this.innerBox = document.createElement("DIV");
        this.innerBox.className="scroll-innerBox";
        $(this.innerBox).makePositioned();  // Fix IE
        this.innerBox.style.cssFloat=this.innerBox.style.styleFloat='left'; // Need the scrollbar to appear next to the scrollpane
        this.innerBox.id="scroll-innerBox-"+Scroller.i;
        this.innerBox.style.top = "0px";

        //Transfer the contents of Outer Box to Inner Box
        while (this.outerBox.hasChildNodes()) {
            this.innerBox.appendChild(this.outerBox.firstChild);
        }
        this.innerBox.style.overflow="hidden";
        //turn off scrolling on the outer div
        this.outerBox.style.overflow="hidden";

        // create a track
        this.track=document.createElement('div');
        this.track.className="scroll-track";
        $(this.track).makePositioned();
        this.track.style.cssFloat=this.track.style.styleFloat='left';
        this.track.id="scroll-track-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.track.appendChild(document.createComment(''));

        // Create the top button
        this.tracktop=document.createElement('div');
        this.tracktop.className="scroll-track-top";
        $(this.tracktop).makePositioned();
        this.tracktop.style.cssFloat=this.tracktop.style.styleFloat='left';
        this.tracktop.id="scroll-track-top-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.tracktop.appendChild(document.createComment(''));

        // Create the bottom button
        this.trackbot=document.createElement('div');
        this.trackbot.className="scroll-track-bot";
        $(this.trackbot).makePositioned();
        this.trackbot.style.cssFloat=this.trackbot.style.styleFloat='left';
        this.trackbot.id="scroll-track-bot-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.trackbot.appendChild(document.createComment(''));

        // Create the handle
        this.handle=document.createElement('div');
        this.handle.className="scroll-handle-container";
        this.handle.id="scroll-handle-container"+Scroller.i;

        // Create the handle middle
        this.handle_middle=document.createElement('div');
        this.handle_middle.className="scroll-handle";
        $(this.handle_middle).makePositioned();
        this.handle_middle.id="scroll-handle-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.handle_middle.appendChild(document.createComment(''));

        // Create the handle top cap
        this.handletop=document.createElement('div');
        this.handletop.className="scroll-handle-top";
        $(this.handletop).makePositioned();
        this.handletop.id="scroll-handle-top-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.handletop.appendChild(document.createComment(''));

        // Create the handle bottom cap
        this.handlebot=document.createElement('div');
        this.handlebot.className="scroll-handle-bot";
        $(this.handlebot).makePositioned();
        this.handlebot.id="scroll-handle-bot-"+Scroller.i;
        // Fix IE line-height bug. Sigh.
        this.handlebot.appendChild(document.createComment(''));

        this.track.hide();
        this.tracktop.hide();
        this.trackbot.hide();

        this.outerBox.appendChild(this.innerBox);
        this.outerBox.appendChild(this.tracktop);
        this.handle.appendChild(this.handletop);
        this.handle.appendChild(this.handle_middle);
        this.handle.appendChild(this.handlebot);
        this.track.appendChild(this.handle);
        this.outerBox.appendChild(this.track);
        this.outerBox.appendChild(this.trackbot);

        this.slider = new Control.Slider($(this.handle).id, $(this.track).id, {
            axis:'vertical',
            minimum: 0,
            maximum: $(this.outerBox).clientHeight
        });
        this.slider.options.onSlide = this.slider.options.onChange = this.onChange.bind(this);
        setTimeout(this.resetScrollbar.bind(this, false), 10);

        this.domMouseCB = this.MouseWheelEvent.bindAsEventListener(this, this.slider);
        this.mouseWheelCB = this.MouseWheelEvent.bindAsEventListener(this, this.slider);
        this.trackTopCB = this.tracktopEvent.bindAsEventListener(this, this.slider);
        this.trackBotCB = this.trackbotEvent.bindAsEventListener(this, this.slider);
        this.trackEventMouseOverCB = this.trackMouseOverEvent.bindAsEventListener(this, this.slider);
        this.trackEventMouseOutCB   = this.trackMouseOutEvent.bindAsEventListener(this, this.slider);

        //Events control
        $(this.outerBox).observe('DOMMouseScroll', this.domMouseCB); // Mozilla
        $(this.outerBox).observe('mousewheel', this.mouseWheelCB);// IE/Opera
        $(this.tracktop).observe('mousedown', this.trackTopCB);
        $(this.trackbot).observe('mousedown', this.trackBotCB);
        $(this.tracktop).observe('mouseover', this.trackEventMouseOverCB);
        $(this.tracktop).observe('mouseout', this.trackEventMouseOutCB);
        $(this.trackbot).observe('mouseover', this.trackEventMouseOverCB);
        $(this.trackbot).observe('mouseout', this.trackEventMouseOutCB);
    },

    release: function() {
        $(this.outerBox).stopObserving('DOMMouseScroll', this.domMouseCB);
        $(this.outerBox).stopObserving('mousewheel', this.mouseWheelCB);// IE/Opera
        $(this.tracktop).stopObserving('mousedown', this.trackTopCB);
        $(this.trackbot).stopObserving('mousedown', this.trackBotCB);
        $(this.tracktop).stopObserving('mouseover', this.trackEventMouseOver);
        $(this.tracktop).stopObserving('mouseout', this.trackEventMouseOut);
        $(this.trackbot).stopObserving('mouseover', this.trackEventMouseOverCB);
        $(this.trackbot).stopObserving('mouseout', this.trackEventMouseOutCB);
    },

    /*
  function: resetScrollbar
    Re-calculate the geometry of the scrollbar. Typically called from an event handler.

    args:
        repeat - if true, set timer to re-calculate to fix IE bug on resize window.
   */
    resetScrollbar: function(repeat) {
        this.track.hide();
        this.tracktop.hide();
        this.trackbot.hide();
        this.enableScroll = false;
        this.innerHeight = $(this.outerBox).clientHeight;
        this.innerBox.style.height = this.innerHeight + "px";
        var newWidth = $(this.outerBox).clientWidth;

        var tth = Element.getStyle(this.tracktop,"height");
        if (tth)
            tth = tth.replace("px","");
        else
            tth = 0;

        var hth = Element.getStyle(this.handletop,"height");
        if (hth)
            hth = hth.replace("px","");
        else
            hth = 0;

        if (this.innerHeight < this.innerBox.scrollHeight) {
            this.viewportHeight = this.innerHeight - tth*2;
            this.slider.trackLength = this.viewportHeight;
            this.track.style.height = this.viewportHeight + "px";
            this.handleHeight = Math.round(this.viewportHeight * this.innerHeight / this.innerBox.scrollHeight);
            if(this.handleHeight < (hth*2))
                this.handleHeight = (hth*2);
            if (this.handleHeight < 10)
                this.handleHeight = 10;
            this.handle.style.height = this.handleHeight + "px";
            this.handle_middle.style.height = this.handleHeight - hth*2 + "px";
            this.handletop.style.height = hth + "px";
            this.slider.handleLength = this.handleHeight;
            this.track.style.display = 'inline';
            this.tracktop.style.display = 'inline';
            this.trackbot.style.display = 'inline';
            this.ieDecreaseBy = 1;   // Firefox seems to have an off-by one error, so allow for it.
            if (this.outerBox.currentStyle) {
                var borderWidth = this.outerBox.currentStyle["borderWidth"].replace("px","");
                if(!isNaN(borderWidth)) {
                    this.ieDecreaseBy = (borderWidth) * 2;
                }
            }
            newWidth = ($(this.outerBox).clientWidth - $(this.track).clientWidth - this.ieDecreaseBy);
            this.enableScroll = true;
        }
        //Set the width of of the scrollpane (aka innerBox).
        this.innerBox.style.width = newWidth + "px";
        //Fix IE resize event Bug
        if(repeat) {
            setTimeout(this.resetScrollbar.bind(this, false), 10);
        }
    },

    //Mouse wheel code from http://adomas.org/javascript-mouse-wheel/
    MouseWheelEvent: function(event, slider) {
        var delta = 0;
        if (!event) //For IE.
            event = window.event;
        if (event.wheelDelta) { //IE/Opera.
            delta = event.wheelDelta / 120;
        /*if (window.opera) //In Opera 9, delta differs in sign as compared to IE
                delta = -delta;   But it isn't necessary with Opera v9.51*/
        } else if (event.detail) { //Mozilla case
            delta = -event.detail / 3;
        }
        if (delta)
            slider.setValueBy(-delta / 10);
        Event.stop(event);
    },

    trackbotEvent: function(event, slider) {
        if (Event.isLeftClick(event)) {
            slider.setValueBy(0.2);
            Event.stop(event);
        }
    },

    tracktopEvent: function(event, slider) {
        if (Event.isLeftClick(event)) {
            slider.setValueBy(-0.2);
            Event.stop(event);
        }
    },

    trackMouseOverEvent: function(event, slider){
        var eventTriggerElement = Event.element(event);
        if(eventTriggerElement.hasClassName('scroll-track-top')){
            eventTriggerElement.removeClassName('scroll-track-top');
            eventTriggerElement.addClassName('scroll-track-top-active');
        }else if(eventTriggerElement.hasClassName('scroll-track-bot')){
            eventTriggerElement.removeClassName('scroll-track-bot');
            eventTriggerElement.addClassName('scroll-track-bot-active');
        }
    },

    trackMouseOutEvent: function(event, slider){
        var eventTriggerElement = Event.element(event, slider);
        if(eventTriggerElement.hasClassName('scroll-track-top-active')){
            eventTriggerElement.removeClassName('scroll-track-top-active');
            eventTriggerElement.addClassName('scroll-track-top');
        }else if(eventTriggerElement.hasClassName('scroll-track-bot-active')){
            eventTriggerElement.removeClassName('scroll-track-bot-active');
            eventTriggerElement.addClassName('scroll-track-bot');
        }
    },

    /*
  function: onChange
    Called when the script.aculo.us slider has changed (i.e. when it has been dragged). Scroll the inner box.

    args:
        val - not used.
   */
    onChange: function(val) {
        if(this.enableScroll)
            this.innerBox.scrollTop = Math.round (val * (this.innerBox.scrollHeight-this.innerBox.offsetHeight));
    }
}

/*
function: Scroller.setAll
    Search for divs of the class 'makeScroll' and wrap them in a Scroller.
 */
Scroller.setAll = function () {
    $$('.makeScroll').each(function(item) {
        Scroller.ids[item.id] = new Scroller(item);
    });
}

/*
function: Scroller.reset
    If the passed element has class 'makeScroll', wrap it in a Scroller.
 */
Scroller.reset = function (body_id) {
    if ($(body_id).className.match(new RegExp("(^|\\s)makeScroll(\\s|$)"))) {
        if (Scroller.ids[body_id])
            Scroller.ids[body_id].release();

        Scroller.ids[body_id] = new Scroller($(body_id));
    }
}

/*
property: Scroller.updateAll
    Reset all of the scrollbars.
 */
Scroller.updateAll = function () {
    $H(Scroller.ids).each(function(pair) {
        Scroller.ids[pair.key].resetScrollbar(true);
    });
}

/*
    Hook up some global event handlers.
 */
//Event.observe(window, "load", Scroller.setAll);
//Event.observe(window, "resize", Scroller.updateAll);