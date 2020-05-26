<?php
declare(strict_types=1);

namespace RZ\Roadiz\Core\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Abstract entity for any Human-like objects.
 *
 * This class can be extended for *Users*, *Subscribers*, etc.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractHuman extends AbstractDateTimed
{
    /**
     * @ORM\Column(type="string", unique=true)
     * @Serializer\Groups({"user", "human"})
     * @var string|null
     */
    protected $email;

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        if (filter_var($email ?? '', FILTER_VALIDATE_EMAIL) !== false) {
            $this->email = $email;
        }

        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Groups({"user", "human"})
     * @var string|null
     */
    protected $firstName;

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Groups({"user", "human"})
     * @var string|null
     */
    protected $lastName;
    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Groups({"user", "human"})
     */
    protected $phone;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Groups({"user", "human"})
     */
    protected $company;

    /**
     * @return string|null
     */
    public function getCompany()
    {
        return $this->company;
    }
    /**
     * @param string|null $company
     *
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Groups({"user", "human"})
     */
    protected $job;
    /**
     * @return string|null
     */
    public function getJob()
    {
        return $this->job;
    }
    /**
     * @param string|null $job
     *
     * @return $this
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Groups({"user", "human"})
     */
    protected $birthday;
    /**
     * @return \DateTime|null
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
    /**
     * @param \DateTime|null $birthday
     *
     * @return $this
     */
    public function setBirthday(?\DateTime $birthday = null)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Gets the value of phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the value of phone.
     *
     * @param string|null $phone the phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
