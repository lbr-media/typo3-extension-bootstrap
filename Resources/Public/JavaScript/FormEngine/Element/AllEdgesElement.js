/**
 * Module: TYPO3/CMS/Bootstrap/FormEngine/Element/AllEdgesElement
 */
define(function() {
    return class {
        constructor(id)
        {
            this.values = ["", "", "", "", "", "", ""];

            // get hidden element with the value
            this.hiddenInput = document.getElementById(id + "-hidden");

            // get the selects and bind change event
            this.selects = [];
            this.selects.push(document.getElementById(id + "-left"));
            this.selects.push(document.getElementById(id + "-right"));
            this.selects.push(document.getElementById(id + "-horizontal"));
            this.selects.push(document.getElementById(id + "-top"));
            this.selects.push(document.getElementById(id + "-bottom"));
            this.selects.push(document.getElementById(id + "-vertical"));
            this.selects.push(document.getElementById(id + "-all"));
            
            let _t = this;
            for (var i = 0; i < this.selects.length; i++) {
                this.selects[i].addEventListener("change", function () {
                    _t.updateHidden();
                });
            }

            this.initValues();
        }

        initValues() {
            if (this.hiddenInput.value) {
                this.values = this.hiddenInput.value.split(";");
            }

            for (var i = 0; i < this.selects.length; i++) {
                if (typeof this.values[i] === "string") {
                    this.selects[i].value = this.values[i];
                }
            }
        }

        updateHidden() {
            this.values = [];
            for (var i = 0; i < this.selects.length; i++) {
                this.values.push(this.selects[i].value === "default" ? "" : this.selects[i].value);
            }

            this.hiddenInput.value = this.values.join(";");
        };
    }
});
