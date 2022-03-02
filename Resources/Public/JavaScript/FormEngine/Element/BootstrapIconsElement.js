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
            this.currentIconSet = "";
            this.values = [
                "", // icon set: key
                "" // selected icon (classname)
            ];
            this.loadedStylesheets = [];
            this.icons = [];

            // get elements
            this.hiddenInput = document.getElementById(id + "-hidden"); // the value "iconset;classname"
            this.iconSetInput = document.getElementById(id + "-iconset"); // select iconset
            this.valueInput = document.getElementById(id + "-value"); // classname
            this.preview = document.getElementById(id + "-icon-preview"); // contaiber for preview item
            this.filterInput = document.getElementById(id + "-filter"); // filter icons
            this.container = document.getElementById(id + "-container"); // container with the icons
            this.removeButton = document.getElementById(id + "-remove"); // button to clear value

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

            this.initValues();
        }

        initValues() {
            if (this.hiddenInput.value) {
                this.values = this.hiddenInput.value.split(";");
            }

            // process icon set
            if (typeof this.values[0] === "string" && this.values[0]) {
                // there is an iconset defined
                this.iconSetInput.value = this.values[0];
                this.currentIconSet = this.values[0];
            } else {
                // there is no iconset defined. Try to get the first set.
                if (typeof this.configurations[0].key === "string") {
                    this.currentIconSet = this.configurations[0].key;
                    this.iconSetInput.value = this.currentIconSet;
                }
            }

            if (typeof this.values[1] === "string" && this.values[1]) {
                // there is an icon defined
                this.valueInput.value = this.values[1];

                // make icon visible
                this.createPreviewIcon(this.values[1]);
            }

            this.initIconSet();
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
            if (this.loadedStylesheets.indexOf(file) > -1) {
                return;
            }

            this.loadedStylesheets.push(file);

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
                                // set value in visible field
                                _t.valueInput.value = value;

                                // set icon
                                _t.createPreviewIcon(value);

                                // set value for database
                                _t.hiddenInput.value = _t.currentConfiguration.key + ";" + value;
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

        createPreviewIcon(value) {
            if (this.currentIconSet && this.currentIconSet === "bsicons") {
                // set icon
                var icon = document.createElement("i");
                icon.setAttribute("class", "bs " + value);

                this.preview.innerHTML = "";
                this.preview.appendChild(icon);
            }
        }

        updateHidden() {
            this.values = [];
            for (let i = 0; i < this.selects.length; i++) {
                this.values.push(this.selects[i].value === "default" ? "" : this.selects[i].value);
            }

            this.hiddenInput.value = this.values.join(";");
        };
    }
});
