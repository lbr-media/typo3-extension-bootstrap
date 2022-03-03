/**
 * Module: TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapIconsElement
 */
define(function() {
    return class {
        
        /**
         * @param string id
         * @param string configurations JSON string with configuration arrays from plugin.tx_bootstrap.settings.form.element.BootstrapIcons
         */
        constructor(id, configurations)
        {
            let _t = this;
            this.configurations = JSON.parse(configurations);
            this.currentConfiguration = null;
            this.icons = [];

            // values
            this.currentIconSet = "";
            this.currentValue = "";
            this.currentPosition = "";
            this.currentSize = "";
            this.currentColor = "";

            // input elements
            this.userControlFieldValue = document.getElementById(id + "-hidden"); // the value "iconset;classname;position;size;color"
            this.userControlIconSet = document.getElementById(id + "-iconset"); // select or hidden input for iconSet
            this.userControlValue = document.getElementById(id + "-value"); // classname readonly
            this.userControlPosition = document.getElementById(id + "-position"); // select position
            this.userControlSize = document.getElementById(id + "-size"); // select size
            this.userControlColor = document.getElementById(id + "-color"); // select color
            this.userControlFilter = document.getElementById(id + "-filter"); // filter icons

            // other elements
            this.iconsContainer = document.getElementById(id + "-container"); // container with the icons
            this.previewContainer = document.getElementById(id + "-icon-preview"); // contaiber for preview item
            this.removeButton = document.getElementById(id + "-remove"); // button to clear value

            // bind reset/remove current value
            this.removeButton.addEventListener("click", function () {
                _t.currentValue = "";
                _t.updateValues();
            });

            // bind iconset change
            this.userControlIconSet.addEventListener("change", function () {
                _t.currentIconSet = _t.userControlIconSet.value;
                _t.initIconSet();
            });

            // bind position change
            if (this.userControlPosition) {
                this.userControlPosition.addEventListener("change", function () {
                    _t.currentPosition = _t.userControlPosition.value;
                    _t.updateValues();
                });
            }

            // bind size change
            if (this.userControlSize) {
                this.userControlSize.addEventListener("change", function () {
                    _t.currentSize = _t.userControlSize.value;
                    _t.updateValues();
                });
            }

            // bind color change
            if (this.userControlColor) {
                this.userControlColor.addEventListener("change", function () {
                    _t.currentColor = _t.userControlColor.value;
                    _t.updateValues();
                });
            }

            this.initValues();
        }

        initValues() {
            const values = this.userControlFieldValue.value ? this.userControlFieldValue.value.split(";") : ["", "", "", "", ""];

            this.currentIconSet = typeof values[0] === "string" && values[0] !== "default" ? values[0] : "";
            this.currentValue = typeof values[1] === "string" && values[1] !== "default" ? values[1] : "";
            this.currentPosition = typeof values[2] === "string" && values[2] !== "default" ? values[2] : "";
            this.currentSize = typeof values[3] === "string" && values[3] !== "default" ? values[3] : "";
            this.currentColor = typeof values[4] === "string" && values[4] !== "default" ? values[4] : "";

            // process icon set
            if (!this.currentIconSet) {
                // there is no icon set defined. Try to get the first set.
                if (typeof this.configurations[0].key === "string") {
                    this.currentIconSet = this.configurations[0].key;
                    this.userControlIconSet.value = this.currentIconSet;
                }
            }

            // process value
            if (this.currentValue) {
                // set value in visible field
                this.userControlValue.value = this.currentValue;

                // set preview icon
                this.createPreviewIcon();
            }

            // process position
            if (this.currentPosition && this.userControlPosition) {
                this.userControlPosition.value = this.currentPosition;
            }

            // process size
            if (this.currentSize && this.userControlSize) {
                this.userControlSize.value = this.currentSize;
            }

            // process color
            if (this.currentColor && this.userControlColor) {
                this.userControlColor.value = this.currentColor;
            }

            this.initIconSet();
        }

        updateValues() {
            // set value in visible field
            this.userControlValue.value = this.currentValue;

            // set value for database
            this.userControlFieldValue.value = this.currentIconSet + ";" + this.currentValue + ";" + this.currentPosition + ";" + this.currentSize + ";" + this.currentColor;

            // set preview icon
            this.createPreviewIcon();
        }

        initCurrentConfiguration() {
            this.currentConfiguration = null;
            for (let i = 0; i < this.configurations.length; i++) {
                if (this.configurations[i].key === this.currentIconSet) {
                    this.currentConfiguration = this.configurations[i];
                    break;
                }
            }
        }

        initIconSet() {
            this.initCurrentConfiguration();

            if (!this.currentConfiguration) {
                console.warn(`BootstrapIconsElement: Could not find a configuration for key ${this.currentIconSet}`);
                return;
            }

            // load Stylesheet
            for (const key in this.currentConfiguration.includeCss) {
                this.loadStylesheet(this.currentConfiguration.includeCss[key]);
            }

            // load html into container
            this.iconsContainer.innerHTML = "loading";
            let _t = this;
            this.loadContainerHtml(this.currentConfiguration.includeHtml).then(function (markup) {
                _t.iconsContainer.innerHTML = markup;
                _t.initFilter()
            });
        }

        loadStylesheet(file) {
            const allLinkElements = document.querySelectorAll("link");
            for (let i = 0; i < allLinkElements.length; i++) {
                if (allLinkElements[i].hasAttribute("href") && allLinkElements[i].getAttribute("href") === file) {
                    return;
                }
            }

            let link = document.createElement("link");
            link.href = file;
            link.type = "text/css";
            link.rel = "stylesheet";
            link.media = "all";

            document.getElementsByTagName("head")[0].appendChild(link);
        }

        loadContainerHtml(file) {
            return new Promise(function(resolve, reject) {
                let xhr = new XMLHttpRequest();
                xhr.open("GET", file, true);
                xhr.onload = function(e) {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                            resolve(xhr.response);
                        } else {
                            reject(xhr);
                            console.error(xhr.statusText);
                        }
                    }
                };
                xhr.send();
            });
        }

        initFilter() {
            let _t = this;
            this.icons = [];

            if (this.currentConfiguration.key === "bsicons") {
                // collect icons
                let iconElements = this.iconsContainer.querySelectorAll(".bs-icon");

                // build icons list with search values
                for (var i = 0; i < iconElements.length; i++){
                    let search = [];
                    let value = "";

                    const labelTag = iconElements[i].querySelector(".bs-label");
                    if (labelTag) {
                        search.push(labelTag.innerHTML.toLowerCase());
                    }

                    const iTag = iconElements[i].querySelector(".bi");
                    if (iTag) {
                        value = iTag.getAttribute("class").replace("bi ", "");
                        search.push(value.toLowerCase());
                    }

                    if (search.length && value) {
                        this.icons.push({
                            iconElement: iconElements[i],
                            search: search.join(" "),
                            value: value
                        });

                        iconElements[i].setAttribute("data-bsicon-value", value);
                        iconElements[i].addEventListener("click", function (evt) {
                            const value = this.getAttribute("data-bsicon-value");
                            if (value) {
                                _t.currentValue = value;
                                _t.updateValues();
                            }
                        });
                    }
                }
            }
            
            this.userControlFilter.addEventListener("keydown", function () {
                const value = _t.userControlFilter.value.toLowerCase();
                if (value.trim()) {
                    // filter icons
                    for (let i = 0; i < _t.icons.length; i++) {
                        if (_t.icons[i].search.indexOf(value) > -1) {
                            _t.icons[i].iconElement.style.display = "inline-block";
                        } else {
                            _t.icons[i].iconElement.style.display = "none";
                        }
                    }
                } else {
                    // no search: show all
                    for (let i = 0; i < _t.icons.length; i++) {
                        _t.icons[i].iconElement.style.display = "inline-block";
                    }
                }
            });
        }

        createPreviewIcon() {
            this.previewContainer.innerHTML = "–";
            
            if (this.currentValue && this.currentIconSet) {
                if (this.currentIconSet === "bsicons") {
                    this.previewContainer.innerHTML = "";

                    // set icon
                    var icon = document.createElement("i");
                    icon.setAttribute("class", "bs " + this.currentValue);

                    this.previewContainer.appendChild(icon);
                }
            }
        }
    }
});
