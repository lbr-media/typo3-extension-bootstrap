<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Controller;

use LBRmedia\Bootstrap\Domain\Model\Item;
use LBRmedia\Bootstrap\Domain\Repository\ItemRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ItemController extends ActionController
{
    /**
     * @var ItemRepository
     */
    protected $itemRepository = null;

    public function injectItemRepository(ItemRepository $itemRepository): void
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * action overview.
     */
    public function overviewAction(): ResponseInterface
    {
        $this->view->assign('items', $this->itemRepository->findAll());

        return new HtmlResponse($this->view->render());
    }

    /**
     * action overview.
     */
    public function detailsAction(Item $item = null): ResponseInterface
    {
        $this->view->assign('item', $item);

        return new HtmlResponse($this->view->render());
    }
}
