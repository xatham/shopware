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

namespace LiveShopping\ComponentHandler;

use Shopware\Bundle\EmotionBundle\ComponentHandler\ComponentHandlerInterface;
use Shopware\Bundle\EmotionBundle\Struct\Collection\PrepareDataCollection;
use Shopware\Bundle\EmotionBundle\Struct\Collection\ResolvedDataCollection;
use Shopware\Bundle\EmotionBundle\Struct\Element;
use Shopware\Bundle\MediaBundle\MediaService;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin\Configuration\ReaderInterface;
use Shopware\Models\Article\Article;
use Shopware\Models\Article\Image;

class LiveShoppingComponentHandler implements ComponentHandlerInterface
{
    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var MediaService
     */
    private $mediaManger;

    /**
     * @var ReaderInterface
     */
    private $reader;

    public function __construct(ModelManager $modelManager, MediaService $mediaManger, ReaderInterface $pluginManager)
    {
        $this->modelManager = $modelManager;
        $this->mediaManger = $mediaManger;
        $this->reader = $pluginManager;
    }

    public function supports(Element $element)
    {

            return $element->getComponent()->getName() === 'Live Shopping';
    }

    public function prepare(PrepareDataCollection $collection, Element $element, ShopContextInterface $context)
    {
    }

    public function handle(ResolvedDataCollection $collection, Element $element, ShopContextInterface $context)
    {
        $repository = $this->modelManager->getRepository(\Shopware\Models\Article\Article::class);
        $liveShoppingConfiguration = $this->reader->getByPluginName('liveShopping');
        $product = Shopware()->Modules()->Articles()->sGetProductByOrdernumber($liveShoppingConfiguration['liveShoppingArticleId']);

        $available = $liveShoppingConfiguration['liveShoppingActive'] === true
            && $liveShoppingConfiguration['liveShoppingArticleId'] !== ''
            && $product !== false;

        if ($available === false) {
            return;
        }

        // $basket = Shopware()->Modules()->Basket();
        // $added = $basket->sAddArticle($product['ordernumber']);
        $product['live_price'] = 20;

        $element->getData()->set('product', $product);
        $element->getData()->set('article_price', $product['price']);
    }
}
