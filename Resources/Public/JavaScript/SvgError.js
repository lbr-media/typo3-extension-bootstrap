"use strict";
/**
 * Animation used in for the SVG:
 * app/public/typo3conf/ext/base_app/Resources/Private/Templates/Page/403.html
 * app/public/typo3conf/ext/base_app/Resources/Private/Templates/Page/404.html
 */
class SvgError {
    constructor() {
        // svg element
        this.svg = null;
        this.lines = null;
        // blinking block at the end of the text
        this.block = null;
        this.points = [];
        // font inactive class
        this.fontInactiveClass = 'svgerror__font--inactive';
        // time unit - one animation step
        this.timeUnit = 400;
        this.waitTime = 1500;
        this.svg = document.querySelector('#svgerror');
        this.lines = this.svg.querySelectorAll('.svgerror__font');
        this.block = this.svg.querySelector('.svgerror__block');
        this.points = [
            this.svg.querySelector('.svgerror__point1'),
            this.svg.querySelector('.svgerror__point2'),
            this.svg.querySelector('.svgerror__point3'),
        ];
        this.animateLines();
        this.animateBlock();
        this.animatePoints();
    }
    animateLines() {
        let waitTime = this.waitTime;
        for (let l = 0; l < this.lines.length; l++) {
            this.lines[l].style.display = 'none';
            switch (l) {
                default:
                case 0: // Determine state ...
                    waitTime += 0;
                    break;
                case 1: // State is 'Error 404 - Page not found'.
                    waitTime += 800;
                    break;
                case 2: // Starting subroutine with 404 and superhero ...
                    waitTime += 800;
                    break;
                case 3: // > Invoke search engine ...
                    waitTime += 300;
                    break;
                case 4: // > Invoke private call to Chuck Norris ...
                    waitTime += 200;
                    break;
                case 5: // > Search engine loaded
                    waitTime += 1000;
                    break;
                case 6: // > Waiting until Chuck picks up the phone ...
                    waitTime += 200;
                    break;
                case 7: // > http-se:bin sun$ _
                    waitTime += 200;
                    break;
            }
            window.setTimeout(function (line) {
                line.style.display = 'block';
            }, waitTime, this.lines[l]);
        }
    }
    animateBlock() {
        this.block.style.transition = 'ease-in-out 0.3s';
        let _this = this;
        window.setInterval(function () {
            if (_this.block.classList && _this.block.classList.toggle) {
                _this.block.classList.toggle(_this.fontInactiveClass);
            }
        }, this.timeUnit * 3);
    }
    animatePoints() {
        let _this = this;
        for (let p = 0; p < this.points.length; p++) {
            // hide
            this.points[p].classList.add(this.fontInactiveClass);
            // show again after a while
            window.setTimeout(function (point) {
                point.classList.remove(_this.fontInactiveClass);
            }, (p + 1) * this.timeUnit, this.points[p]);
        }
        window.setTimeout(function () {
            _this.animatePoints();
        }, this.timeUnit * 5);
    }
}
new SvgError();
