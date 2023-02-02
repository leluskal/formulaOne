<?php
declare(strict_types=1);

namespace App\Model\Entities\TeamDriver;

use App\Model\Entities\Driver\Driver;
use App\Model\Entities\Team\Team;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_driver")
 */
class TeamDriver
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Team\Team", fetch="EAGER")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", nullable=false)
     */
    private Team $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Driver\Driver", fetch="EAGER")
     * @ORM\JoinColumn(name="driver_id", referencedColumnName="id", nullable=false)
     */
    private Driver $driver;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $year;

    public function __construct(Team $team, Driver $driver, int $year)
    {
        $this->team = $team;
        $this->driver = $driver;
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
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    /**
     * @return Driver
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }

    /**
     * @param Driver $driver
     */
    public function setDriver(Driver $driver): void
    {
        $this->driver = $driver;
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