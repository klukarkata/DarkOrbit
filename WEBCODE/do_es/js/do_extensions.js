/*
Centers an element to the viewport. If a parent is
given, the element is positioned relative to this
parent. If a height is given, this height is used
for the element instead of centering it to the viewport
respectively to the parent element.

@param element          element to position
@param parent[optional] element to be centered in
@param height[optional] height for the element
*/
Element.Center = function(element, parent, height)
{
    var w, h, pw, ph;
    var d = Element.getDimensions(element);
    w = d.width;
    h = d.height;
    if (!parent) {
        var ws = document.viewport.getDimensions();
        pw = ws.width;
        ph = ws.height;
    } else {
        var ws = parent.getDimensions();
        pw = ws.width;
        ph = ws.height;
    }
    if (!height) height = ((ph/2) - (h/2));
    element.style.top = height + 'px';
    element.style.left = ((pw/2) - (w/2)) + 'px';
}