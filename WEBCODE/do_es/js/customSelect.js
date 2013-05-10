/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 * viban terence
 * 20.12.2010
 */

var customSelect = new Select();

function Select(){
    var idSel;
    var idList;
    var listElements;
    var scrollbar;
    var scrollbarVar;

    var boxes= new Array('listBoxDay', 'listBoxMonth', 'listBoxYear', 'listBoxSex', 'listBoxCountry');
    this.init = function(){
        var arrowElements = $$('.arrowSelectInactive');
        var selectedItems= $$('.itemSelected');
        var listboxes = $$('.listBox');

        this.eventClick = this.toggleDropDown.bindAsEventListener(this);
        this.eventSelect = this.SelectOption.bindAsEventListener(this);
        this.eventMouseOver = this.onMouseOverCustomSelect.bindAsEventListener(this);
        this.eventMouseOut   = this.onMouseOutCustomSelect.bindAsEventListener(this);
        this.eventOnBlur   = this.onBlur.bindAsEventListener(this);

        selectedItems.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                customSelect.registerToggleEvent(itemElement);
            }
        });

        arrowElements.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                customSelect.registerToggleEvent(itemElement);
            }
        });
    }

    this.registerEventListerners = function(element){
        Event.observe(element, "mouseover", this.eventMouseOver);
        Event.observe(element, "mouseout", this.eventMouseOut);
        Event.observe(element, "click", this.eventSelect);
    }

    this.UnregisterEventListerners = function(element){
        Event.stopObserving(element, "mouseover", this.eventMouseOver);
        Event.stopObserving(element, "mouseout", this.eventMouseOut);
        Event.stopObserving(element, "click", this.eventSelect);
    }

    this.registerToggleEvent = function(element){
        Event.observe(element, "click", this.eventClick);
    }

    this.UnregisterToggleEvent = function(element){
        Event.stopObserving(element, "click", this.eventClick);
    }

    this.registerOnEvent = function(element){
        Event.observe(element, "blur", this.eventOnBlur);
    }

    this.UnregisterOnEvent = function(element){
        Event.stopObserving(element, "blur", this.eventOnBlur);
    }


    this.toggleDropDown = function(e){
        var eventTriggerElement = Event.element(e);
        var classNames = eventTriggerElement.classNames();
        var listBox;
        var selBox;
        var scroll;
       
        classNames.each(function(item){
            if(item.indexOf('idList_') != -1){
                listBox  = item.substr(7);
            }else if(item.indexOf('idSel_') != -1){
                selBox = item.substr(6);
            }
        });
       
        idList = $(listBox);
        idSel= $(selBox);
        
        boxes.each(function(item){
            if(item != listBox){
                var itemElement = $(item);
                if(itemElement){
                    itemElement.removeClassName('arrowDown');
                    itemElement.addClassName('arrowUp');
                }
            }
        });

        if(idList){
            if(idList.hasClassName('arrowDown')){
                idList.removeClassName('arrowDown');
                idList.addClassName('arrowUp');
            }else{
                 if(listBox.indexOf('Day') != -1){
                    misc.testForScrollbar('listDayBox');
                }else if(listBox.indexOf('Month') != -1){
                    misc.testForScrollbar('listMonthBox');
                }else if(listBox.indexOf('Year') != -1){
                    misc.testForScrollbar('listYearBox');
                }else if(listBox.indexOf('Country') != -1){
                    misc.testForScrollbar('listCountryBox');
                }
                idList.removeClassName('arrowUp');
                idList.addClassName('arrowDown');
                listElements = $$('li.' + listBox + '_options');
                listElements.each(function(item){
                    var itemElement = $(item);
                    if(itemElement){
                        customSelect.registerEventListerners(itemElement);
                    }
                });
            }
        }    
    }

    this.SelectOption = function(e){
        var eventTriggerElement = Event.element(e);
        
        listElements.each(function(item){
            var itemElement = $(item);
            if(itemElement.hasClassName('selectedItem')){
                itemElement.removeClassName('selectedItem');
            }
        });

        if(!eventTriggerElement.hasClassName('selectedItem')){
            eventTriggerElement.addClassName('selectedItem');
        }
        
        var content = eventTriggerElement.innerHTML;
       
        idSel.innerHTML = content;
        idList.removeClassName('arrowDown');
        if(scrollbar){
            scrollbar.removeClassName('arrowDown');
            scrollbar.addClassName('arrowUp');
        }
        idList.addClassName('arrowUp');
    }



    this.onMouseOverCustomSelect = function(e){
        var eventTriggerElement = Event.element(e);
        eventTriggerElement.addClassName('customSelectOver');
    }

    this.onMouseOutCustomSelect = function(e){
        var eventTriggerElement = Event.element(e);
        eventTriggerElement.removeClassName('customSelectOver');
    }

    this.onBlur = function(e){
        var eventTriggerElement = Event.element(e);
    }

    this.destroyEventListerners = function(){
        var arrowElements = $$('.arrowSelectInactive');
        var selectedItems= $$('.itemSelected');
        var listboxes = $$('.listBox');

        boxes.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                if(itemElement.hasClassName('arrowDown')){
                    itemElement.removeClassName('arrowDown');
                    itemElement.addClassName('arrowUp');
                }
            }
        });

        selectedItems.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                customSelect.UnregisterToggleEvent(itemElement);
            }
        });

        arrowElements.each(function(item){
            var itemElement = $(item);
            if(itemElement){
                customSelect.UnregisterToggleEvent(itemElement);
            }
        });
    }
}


