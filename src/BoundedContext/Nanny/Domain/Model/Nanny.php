<?php

namespace App\BoundedContext\Nanny\Domain\Model;

use DateTime;

/**
 * Class Nanny
 *
 * @author Sparesotto Anaïs <a.sparesotto@icloud.com>
 */
class Nanny
{
    /**
     * @var string
     */
    private string $uuid;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var \DateTime
     */
    private ?DateTime $birthday;

    /**
     * @var string
     */
    private ?string $adresse;

    /**
     * @var string
     */
    private ?string $postalCode;

    /**
     * @var string
     */
    private ?string $city;

    /**
     * @var string
     */
    private ?string $phoneNumber;

    /**
     * @var string
     */
    private ?string $function;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var \DateTime
     */
    private DateTime $dateRecording;

    /**
     * Nanny constructor.
     *
     * @param string    $uuid
     * @param string    $lastName
     * @param string    $firstName
     * @param \DateTime $birthday
     * @param string    $adresse
     * @param string    $postalCode
     * @param string    $city
     * @param string    $phoneNumber
     * @param string    $function
     * @param string    $email
     * @param string    $password
     * @param \DateTime $dateRecording
     */
    public function __construct(
        string $uuid,
        string $lastName,
        string $firstName,
        DateTime $birthday,
        string $adresse,
        string $postalCode,
        string $city,
        string $phoneNumber,
        string $function,
        string $email,
        string $password,
        DateTime $dateRecording
    ) {
        $this->uuid = $uuid;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->birthday = $birthday;
        $this->adresse = $adresse;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->phoneNumber = $phoneNumber;
        $this->function = $function;
        $this->email = $email;
        $this->password = $password;
        $this->dateRecording = $dateRecording;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday(\DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     */
    public function setFunction(string $function): void
    {
        $this->function = $function;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getDateRecording(): \DateTime
    {
        return $this->dateRecording;
    }

    /**
     * @param \DateTime $dateRecording
     */
    public function setDateRecording(\DateTime $dateRecording): void
    {
        $this->dateRecording = $dateRecording;
    }
}
