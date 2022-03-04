/**
 * Package: typo3-extension-bootstrap - Version 1.0.13
 * Typo3 template extension with Twitter Bootstrap 5 package.
 * Author: Marcel <mb@lbrmedia.de>
 * Build date: 2022-03-04 08:27:17
 * Copyright (c) 2022 LBRmedia
 * Released under the GPL-2.0-or-later license
 * https://github.com/lbr-media/typo3-extension-bootstrap
 */

define((function(){return class{constructor(e){this.values=["","","","","",""],this.hiddenInput=document.getElementById(e+"-hidden"),this.selects=[],this.selects.push(document.getElementById(e+"-xs")),this.selects.push(document.getElementById(e+"-sm")),this.selects.push(document.getElementById(e+"-md")),this.selects.push(document.getElementById(e+"-lg")),this.selects.push(document.getElementById(e+"-xl")),this.selects.push(document.getElementById(e+"-xxl"));let t=this;for(var s=0;s<this.selects.length;s++)this.selects[s].addEventListener("change",(function(){t.updateHidden()}));this.initValues()}initValues(){this.hiddenInput.value&&(this.values=this.hiddenInput.value.split(";"));for(var e=0;e<this.selects.length;e++)"string"==typeof this.values[e]&&(this.selects[e].value=this.values[e])}updateHidden(){this.values=[];for(var e=0;e<this.selects.length;e++)this.values.push("default"===this.selects[e].value?"":this.selects[e].value);this.hiddenInput.value=this.values.join(";")}}}));