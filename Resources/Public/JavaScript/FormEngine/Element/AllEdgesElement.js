/**
 * Module: TYPO3/CMS/Bootstrap/FormEngine/Element/SpacesElement Logic for SpacesElement
 */
 define(["jquery"], function ($) {
    /**
     *
     * @type {{}}
     * @exports TYPO3/CMS/Bootstrap/FormEngine/Element/AllEdgesElement
     */
    var AllEdgesElement = {};

    /**
     * Initializes the SpacesEleemnt
     *
     * @param {String} selector
     */
    AllEdgesElement.initialize = function (selector) {
        var updateHidden = function () {
            var e = [
                $left.val() !== "default" ? $left.val() : "",
                $right.val() !== "default" ? $right.val() : "",
                $horizontal.val() !== "default" ? $horizontal.val() : "",
                $top.val() !== "default" ? $top.val() : "",
                $bottom.val() !== "default" ? $bottom.val() : "",
                $vertical.val() !== "default" ? $vertical.val() : "",
                $all.val() !== "default" ? $all.val() : ""
            ];
            $hidden.val(e.join(";"));
        };

        var $hidden = $("#" + selector + "-hidden");
        var $left = $("#" + selector + "-left").on("change", updateHidden);
        var $right = $("#" + selector + "-right").on("change", updateHidden);
        var $horizontal = $("#" + selector + "-horizontal").on("change", updateHidden);
        var $top = $("#" + selector + "-top").on("change", updateHidden);
        var $bottom = $("#" + selector + "-bottom").on("change", updateHidden);
        var $vertical = $("#" + selector + "-vertical").on("change", updateHidden);
        var $all = $("#" + selector + "-all").on("change", updateHidden);

        if ($hidden.val()) {
            var e = $hidden.val().split(";");
        } else {
            var e = ["default", "default", "default", "default", "default", "default", "default"];
        }

        $left.val(e[0] ? e[0] : "default");
        $right.val(e[1] ? e[1] : "default");
        $horizontal.val(e[2] ? e[2] : "default");
        $top.val(e[3] ? e[3] : "default");
        $bottom.val(e[4] ? e[4] : "default");
        $vertical.val(e[5] ? e[5] : "default");
        $all.val(e[6] ? e[6] : "default");
    };

    return AllEdgesElement;
});
