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

namespace LiveShopping\Components\Service;

use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Attribute;
use Shopware\Bundle\StoreFrontBundle\Struct\ProductContextInterface;

class ListProductService implements ListProductServiceInterface
{
    /**
     * @var ListProductServiceInterface
     */
    private $listProductService;

    /**
     * @var SeoCategoryService
     */
    private $seoCategoryService;

    public function __construct(ListProductServiceInterface $listProductService, SeoCategoryService $seoCategoryService)
    {
        $this->listProductService = $listProductService;
        $this->seoCategoryService = $seoCategoryService;
    }

    public function getList(array $numbers, ProductContextInterface $context): array
    {
        $products = $this->listProductService->getList($numbers, $context);
        $categories = $this->seoCategoryService->getList($products, $context);
        foreach ($products as $product) {
            $productId = $product->getId();
            if (!isset($categories[$productId])) {
                continue;
            }
            $attribute = new Attribute(['category' => $categories[$productId]]);
            $product->addAttribute('swag_plugin_system', $attribute);
        }

        return $products;
    }

    public function get($number, ProductContextInterface $context)
    {
        $products = $this->getList([$number], $context);

        return array_shift($products);
    }
}
