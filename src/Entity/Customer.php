<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"default"=""})
     * @Assert\NotBlank
     */
    private $name = "";

    /**
     * @ORM\Column(type="string", length=255, options={"default"=""})
     */
    private $commercialName = "";

    /**
     * @ORM\Column(type="string", length=6, nullable=true, options={"default"=null})
     * @Assert\Length(
     *      min = 2,
     *      max = 6,
     *      allowEmptyString = true
     * )
     */
    private $acronym = null;

    /**
     * @ORM\Column(type="string", length=25, options={"default"="#444444"})
     */
    private $backColor = "#444444";

    /**
     * @ORM\Column(type="string", length=25, options={"default"="#eeeeee"})
     */
    private $foreColor = "#eeeeee";

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="customer")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    public function setCommercialName(string $commercialName): self
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    public function getAcronym(): ?string
    {
        return $this->acronym;
    }

    public function setAcronym(?string $acronym): self
    {
        $this->acronym = $acronym;

        return $this;
    }

    public function getBackColor(): ?string
    {
        return $this->backColor;
    }

    public function setBackColor(string $backColor): self
    {
        $this->backColor = $backColor;

        return $this;
    }

    public function getForeColor(): ?string
    {
        return $this->foreColor;
    }

    public function setForeColor(string $foreColor): self
    {
        $this->foreColor = $foreColor;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setCustomer($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getCustomer() === $this) {
                $task->setCustomer(null);
            }
        }

        return $this;
    }
}
