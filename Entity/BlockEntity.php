<?php
/**
 * Copyright Zikula Foundation 2013 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Zikula\BlocksModule\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\BlocksModule\Entity\BlockPlacementEntity;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\ExtensionsModule\Entity\ExtensionEntity;

/**
 * Block entity class.
 *
 * @ORM\Entity(repositoryClass="Zikula\BlocksModule\Entity\Repository\BlockRepository")
 * @ORM\Table(name="blocks",indexes={@ORM\Index(name="active_idx",columns={"active"})})
 */
class BlockEntity extends EntityAccess
{
    /**
     * The block id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bid;

    /**
     * The block key
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $bkey;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $blocktype;

    /**
     * The block title
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * The block description
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * The block content 
     *
     * A seralized array of block content variables
     *
     * @ORM\Column(type="array")
     */
    private $content;

    /**
     * The id of the module owning the block
     *
     * @ORM\ManyToOne(targetEntity="Zikula\ExtensionsModule\Entity\ExtensionEntity")
     * @ORM\JoinColumn(name="mid", referencedColumnName="id")
     **/
    private $module;

    /**
     * The display filter to apply to the block
     *     
     * @ORM\Column(name="filter", type="array")
     */
    private $filters;

    /**
     * The active status of the block
     *
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * The last updated timestamp of the block
     *
     * @ORM\Column(type="datetime")
     */
    private $last_update;

    /**
     * The language of the block
     *
     * @ORM\Column(type="string", length=30)
     */
    private $language;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Zikula\BlocksModule\Entity\BlockPlacementEntity",
     *     mappedBy="block",
     *     cascade={"remove", "persist"},
     *     orphanRemoval=true)
     */
    private $placements;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->bkey = '';
        $this->title = '';
        $this->description = '';
        $this->blocktype = '';
        $this->content = [];
        $this->module = 0;
        $this->filters = array();
        $this->active = 1;
        $this->last_update = new \DateTime("now");
        $this->language = '';
        $this->placements = new ArrayCollection();
    }

    /**
     * get the id of the block
     *
     * @return integer the block's id
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * set the id for the block
     *
     * @param integer $bid the block's id
     */
    public function setBid($bid)
    {
        $this->bid = $bid;
    }

    /**
     * get the bkey of the block
     *
     * @return string the block's bkey
     */
    public function getBkey()
    {
        return $this->bkey;
    }

    /**
     * set the bkey for the block
     *
     * @param string $bkey the block's bkey
     */
    public function setBkey($bkey)
    {
        $this->bkey = $bkey;
    }

    /**
     * @return string
     */
    public function getBlocktype()
    {
        return $this->blocktype;
    }

    /**
     * @param string $blocktype
     */
    public function setBlocktype($blocktype)
    {
        $this->blocktype = $blocktype;
    }

    /**
     * get the title of the block
     *
     * @return string the block's title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set the title for the block
     *
     * @param string $title the block's title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * get the description of the block
     *
     * @return string the block's description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set the description for the block
     *
     * @param string $description the block's description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get the content of the block
     *
     * @return string the block's content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * set the content for the block
     *
     * @param string $content the block's content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * get the module that the block belongs to
     *
     * @return ExtensionEntity
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * set the module that the block belongs to
     *
     * @param \Zikula\ExtensionsModule\Entity\ExtensionEntity $module
     */
    public function setModule(ExtensionEntity $module)
    {
        $this->module = $module;
    }

    /**
     * get the filters of the block
     *
     * @return array the block's filters
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * set the filters for the block
     *
     * @param array $filter the blocks's filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * get the status of the block
     *
     * @return integer the status number (0=inactive, 1=active)
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * set the status of the block
     *
     * @param integer $active the status number (0=inactive, 1=active)
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * get last update time of the block
     *
     * @return \DateTime the block's last updated time
     */
    public function getLast_Update()
    {
        return $this->last_update;
    }

    /**
     * set the last updated time of the block
     *
     * @param none
     */
    public function setLast_Update()
    {
        $this->last_update = new \DateTime("now");
    }

    /**
     * get the language of the block
     *
     * @return string the block's language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * set the language of the block
     *
     * @param string $language the block's language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getPlacements()
    {
        return $this->placements;
    }

    public function addPlacement(BlockPlacementEntity $placement)
    {
        if (!$this->placements->contains($placement)) {
            $this->placements->add($placement);
        }
    }

    public function removePlacement(BlockPlacementEntity $placement)
    {
        if ($this->placements->contains($placement)) {
            $this->placements->removeElement($placement);
        }
    }

    /**
     * Get an ArrayCollection of BlockPositionEntity that are assigned to this Block
     * @return ArrayCollection
     */
    public function getPositions()
    {
        $positions = new ArrayCollection();
        foreach($this->getPlacements() as $placement) {
            $positions->add($placement->getPosition());
        }

        return $positions;
    }

    /**
     * Set BlockPlacementsEntity from provided ArrayCollection of positionEntity
     * requires
     *   cascade={"remove, "persist"}
     *   orphanRemoval=true
     *   on the association of $this->placements
     * @param ArrayCollection $positions
     */
    public function setPositions(ArrayCollection $positions)
    {
        // remove placements and skip existing placements.
        foreach ($this->placements as $placement) {
            if (!$positions->contains($placement->getPosition())) {
                $this->placements->removeElement($placement);
            } else {
                $positions->removeElement($placement->getPosition()); // remove from positions to add.
            }
        }

        // add new placements
        foreach ($positions as $position) {
            $placement = new BlockPlacementEntity();
            $placement->setPosition($position);
            // sortorder is irrelevant at this stage.
            $placement->setBlock($this); // auto-adds placement
        }
    }
}
