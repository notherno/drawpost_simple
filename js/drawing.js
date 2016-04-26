/*
 * DrawCanvas
 */
'use strict';

var DrawCanvas = (function() {
    function DrawCanvas(canvasid, width, height) {
        this.canvas = document.getElementById(canvasid);
        this.context = this.canvas.getContext('2d');

        this.width = this.canvas.width = width;
        this.height = this.canvas.height = height;

        this.history = [];
        this.history_pointer = null;

        this.addEvents();
        this.started = false;

        this.initialize();
    }

    DrawCanvas.prototype.can_undo = function () {
        if (this.history_pointer == 0) {
            return false;
        } else {
            return true;
        }
    };

    DrawCanvas.prototype.can_redo = function () {
        if (this.history_pointer == this.history.length - 1) {
            return false;
        } else {
            return true;
        }
    };

    DrawCanvas.prototype.undo = function () {
        if (this.can_undo()) {
            this.putImage(this.history[--this.history_pointer]);
        }
        return this.can_undo();
    };

    DrawCanvas.prototype.redo = function () {
        if (this.can_redo()) {
            this.putImage(this.history[++this.history_pointer]);
        }
        return this.can_redo();
    };

    DrawCanvas.prototype.add_history = function () {
		if (this.history_pointer === null) {
			this.history_pointer = 0;
		} else {
            while (canvas.history.length - 1 != canvas.history_pointer) {
                this.history.pop();
            }
			this.history_pointer++;
		}
		this.history.push(this.getImage());
    };

    DrawCanvas.prototype.getImage = function () {
        return this.context.getImageData(0, 0, this.width, this.height);
    };

    DrawCanvas.prototype.putImage = function (imgData) {
        return this.context.putImageData(imgData, 0, 0);
    };

    DrawCanvas.prototype.addEvents = function() {
        var that = this;

        var find_pos = function (ev) {
            var x, y;

            // pageX, pageY are coordinates from
            // top-left corner of the page
            if (ev.targetTouches) {
                x = ev.targetTouches[0].pageX;
                y = ev.targetTouches[0].pageY;
            } else {
                x = ev.pageX;
                y = ev.pageY;
            }

            var p = ev.target;
            while (p !== null) {
                // Trace DOM tree and subtract
                // offsets of all parent DOM objects
                x -= p.offsetLeft;
                y -= p.offsetTop;
                p = p.offsetParent;
            }

            return {x: x, y: y};
        };

        var line_start = function(ev) {
            var pos = find_pos(ev);

            that.context.beginPath();
            that.context.moveTo(pos.x, pos.y);
            that.started = true;
            ev.preventDefault();
        };

        var line_move = function(ev) {
            if (that.started) {
                var pos = find_pos(ev);

                that.context.lineTo(pos.x, pos.y);
                that.context.stroke();
                ev.preventDefault();
            }
        };

        var line_end = function(ev) {
            that.started = false;

            that.add_history();
            ev.preventDefault();
        };

        // Add event listeners to the canvas
        var binding_events = {
            'mousedown': line_start,
            'touchstart': line_start,
            'mouseup': line_end,
            'touchend': line_end,
            'mousemove': line_move,
            'touchmove': line_move
        };

        for (var trig in binding_events) {
            this.canvas.addEventListener(trig, binding_events[trig], false);
        }
    };

    DrawCanvas.prototype.initialize = function() {
        this.context.fillStyle = '#FFF';
        this.context.fillRect(0, 0, this.width, this.height);
        this.add_history();

        // Line properties
        this.context.lineJoin = 'round';
        this.context.lineCap = 'round';
        this.context.shadowBlur = 1;
        this.context.shadowColor = '#333';
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

