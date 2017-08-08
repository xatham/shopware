<?php
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

namespace Shopware\Bundle\ESIndexingBundle;

use Doctrine\DBAL\Connection;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Shop\Struct\Shop;
use Shopware\Shop\Gateway\ShopReader;

/**
 * Class IdentifierSelector
 */
class IdentifierSelector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var \Shopware\Shop\Gateway\ShopReader
     */
    private $shopGateway;

    /**
     * @param Connection                                         $connection
     * @param \Shopware\Shop\Gateway\ShopReader $shopGateway
     */
    public function __construct(
        Connection $connection,
        ShopReader $shopGateway
    ) {
        $this->connection = $connection;
        $this->shopGateway = $shopGateway;
    }

    /**
     * @return \Shopware\Shop\Struct\Shop[]
     */
    public function getShops()
    {
        $context = new TranslationContext(1, true, null);

        return $this->shopGateway->read($this->getShopIds(), $context);
    }

    /**
     * @return int[]
     */
    public function getShopIds()
    {
        return $this->connection->createQueryBuilder()
            ->select('id')
            ->from('s_core_shops', 'shop')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @return string[]
     */
    public function getCustomerGroupKeys()
    {
        return $this->connection->createQueryBuilder()
            ->select('groupkey')
            ->from('s_core_customergroups', 'customerGroups')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @param int $shopId
     *
     * @return int[]
     */
    public function getShopCurrencyIds($shopId)
    {
        return $this->connection->createQueryBuilder()
            ->select('currency_id')
            ->from('s_core_shop_currencies', 'currency')
            ->andWhere('currency.shop_id = :id')
            ->setParameter(':id', $shopId)
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }
}
