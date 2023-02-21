<?php
declare(strict_types=1);

namespace App\Model\Entities\Driver;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="driver")
 */
class Driver
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $lastname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $country;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $numberOfPodiums;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private float $numberOfPoints;

    public function __construct(
        string $firstname,
        string $lastname,
        string $country,
        int $numberOfPodiums,
        float $numberOfPoints
    )
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->country = $country;
        $this->numberOfPodiums = $numberOfPodiums;
        $this->numberOfPoints = $numberOfPoints;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return int
     */
    public function getNumberOfPodiums(): int
    {
        return $this->numberOfPodiums;
    }

    /**
     * @param int $numberOfPodiums
     */
    public function setNumberOfPodiums(int $numberOfPodiums): void
    {
        $this->numberOfPodiums = $numberOfPodiums;
    }

    /**
     * @return float
     */
    public function getNumberOfPoints(): float
    {
        return $this->numberOfPoints;
    }

    /**
     * @param float $numberOfPoints
     */
    public function setNumberOfPoints(float $numberOfPoints): void
    {
        $this->numberOfPoints = $numberOfPoints;
    }
}