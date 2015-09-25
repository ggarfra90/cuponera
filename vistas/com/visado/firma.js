var canvas;
var context;
var canvasWidth = 200;
var canvasHeight = 100;
var clickX = new Array();
var clickY = new Array();
var clickDrag = new Array();
var paint;
$(document).ready(function () {
    prepareCanvas();
});
function borrarFirma(){
    clickX = new Array();
    clickY = new Array();
    clickDrag = new Array();
    clearCanvas();
}
function getImagenFirma(){
    var canvas = document.getElementById("canvas");
    return canvas.toDataURL("image/png");
}
/**
 * Clears the canvas.
 */
function clearCanvas()
{
    context.clearRect(0, 0, canvasWidth, canvasHeight);
}
/**
 * Creates a canvas element, loads images, adds events, and draws the canvas for the first time.
 */
function prepareCanvas()
{
    // Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
    var canvasDiv = document.getElementById('canvasDiv');
    canvas = document.createElement('canvas');
    canvas.setAttribute('width', canvasWidth);
    canvas.setAttribute('height', canvasHeight);
    canvas.setAttribute('id', 'canvas');
    canvasDiv.appendChild(canvas);
    if (typeof G_vmlCanvasManager != 'undefined') {
        canvas = G_vmlCanvasManager.initElement(canvas);
    }
    context = canvas.getContext("2d"); // Grab the 2d canvas context
    // Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
    //     context = document.getElementById('canvas').getContext("2d");
    $('#canvas').mousedown(function (e) {
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;

        paint = true;
        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
        redraw();
    });
    $('#canvas').mousemove(function (e) {
        if (paint) {
            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
            redraw();
        }
    });
    $('#canvas').mouseup(function (e) {
        paint = false;
    });
    $('#canvas').mouseleave(function (e) {
        paint = false;
    });

    $('#clearCanvas').mousedown(function (e)
    {
        clickX = new Array();
        clickY = new Array();
        clickDrag = new Array();
        clearCanvas();
    });
    $('#saveCanvas').mousedown(function (e)
    {
        copy();
    });
}


/**
 * Adds a point to the drawing array.
 * @param x
 * @param y
 * @param dragging
 */
function addClick(x, y, dragging)
{
    clickX.push(x);
    clickY.push(y);
    clickDrag.push(dragging);
}

/**
 * Clears the canvas.
 */
function clearCanvas()
{
    context.clearRect(0, 0, canvasWidth, canvasHeight);
}

/**
 * Redraws the canvas.
 */
function redraw() {
    context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas

    context.strokeStyle = "#2B5FC5";
    context.lineJoin = "round";
    context.lineWidth = 2;

    for (var i = 0; i < clickX.length; i++) {
        context.beginPath();
        if (clickDrag[i] && i) {
            context.moveTo(clickX[i - 1], clickY[i - 1]);
        } else {
            context.moveTo(clickX[i] - 1, clickY[i]);
        }
        context.lineTo(clickX[i], clickY[i]);
        context.closePath();
        context.stroke();
    }
}

function copy()
{
    var imgData = context.getImageData(0, 0, 400, 200);
    console.log(imgData);
    context.putImageData(imgData, 0, 0);
}