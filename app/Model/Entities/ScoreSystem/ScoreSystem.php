<?php
declare(strict_types=1);

namespace App\Model\Entities\ScoreSystem;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="score_system")
 */
class ScoreSystem
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $position;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $points;

    public function __construct(int $position, int $points)
    {
        $this->position = $position;
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
}