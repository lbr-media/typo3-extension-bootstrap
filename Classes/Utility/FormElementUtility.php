<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

/**
 * Helper utility class for \LBRmedia\Bootstrap\Form\Element\*
 */
class FormElementUtility
{
    /**
     * Creates a select tag with label and an "inline"-wrapper to get some selects in line.
     */
    public static function createInlineSelectTag(string $id, string $label, string $options, string $additionalClasses = ""):string {
        $label = htmlspecialchars($label);
        return <<<EOT
<div class="form-control-inline-element {$additionalClasses}">
    <label for="{$id}">{$label}</label>
    <select class="form-select form-control-adapt" id="{$id}">
        {$options}
    </select>
</div>
EOT;
    }

    public static function createHiddenInputTag(string $name, string $value, string $id):string {
        return '<input type="hidden" name="'.htmlspecialchars($name).'" value="'.trim(htmlspecialchars($value)).'" id="'.$id.'" />';
    }

    public static function createOptionTags(array $items, bool $prependEmptyOption = false, string $emptyOptionLabel = ""):array {
        $options = [];
        if ($prependEmptyOption) {
            if (substr($emptyOptionLabel, 0, 4) === "LLL:") {
                $label = $GLOBALS['LANG']->sL($emptyOptionLabel);
            }
            $options[] = '<option value="">' . htmlspecialchars($emptyOptionLabel) . '</option>';
        }
        foreach ($items as $value => $label) {
            if (substr($label, 0, 4) === "LLL:") {
                $label = $GLOBALS['LANG']->sL($label);
            }
            $options[] = '<option value="' . htmlspecialchars((string) $value) . '">' . htmlspecialchars((string) $label) . '</option>';
        }

        return $options;
    }

    public static function createFormControlWrap(string $inputHtml, string $fieldWizardHtml):string {
        return <<<EOT
<div class="form-control-wrap">
    <div class="form-wizards-wrap">
        <div class="form-wizards-element">
            {$inputHtml}
        </div>
        <div class="form-wizards-items-bottom">
            {$fieldWizardHtml}
        </div>
    </div>
</div>
EOT;
    }
}
