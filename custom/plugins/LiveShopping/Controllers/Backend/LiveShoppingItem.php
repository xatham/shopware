<?php

declare(strict_types=1);

use LiveShopping\Models\LiveShoppingItem;

class Shopware_Controllers_Backend_LiveShoppingItem extends Shopware_Controllers_Backend_Application
{
    protected $model = LiveShoppingItem::class;

    protected $alias = 'live_shopping_item';

    public function indexAction()
    {
        parent::indexAction();
    }
}
