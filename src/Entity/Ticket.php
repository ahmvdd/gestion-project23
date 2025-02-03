<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'ticket')]
    private Collection $created_by;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'ticket')]
    private Collection $assigned_to;

    /**
     * @var Collection<int, categories>
     */
    #[ORM\OneToMany(targetEntity: Categories::class, mappedBy: 'ticket')]
    private Collection $category_id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->created_by = new ArrayCollection();
        $this->assigned_to = new ArrayCollection();
        $this->category_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, user>
     */
    public function getCreatedBy(): Collection
    {
        return $this->created_by;
    }

    public function addCreatedBy(user $createdBy): static
    {
        if (!$this->created_by->contains($createdBy)) {
            $this->created_by->add($createdBy);
            $createdBy->setTicket($this);
        }

        return $this;
    }

    public function removeCreatedBy(user $createdBy): static
    {
        if ($this->created_by->removeElement($createdBy)) {
            // set the owning side to null (unless already changed)
            if ($createdBy->getTicket() === $this) {
                $createdBy->setTicket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getAssignedTo(): Collection
    {
        return $this->assigned_to;
    }

    public function addAssignedTo(user $assignedTo): static
    {
        if (!$this->assigned_to->contains($assignedTo)) {
            $this->assigned_to->add($assignedTo);
            $assignedTo->setTicket($this);
        }

        return $this;
    }

    public function removeAssignedTo(user $assignedTo): static
    {
        if ($this->assigned_to->removeElement($assignedTo)) {
            // set the owning side to null (unless already changed)
            if ($assignedTo->getTicket() === $this) {
                $assignedTo->setTicket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, categories>
     */
    public function getCategoryId(): Collection
    {
        return $this->category_id;
    }

    public function addCategoryId(categories $categoryId): static
    {
        if (!$this->category_id->contains($categoryId)) {
            $this->category_id->add($categoryId);
            $categoryId->setTicket($this);
        }

        return $this;
    }

    public function removeCategoryId(categories $categoryId): static
    {
        if ($this->category_id->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getTicket() === $this) {
                $categoryId->setTicket(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
