<?php
declare(strict_types=1);

namespace App\Model\Entities\RaceResult;

use App\Model\Entities\Driver\Driver;
use App\Model\Entities\Schedule\Schedule;
use App\Model\Entities\ScoreSystem\ScoreSystem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="race_result")
 */
class RaceResult
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Schedule\Schedule", fetch="EAGER")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=false)
     */
    private Schedule $schedule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Driver\Driver", fetch="EAGER")
     * @ORM\JoinColumn(name="driver_id", referencedColumnName="id", nullable=false)
     */
    private Driver $driver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\ScoreSystem\ScoreSystem", fetch="EAGER")
     * @ORM\JoinColumn(name="score_system_id", referencedColumnName="id", nullable=false)
     */
    private ScoreSystem $scoreSystem;

    public function __construct(Schedule $schedule, Driver $driver, ScoreSystem $scoreSystem)
    {
        $this->schedule = $schedule;
        $this->driver = $driver;
        $this->scoreSystem = $scoreSystem;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Schedule
     */
    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * @param Schedule $schedule
     */
    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule = $schedule;
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
     * @return ScoreSystem
     */
    public function getScoreSystem(): ScoreSystem
    {
        return $this->scoreSystem;
    }

    /**
     * @param ScoreSystem $scoreSystem
     */
    public function setScoreSystem(ScoreSystem $scoreSystem): void
    {
        $this->scoreSystem = $scoreSystem;
    }
}