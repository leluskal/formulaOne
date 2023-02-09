<?php
declare(strict_types=1);

namespace App\Model\Entities\Schedule;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule")
 */
class Schedule
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private DateTime $dateFrom;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private DateTime $dateTo;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $year;

    public function __construct(DateTime $dateFrom, DateTime $dateTo, string $name, int $year)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->name = $name;
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDateFrom(): DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTime $dateFrom
     */
    public function setDateFrom(DateTime $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return DateTime
     */
    public function getDateTo(): DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param DateTime $dateTo
     */
    public function setDateTo(DateTime $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}