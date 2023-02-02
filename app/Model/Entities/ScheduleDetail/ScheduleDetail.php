<?php
declare(strict_types=1);

namespace App\Model\Entities\ScheduleDetail;

use App\Model\Entities\Discipline\Discipline;
use App\Model\Entities\Schedule\Schedule;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule_detail")
 */
class ScheduleDetail
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
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $eventDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Discipline\Discipline", fetch="EAGER")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id", nullable=false)
     */
    private Discipline $discipline;

    public function __construct(Schedule $schedule, DateTime $eventDate, Discipline $discipline)
    {
        $this->schedule = $schedule;
        $this->eventDate = $eventDate;
        $this->discipline = $discipline;
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
     * @return DateTime
     */
    public function getEventDate(): DateTime
    {
        return $this->eventDate;
    }

    /**
     * @param DateTime $eventDate
     */
    public function setEventDate(DateTime $eventDate): void
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return Discipline
     */
    public function getDiscipline(): Discipline
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     */
    public function setDiscipline(Discipline $discipline): void
    {
        $this->discipline = $discipline;
    }
}