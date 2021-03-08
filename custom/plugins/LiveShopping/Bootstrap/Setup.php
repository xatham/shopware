<?php

declare(strict_types=1);

namespace LiveShopping\Bootstrap;

use PDO;
use Shopware\Components\Emotion\ComponentInstaller;
use Shopware\Components\Model\ModelManager;

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

    public function __construct(string $pluginName, PDO $connection, ModelManager $modelManager, ComponentInstaller $componentInstaller)
    {
        $this->pluginName = $pluginName;
        $this->connection = $connection;
        $this->modelManager = $modelManager;
        $this->componentInstaller = $componentInstaller;
    }

    public function install(): void
    {
        $this->createTable();
    }

    public function uninstall(): void
    {
        $this->connection->query('DROP TABLE IF EXISTS s_plugin_live_shopping_item');
    }

    private function createNewLiveShoppingEmotion(): void
    {
        $liveShoppingElement = $this->componentInstaller->createOrUpdate(
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

        $em = $this->modelManager->getRepository(ModelManager::class);
        $em->persist($liveShoppingElement);
        $em->flush();
    }


    private function createTable(): void
    {
        $createQuery = <<<SQL
CREATE TABLE `s_plugin_live_shopping_item` (
  `id` INT(11) UNSIGNED NOT NULL,
  `article_id` INT(11) UNSIGNED NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 0,
  `start_date` DATETIME NOT NULL,
  `end_date` DATETIME NOT NULL,
  `saving_absolute` DECIMAL(6,2) NOT NULL,
  `created` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_s_plugin_live_shopping_item_id_idx` (`article_id` ASC),
  CONSTRAINT `fk_s_plugin_live_shopping_item_id`
    FOREIGN KEY (`article_id`)
    REFERENCES `shopware`.`s_articles` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

SQL;
        $this->connection->query($createQuery);
    }
}
