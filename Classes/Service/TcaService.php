<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class to manipulate $GLOBALS['TCA']['tt_content']['types'][$contentElementType]['showitem'].
 * Used in Configuration/TCA/Overrides/tt_content.php.
 */
class TcaService
{
    /**
     * @var array
     */
    protected $showitems = [];

    /**
     * Counter for added showitems.
     *
     * @var int
     */
    protected $addedShowItems = 0;

    /**
     * Counter for replaced showitems.
     *
     * @var int
     */
    protected $replacedShowItems = 0;

    public function __construct(string $showitemsString = '')
    {
        if ($showitemsString) {
            $this->setShowitems($showitemsString);
        }
    }

    public function setShowitems(string $showitemsString): self
    {
        $this->addedShowItems = 0;
        $this->replacedShowItems = 0;
        $this->showitems = [];
        $showitemsArr = GeneralUtility::trimExplode(',', $showitemsString, true);
        $divs = 0;
        $linebreaks = 0;
        foreach ($showitemsArr as $showitem) {
            if ('--palette--' === substr($showitem, 0, 11)) {
                $parts = GeneralUtility::trimExplode(';', $showitem, true);
                $this->showitems[end($parts)] = $showitem;
            } elseif ('--div--' === substr($showitem, 0, 7)) {
                ++$divs;
                $this->showitems['--div--'.$divs] = $showitem;
            } elseif ('--linebreak--' === substr($showitem, 0, 13)) {
                ++$linebreaks;
                $this->showitems['--linebreak--'.$linebreaks] = $showitem;
            } else {
                $parts = GeneralUtility::trimExplode(';', $showitem, true);
                $this->showitems[$parts[0]] = $showitem;
            }
        }

        // print_r($this->showitems);
        // die();

        return $this;
    }

    public function getShowitems(): array
    {
        return $this->showitems;
    }

    public function getShowitemsString(): string
    {
        return implode(',', $this->showitems);
    }

    public function removeShowitems(array $keysToBeRemoved): self
    {
        foreach ($keysToBeRemoved as $key) {
            if (isset($this->showitems[$key])) {
                unset($this->showitems[$key]);
            }
        }

        return $this;
    }

    public function addShowitemAfter(string $showitemToAdd, string $keyOfPreviousShowitem): self
    {
        $tmpShowitems = [];
        foreach ($this->showitems as $key => $showitem) {
            $tmpShowitems[$key] = $showitem;
            if ($key == $keyOfPreviousShowitem) {
                ++$this->addedShowItems;
                $tmpShowitems['addedShowItem'.$this->addedShowItems] = $showitemToAdd;
            }
        }
        $this->showitems = $tmpShowitems;

        return $this;
    }

    public function addShowitemBefore(string $showitemToAdd, string $keyOfNextShowitem): self
    {
        $tmpShowitems = [];
        foreach ($this->showitems as $key => $showitem) {
            if ($key == $keyOfNextShowitem) {
                ++$this->addedShowItems;
                $tmpShowitems['addedShowItem'.$this->addedShowItems] = $showitemToAdd;
            }
            $tmpShowitems[$key] = $showitem;
        }
        $this->showitems = $tmpShowitems;

        return $this;
    }

    public function addShowitemsAfter(array $showitemsToAdd, string $keyOfPreviousShowitem): self
    {
        $tmpShowitems = [];

        foreach ($this->showitems as $key => $showitem) {
            $tmpShowitems[$key] = $showitem;
            if ($key == $keyOfPreviousShowitem) {
                foreach ($showitemsToAdd as $showitemToAdd) {
                    ++$this->addedShowItems;
                    $tmpShowitems['addedShowItem'.$this->addedShowItems] = $showitemToAdd;
                }
            }
        }
        $this->showitems = $tmpShowitems;

        return $this;
    }

    public function replaceShowitem(string $showitemToBeReplaced, string $showitemToReplace): self
    {
        $tmpShowitems = [];
        foreach ($this->showitems as $key => $showitem) {
            if ($key == $showitemToBeReplaced) {
                ++$this->replacedShowItems;
                $tmpShowitems['replacedShowItem'.$this->replacedShowItems] = $showitemToReplace;
            } else {
                $tmpShowitems[$key] = $showitem;
            }
        }
        $this->showitems = $tmpShowitems;

        return $this;
    }
}
