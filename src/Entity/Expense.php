<?php

namespace App\Entity;

use App\Repository\ExpenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpenseRepository::class)
 */
class Expense
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $Amount;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="expenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Payer;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="expenses")
     */
    private $Participant;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="expenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Tricount;

    public function __construct()
    {
        $this->Participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getPayer(): ?User
    {
        return $this->Payer;
    }

    public function setPayer(?User $Payer): self
    {
        $this->Payer = $Payer;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipant(): Collection
    {
        return $this->Participant;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->Participant->contains($participant)) {
            $this->Participant[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->Participant->removeElement($participant);

        return $this;
    }

    public function getTricount(): ?Tricount
    {
        return $this->Tricount;
    }

    public function setTricount(?Tricount $Tricount): self
    {
        $this->Tricount = $Tricount;

        return $this;
    }
}
