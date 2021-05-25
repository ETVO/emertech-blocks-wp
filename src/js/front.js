// get all SVG objects in the DOM
var svgs = document.getElementsByTagName("svg");

// go through each one and add a viewbox that ensures all children are visible
for (var i=0, l=svgs.length; i<l; i++) {

    var svg = svgs[i],
        box = svg.getBBox(), // <- get the visual boundary required to view all children
        viewBox = [box.x, box.y, box.width, box.height].join(" ");

    // set viewable area based on value above
    svg.setAttribute("viewBox", viewBox);
}