/*
 * DrawCanvas
 */

var DrawCanvas = (function() {
    function DrawCanvas(canvasid, width, height) {
        this.canvas = document.getElementById(canvasid);
        this.context = this.canvas.getContext('2d');

        this.width = this.canvas.width = width;
        this.height = this.canvas.height = height;

        this.addEvents();
        this.started = false;

        this.initialize();
    }

    DrawCanvas.prototype.addEvents = function() {
        var that = this;

        var line_start = function(ev) {
            that.context.beginPath();
            that.context.moveTo(ev.layerX, ev.layerY);
            that.started = true;
        };

        var line_move = function(ev) {
            if (that.started) {
                that.context.lineTo(ev.layerX, ev.layerY);
                that.context.stroke();
            }
        };

        var line_end = function(ev) {
            that.started = false;
        };

        // Add event listeners to the canvas
        this.canvas.addEventListener('mousedown', line_start, false);
        this.canvas.addEventListener('mouseup', line_end, false);
        this.canvas.addEventListener('mousemove', line_move, false);
    };

    DrawCanvas.prototype.initialize = function() {
        this.context.fillStyle = '#FFF';
        this.context.fillRect(0, 0, this.width, this.height);

        // Line properties
        this.context.lineJoin = 'bevel';
        this.context.lineCap = 'round';
        this.context.setLineDash([]);
    };

    DrawCanvas.prototype.submitImg = function(url, param) {
        var dataurl = this.canvas.toDataURL(),
            canvas = this,
            params = '';

        for (var key in param) {
            params += ('&' + key + '=' + encodeURIComponent(param[key]));
        }
        var data = 'img=' + encodeURIComponent(dataurl) + params;

        var request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(data);

        request.onreadystatechange = function() {
            if (request.readyState === 4) {
                switch (request.status) {
                    case 200:
                        alert('Success');
                        break;
                    case 400:
                        alert('Invalid request');
                        break;
                    default:
                        alert('Error occured');
                }
                canvas.initialize();
            }
        };
    };

    return DrawCanvas;
})();
