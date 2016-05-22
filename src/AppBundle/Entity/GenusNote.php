<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusNoteRepository")
 * @ORM\Table(name="genus_note")
 */
class GenusNote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $userAvatarFilename;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Genus", inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genus;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUserAvatarFilename()
    {
        return $this->userAvatarFilename;
    }

    public function setUserAvatarFilename($userAvatarFilename)
    {
        $this->userAvatarFilename = $userAvatarFilename;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getGenus()
    {
        return $this->genus;
    }

    public function setGenus(Genus $genus)
    {
        $this->genus = $genus;
    }

    public function getId()
    {
        return $this->id;
    }
}
