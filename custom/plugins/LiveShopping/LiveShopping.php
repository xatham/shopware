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

namespace LiveShopping;

use Shopware\Components\Emotion\ComponentInstaller;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Emotion\Library\Component;

class LiveShopping extends Plugin
{
    public function install(InstallContext $context)
    {
        parent::install($context);

        /** @var ComponentInstaller $componentInstaller */
        $componentInstaller = $this->container->get('shopware.emotion_component_installer');
        $liveShoppingElement = $componentInstaller->createOrUpdate(
            $this->getName(),
            'LiveShoppingEmotion',
            [
                'name' => 'Live Shopping',
                'template' => 'component_live_shopping',
                'cls' => 'live-shopping-element',
                'description' => 'A simple live shopping element for the shopping worlds.',
            ]
        );
        $liveShoppingElement->createTextField([
            'name' => 'live_shopping_article_id',
            'fieldLabel' => 'Article id',
            'supportText' => 'Enter the ID of the article you want to promote.',
            'allowBlank' => false,
        ]);

        $liveShoppingElement->createHiddenField([
            'name' => 'live_shopping_thumbnail',
        ]);

        $liveShoppingElement->createCheckboxField([
            'name' => 'live_shopping_active',
            'fieldLabel' => 'Live shopping active',
            'defaultValue' => false,
        ]);

        $liveShoppingElement->createDateField([
            'name' => 'live_shopping_start_date',
            'fieldLabel' => 'Start date',
            'defaultValue' => false,
            'allowBlank' => false,
        ]);

        $liveShoppingElement->createDateField([
            'name' => 'live_shopping_end_date',
            'fieldLabel' => 'End date',
            'defaultValue' => false,
        ]);

        $em = $this->container->get(ModelManager::class);
        $em->persist($liveShoppingElement);
        $em->flush();
    }

    public function uninstall(UninstallContext $context)
    {
        /** @var ModelManager $em */
        $em = $this->container->get(ModelManager::class);
        $repo = $em->getRepository(Component::class);
        $pluginRepo = $em->getRepository(\Shopware\Models\Plugin\Plugin::class);
        /** @var Plugin|null $plugin */
        $plugin = $pluginRepo->findOneBy(['name' => $this->getName()]);
        $component = $repo->findOneBy([
            'pluginId' => $plugin->getId(),
        ]);
        $em->remove($component);
        $em->flush();

        parent::uninstall($context);
    }
}
