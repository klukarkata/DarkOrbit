var tooltip = new Tooltip();

function Tooltip(){
    this.tooltipID = null;
    var mouse_x;
    var mouse_y;
    var topVar;
    var leftVar;
    var toolTipElement;
    var idToBlock;
    var top;
    var left;
    var div1;
    var div2;
    var outerDiv;
    var innerDiv;
    var containerLeft;
    var containerTop;
    var containerTotal

    this.init = function(){

        if($('customTooltip') == undefined){
            var tipDiv = new Element('div', {
                'id': 'customTooltip'
            });

            document.body.insertBefore(tipDiv, document.body.childNodes[0]);
            tipDiv.style.top = 0;
            tipDiv.style.width = 100 + 'px';
            tipDiv.style.height = 100 + 'px';
            tipDiv.style.display = 'none';
        }
        
        var elementsOfInterest = $$('.customTooltip');
        
        this.eventMouseOver = this.onMouseOverCustomTooltip.bindAsEventListener(this);
        this.eventMouseOut   = this.hideCustomTooltip.bindAsEventListener(this);
        this.eventMouseMove  = this.moveCustomTooltip.bindAsEventListener(this);

        elementsOfInterest.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                tooltip.registerEventListerners(itemElement);
            }
        });
    }

    this.registerEventListerners = function(element){
        Event.observe(element, "mouseover", this.eventMouseOver);
        Event.observe(element, "mouseout", this.eventMouseOut);
        Event.observe(element, "mousemove", this.eventMouseMove);
    }

    this.UnregisterEventListerners = function(element){
        Event.stopObserving(element, "mouseover", this.eventMouseOver);
        Event.stopObserving(element, "mouseout", this.eventMouseOut);
        Event.stopObserving(element, "mousemove", this.eventMouseMove);
    }

    this.onMouseOverCustomTooltip = function(e){
        var formValues = new Array();
        var loadType;
        var type;
        
        mouse_x = Event.pointerX(e);
        mouse_y = Event.pointerY(e);
        top = parseInt(mouse_y);
        left = parseInt(mouse_x);

        var eventTriggerElement = Event.element(e);
        var classNames = eventTriggerElement.classNames();

        classNames.each(function(item){
            if(item.indexOf('loadType_') != -1){
                loadType = item.substr(9);
            }else if(item.indexOf('id_') != -1){
                idToBlock = item.substr(3);
            }else if(item.indexOf('type_') != -1){
                type = item.substr(5);
            }else if(item.indexOf('inner_') != -1){
                div1 = item.substr(6);
            }else if(item.indexOf('outer_') != -1){
                div2 = item.substr(6);
            }else if(item.indexOf('top_') != -1){
                topVar = parseInt(item.substr(4));
            }else if(item.indexOf('left_') != -1){
                leftVar = parseInt(item.substr(5));
            }
        });

        if($(div1) != null && $(div2)!= null){
            innerDiv = $(div1).positionedOffset();
            outerDiv = $(div2).positionedOffset();
            containerLeft = innerDiv[0] + outerDiv[0];
            containerTop  = innerDiv[1] + outerDiv[1];
            containerTotal = containerTop + $(div1).getHeight();

            if(loadType == 'normal'){
                var content = $(idToBlock).innerHTML;
                var toolTipEle = $('customTooltip');
                toolTipEle.innerHTML = content;
            }else if(loadType == 'ajax'){
                formValues['type'] = type;
                formValues['id'] = eventTriggerElement.id;
                xajax_tooltipAjaxHandler(formValues);
            }
        }
    }

    this.moveCustomTooltip = function(e){
        var toolTipEle = $(idToBlock);
        mouse_x = (document.all) ? window.event.clientX + 25 : e.pageX + 25;
        mouse_y = (document.all) ? window.event.clientY - 50 + document.documentElement.scrollTop : e.pageY - 50;

        if (toolTipEle != null) {
            if ((mouse_x + toolTipEle .getWidth()) > (containerLeft + $(div1).getWidth())) {
                left    = mouse_x - leftVar;
            } else {
                left    = mouse_x;
            }

            if (mouse_y + toolTipEle .getHeight() + 40 > containerTotal) {
                top     = containerTotal - toolTipEle .getHeight() + topVar;
            } else {
                top     = mouse_y;
            }
        }
        this.showCustomTooltip();
    }

    this.showCustomTooltip = function(){
        toolTipElement = $('customTooltip');
        toolTipElement.setStyle({
            position: 'absolute',
            opacity: 1,
            top: top + 'px',
            left: left + 'px',
            zIndex: 50
        });
        toolTipElement.show();
    }

    this.hideCustomTooltip = function(){
        toolTipElement = $('customTooltip');
        toolTipElement.setStyle({
            top: 0,
            left: 0,
            opacity: 0,
            zIndex: 0
        });
        toolTipElement.innerHTML = '';
        toolTipElement.hide();
    }

    this.destroyEventListerners = function(){
        var elementsOfInterest = $$('.customTooltip');

        elementsOfInterest.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                tooltip.UnregisterEventListerners(itemElement);
            }
        });
    }
}





