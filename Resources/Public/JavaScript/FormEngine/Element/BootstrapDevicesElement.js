/**
 * @package typo3-extension-bootstrap - Typo3 template extension with Twitter Bootstrap 5 package.
 * @version 1.0.15
 * @author Marcel <mb@lbrmedia.de>
 * @date Wed, 09 Mar 2022 09:17:33 GMT
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */
function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function _defineProperties(e,t){for(var s=0;s<t.length;s++){var n=t[s];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function _createClass(e,t,s){return t&&_defineProperties(e.prototype,t),s&&_defineProperties(e,s),Object.defineProperty(e,"prototype",{writable:!1}),e}define((function(){return function(){function e(t){_classCallCheck(this,e),this.values=["","","","","",""],this.hiddenInput=document.getElementById(t+"-hidden"),this.selects=[],this.selects.push(document.getElementById(t+"-xs")),this.selects.push(document.getElementById(t+"-sm")),this.selects.push(document.getElementById(t+"-md")),this.selects.push(document.getElementById(t+"-lg")),this.selects.push(document.getElementById(t+"-xl")),this.selects.push(document.getElementById(t+"-xxl"));for(var s=this,n=0;n<this.selects.length;n++)this.selects[n].addEventListener("change",(function(){s.updateHidden()}));this.initValues()}return _createClass(e,[{key:"initValues",value:function(){this.hiddenInput.value&&(this.values=this.hiddenInput.value.split(";"));for(var e=0;e<this.selects.length;e++)"string"==typeof this.values[e]&&(this.selects[e].value=this.values[e])}},{key:"updateHidden",value:function(){this.values=[];for(var e=0;e<this.selects.length;e++)this.values.push("default"===this.selects[e].value?"":this.selects[e].value);this.hiddenInput.value=this.values.join(";")}}]),e}()}));