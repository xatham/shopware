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

namespace LiveShopping\Models;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;
use Shopware\Models\Article\Detail;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_plugin_live_shopping_item")
 */
class LiveShoppingItem extends ModelEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Detail::class)
     *
     * @var Detail
     */
    private $article;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $active;

    /**
     * @ORM\Column(type="datetime_immutable", name="start_date")
     *
     * @var DateTimeImmutable
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true, name="end_date")
     *
     * @var DateTimeImmutable
     */
    private $endDate;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, name="saving_absolute")
     *
     * @var float
     */
    private $savingAbsolute;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): LiveShoppingItem
    {
        $this->id = $id;

        return $this;
    }

    public function getArticle(): Detail
    {
        return $this->article;
    }

    public function setArticle($article): LiveShoppingItem
    {
        $this->article = $article;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): LiveShoppingItem
    {
        $this->active = $active;

        return $this;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): LiveShoppingItem
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): LiveShoppingItem
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getSavingAbsolute(): float
    {
        return $this->savingAbsolute;
    }

    public function setSavingAbsolute(float $savingAbsolute): LiveShoppingItem
    {
        $this->savingAbsolute = $savingAbsolute;

        return $this;
    }
}
