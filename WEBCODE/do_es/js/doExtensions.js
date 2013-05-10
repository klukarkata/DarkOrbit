/**
 * center an element
 * use: jQuery(element).center()
 */
//
jQuery.fn.center = function (direction) {
    this.css("position","absolute");
    if (direction == 'horizontal') {
        this.css("left", ( jQuery(window).width() - this.width() ) / 2+jQuery(window).scrollLeft() + "px");
    } else if (direction == 'vertical') {
        this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
    } else {
        this.css("top", ( jQuery(window).height() - this.height() ) / 2+jQuery(window).scrollTop() + "px");
        this.css("left", ( jQuery(window).width() - this.width() ) / 2+jQuery(window).scrollLeft() + "px");
    }
    return this;
}
