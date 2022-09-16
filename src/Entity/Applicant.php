<?php

namespace App\Entity;

use App\Config\Gender;
use App\Entity\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\ApplicantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicantRepository::class)]
#[ORM\Table(name: "applicants")]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Applicant
{
    use Timestampable;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?Gender $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;
    
    #[ORM\ManyToOne(inversedBy: 'applicants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Position $position = null;

    #[ORM\Column]
    private ?int $experienceYears = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[Vich\UploadableField(mapping: 'applicant_resumes', fileNameProperty: 'resume')]
    private ?File $resumeFile;

    #[ORM\Column]
    private ?\DateTimeImmutable $submitedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getExperienceYears(): ?int
    {
        return $this->experienceYears;
    }

    public function setExperienceYears(int $experienceYears): self
    {
        $this->experienceYears = $experienceYears;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $resumeFile
     */
    public function setResumeFile(?File $resumeFile = null): void
    {
        $this->resumeFile = $resumeFile;

        if (null !== $resumeFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setSubmitedAt(new \DateTimeImmutable);
        }
    }

    public function getResumeFile(): ?File
    {
        return $this->resumeFile;
    }

    public function getSubmitedAt(): ?\DateTimeImmutable
    {
        return $this->submitedAt;
    }

    public function setSubmitedAt(\DateTimeImmutable $submitedAt): self
    {
        $this->submitedAt = $submitedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable);
        $this->setSubmitedAt(new \DateTimeImmutable);
    }

}