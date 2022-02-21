/**
 * Module: TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapDevicesElement Logic for SpacesElement
 */
 define(["jquery"], function($) {
    /**
     *
     * @type {{}}
     * @exports TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapDevicesElement
     */
    var BootstrapDevicesElement = {};

    /**
     * Initializes the GridElement
     *
     * @param {String} selector
     */
    BootstrapDevicesElement.initialize = function(selector) {
        var $hidden = $("#" + selector + "-hidden");

        var $xs = $("#" + selector + "-xs").on("change", function() {
            updateHidden();
        });
        var $sm = $("#" + selector + "-sm").on("change", function() {
            updateHidden();
        });
        var $md = $("#" + selector + "-md").on("change", function() {
            updateHidden();
        });
        var $lg = $("#" + selector + "-lg").on("change", function() {
            updateHidden();
        });
        var $xl = $("#" + selector + "-xl").on("change", function() {
            updateHidden();
        });
        var $xxl = $("#" + selector + "-xxl").on("change", function() {
            updateHidden();
        });

        if ($hidden.val()) {
            var e = $hidden.val().split(";");
        } else {
            var e = ["", "", "", "", "", ""];
        }

        $xs.val(e[0] ? e[0] : "");
        $sm.val(e[1] ? e[1] : "");
        $md.val(e[2] ? e[2] : "");
        $lg.val(e[3] ? e[3] : "");
        $xl.val(e[4] ? e[4] : "");
        $xxl.val(e[5] ? e[5] : "");

        var updateHidden = function() {
            var e = [];
            e.push($xs.val() == "default" ? "" : $xs.val());
            e.push($sm.val() == "default" ? "" : $sm.val());
            e.push($md.val() == "default" ? "" : $md.val());
            e.push($lg.val() == "default" ? "" : $lg.val());
            e.push($xl.val() == "default" ? "" : $xl.val());
            e.push($xxl.val() == "default" ? "" : $xxl.val());

            $hidden.val(e.join(";"));
        };
    };

    return BootstrapDevicesElement;
});
