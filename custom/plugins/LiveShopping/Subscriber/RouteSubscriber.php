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

namespace LiveShopping\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;

class RouteSubscriber implements SubscriberInterface
{
    private $pluginName;

    private $pluginDirectory;

    private $sloganPrinter;

    private $config;

    public function __construct($pluginName, $pluginDirectory, $sloganPrinter, ConfigReader $configReader)
    {
        $this->pluginName = $pluginName;
        $this->pluginDirectory = $pluginDirectory;
        $this->sloganPrinter = $sloganPrinter;
        $this->config = $configReader->getByPluginName($pluginName);
    }

    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        $view->assign('swagSloganFontSize', $this->config['swagSloganFontSize']);
        $view->assign('swagSloganItalic', $this->config['swagSloganItalic']);
        $view->assign('swagSloganContent', $this->config['swagSloganContent']);

        if (!$this->config['swagSloganContent']) {
            $view->assign('swagSloganContent', $this->sloganPrinter->getSlogan());
        }
        $view->assign('slogan', $this->sloganPrinter->getSlogan());
        $view->assign('liveShopping', [
                'liveShoppingActive' => $this->config['liveShoppingActive'],
                'liveShoppingArticleId' => $this->config['liveShoppingArticleId'],
            ]
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure' => 'onPostDispatch',
        ];
    }
}
