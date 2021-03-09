<?php

declare(strict_types=1);

namespace LiveShopping\Bootstrap;

use Doctrine\ORM\Tools\SchemaTool;
use LiveShopping\Models\LiveShoppingItem;
use PDO;
use Shopware\Components\Emotion\ComponentInstaller;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Models\Emotion\Library\Component;

final class Setup
{
    /**
     * @var string
     */
    private $pluginName;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var ComponentInstaller
     */
    private $componentInstaller;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * Setup constructor.
     * @param string $pluginName
     * @param PDO $connection
     * @param ModelManager $modelManager
     * @param ComponentInstaller $componentInstaller
     * @param SchemaTool $schemaTool
     */
    public function __construct(string $pluginName, PDO $connection, ModelManager $modelManager, ComponentInstaller $componentInstaller, SchemaTool $schemaTool)
    {
        $this->pluginName = $pluginName;
        $this->connection = $connection;
        $this->modelManager = $modelManager;
        $this->componentInstaller = $componentInstaller;
        $this->schemaTool = $schemaTool;
    }

    public function install(): void
    {
        $classes = [
            $this->modelManager->getClassMetadata(LiveShoppingItem::class),
        ];
        $this->schemaTool->createSchema($classes);
        $this->createNewLiveShoppingEmotion();
    }

    public function uninstall(): void
    {
        $repo = $this->modelManager->getRepository(Component::class);
        $pluginRepo = $this->modelManager->getRepository(\Shopware\Models\Plugin\Plugin::class);

        /** @var Plugin|null $plugin */
        $plugin = $pluginRepo->findOneBy(['name' => $this->pluginName]);
        $component = null;
        if ($plugin !== null) {
            $component = $repo->findOneBy([
                'pluginId' => $plugin->getId(),
            ]);
        }
        if ($component !== null) {
            $this->modelManager->remove($component);
            $this->modelManager->flush();
        }

        $classes = [
            $this->modelManager->getClassMetadata(LiveShoppingItem::class),
        ];
        $this->schemaTool->dropSchema($classes);

    }

    private function createNewLiveShoppingEmotion(): void
    {
        $liveShoppingElement = $this->componentInstaller->createOrUpdate(
            $this->pluginName,
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

        $this->modelManager->persist($liveShoppingElement);
        $this->modelManager->flush();
    }
}
