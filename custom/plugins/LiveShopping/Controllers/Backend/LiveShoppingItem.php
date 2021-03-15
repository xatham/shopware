<?php

declare(strict_types=1);

/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

use LiveShopping\Models\LiveShoppingItem;
use Shopware\Models\Article\Detail;
use Shopware_Controllers_Backend_Application;

class Shopware_Controllers_Backend_LiveShoppingItem extends Shopware_Controllers_Backend_Application
{
    protected $model = LiveShoppingItem::class;

    protected $alias = 'live_shopping_item';

    public function indexAction()
    {
        parent::indexAction();
    }

    public function updateAction(): void
    {
        $requestData = $this->Request()->getParams();
        $variantNo = $requestData['article'] ?? null;
        if (!$variantNo) {
            $this->View()->assign(
                ['success' => false, 'violations' => 'Ein Fehler'],
            );

            return;
        }
        $variantEntity = $this->getManager()
            ->getRepository(Detail::class)
            ->findOneBy(['number' => $variantNo]);

        $requestData['article'] = $variantEntity;

        $this->View()->assign(
            $this->save($requestData)
        );
    }

    protected function getDetailQuery($id): \Shopware\Components\Model\QueryBuilder
    {
        $builder = parent::getDetailQuery($id);
        $builder
            ->join('live_shopping_item.article', 'details')
            ->addSelect(['details']);

        return $builder;
    }

    protected function getListQuery(): \Shopware\Components\Model\QueryBuilder
    {
        $builder = parent::getListQuery();
        $builder
            ->join('live_shopping_item.article', 'details')
            ->addSelect(['details']);

        return $builder;
    }
}
