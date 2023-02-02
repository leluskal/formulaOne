<?php
declare(strict_types=1);

namespace App\Model\Entities\TeamChief;

use App\Model\Entities\Chief\Chief;
use App\Model\Entities\Team\Team;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="team_chief")
 */
class TeamChief
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Chief\Chief", fetch="EAGER")
     * @ORM\JoinColumn(name="chief_id", referencedColumnName="id", nullable=false)
     */
    private Chief $chief;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $year;

    public function __construct(Team $team, Chief $chief, int $year)
    {
        $this->team = $team;
        $this->chief = $chief;
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
     * @return Chief
     */
    public function getChief(): Chief
    {
        return $this->chief;
    }

    /**
     * @param Chief $chief
     */
    public function setChief(Chief $chief): void
    {
        $this->chief = $chief;
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