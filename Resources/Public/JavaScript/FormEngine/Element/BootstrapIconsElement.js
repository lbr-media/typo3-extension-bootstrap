/**
 * Module: TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapIconsElement
 */
define(function() {
    return class {
        
        /**
         * @param string id
         * @param string configurations JSON string with configurations arrays from plugin.tx_bootstrap.settings.form.element.BootstrapIcons
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
            

            // get elements
            this.hiddenInput = document.getElementById(id + "-hidden"); // the value "iconset;classname"
            this.iconSetInput = document.getElementById(id + "-iconset"); // select iconset
            this.valueInput = document.getElementById(id + "-value"); // classname
            this.preview = document.getElementById(id + "-icon-preview"); // contaiber for preview item
            this.filterInput = document.getElementById(id + "-filter"); // filter icons
            this.container = document.getElementById(id + "-container"); // container with the icons
            this.removeButton = document.getElementById(id + "-remove"); // button to clear value
            this.positionInput = document.getElementById(id + "-position"); // select with the position
            this.sizeInput = document.getElementById(id + "-size"); // select with the sizes

            // bind reset/remove current value
            this.removeButton.addEventListener("click", function () {
                _t.preview.innerHTML = "–";
                _t.valueInput.value = "";
                _t.hiddenInput.value = _t.currentConfiguration ? _t.currentConfiguration.key = ";" : ";";
            });

            // bind iconset change
            this.iconSetInput.addEventListener("change", function () {
                _t.currentIconSet = _t.iconSetInput.value;
                _t.initIconSet();
            });

            // bind position change
            if (this.positionInput) {
                this.positionInput.addEventListener("change", function () {
                    _t.currentPosition = _t.positionInput.value;
                    _t.updateValues();
                });
            }

            // bind size change
            if (this.sizeInput) {
                this.sizeInput.addEventListener("change", function () {
                    _t.currentSize = _t.sizeInput.value;
                    _t.updateValues();
                });
            }

            this.initValues();
        }

        initValues() {
            const values = this.hiddenInput.value ? this.hiddenInput.value.split(";") : ["", "", "", ""];

            this.currentIconSet = typeof values[0] === "string" && values[0] ? values[0] : "";
            this.currentValue = typeof values[1] === "string" && values[1] ? values[1] : "";
            this.currentPosition = typeof values[2] === "string" && values[2] ? values[2] : "";
            this.currentSize = typeof values[3] === "string" && values[3] ? values[3] : "";

            // process icon set
            if (!this.currentIconSet) {
                // there is no icon set defined. Try to get the first set.
                if (typeof this.configurations[0].key === "string") {
                    this.currentIconSet = this.configurations[0].key;
                    this.iconSetInput.value = this.currentIconSet;
                }
            }

            // process value
            if (this.currentValue) {
                // set value in visible field
                this.valueInput.value = this.currentValue;

                // set preview icon
                this.createPreviewIcon();
            }

            // process position
            if (this.currentPosition && this.positionInput) {
                this.positionInput.value = this.currentPosition;
            }

            // process position
            if (this.currentSize && this.sizeInput) {
                this.sizeInput.value = this.currentSize;
            }

            this.initIconSet();
        }

        updateValues() {
            // set value in visible field
            this.valueInput.value = this.currentValue;

            // set value for database
            this.hiddenInput.value = this.currentIconSet + ";" + this.currentValue + ";" + this.currentPosition + ";" + this.currentSize;

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
            this.container.innerHTML = "loading";
            let _t = this;
            this.loadContainerHtml(this.currentConfiguration.includeHtml).then(function (markup) {
                _t.container.innerHTML = markup;
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
                let iconElements = this.container.querySelectorAll(".bs-icon");

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
            
            this.filterInput.addEventListener("keydown", function () {
                const value = _t.filterInput.value.toLowerCase();
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
                    for (let i = 0; i < icons.length; i++) {
                        _t.icons[i].iconElement.style.display = "inline-block";
                    }
                }
            });
        }

        createPreviewIcon() {
            this.preview.innerHTML = "–";
            
            if (this.currentValue && this.currentIconSet) {
                if (this.currentIconSet === "bsicons") {
                    this.preview.innerHTML = "";

                    // set icon
                    var icon = document.createElement("i");
                    icon.setAttribute("class", "bs " + this.currentValue);

                    this.preview.appendChild(icon);
                }
            }
        }
    }
});
