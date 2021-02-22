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

use Doctrine\DBAL\Connection;
use Shopware\Bundle\StoreFrontBundle\Struct\ListProduct;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class SeoCategoryService
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * @var \Shopware\Bundle\StoreFrontBundle\Service\Core\CategoryService
     */
    private $categoryService;

    public function __construct(\Doctrine\DBAL\Connection $connection, \Shopware\Bundle\StoreFrontBundle\Service\Core\CategoryService $categoryService)
    {
        $this->connection = $connection;
        $this->categoryService = $categoryService;
    }

    /**
     * @param ListProduct[] $listProducts
     */
    public function getList(array $listProducts, ShopContextInterface $context): array
    {
        $ids = array_map(function (ListProduct $product) {
            return $product->getId();
        }, $listProducts);

        //select all seo category ids, indexed by product id
        $ids = $this->getCategoryIds($ids, $context);

        //now select all category data for the selected ids
        $categories = $this->categoryService->getList($ids, $context);
        $result = [];
        foreach ($ids as $productId => $categoryId) {
            if (!isset($categories[$categoryId])) {
                continue;
            }
            $result[$productId] = $categories[$categoryId];
        }

        return $result;
    }

    /**
     * @param mixed $context
     *
     * @return array
     */
    private function getCategoryIds($ids, ShopContextInterface $context)
    {
        $query = $this->connection->createQueryBuilder();
        $query->select(['seoCategories.article_id', 'seoCategories.category_id'])
            ->from('s_articles_categories_seo', 'seoCategories')
            ->andWhere('seoCategories.article_id IN (:productIds)')
            ->andWhere('seoCategories.shop_id = :shopId')
            ->setParameter(':shopId', $context->getShop()->getId())
            ->setParameter(':productIds', $ids, Connection::PARAM_INT_ARRAY);

        return $query->execute()->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
