<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\ApplicantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicantRepository::class)]
#[ORM\Table(name: "applicants")]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Applicant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?int $experienceYears = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[Vich\UploadableField(mapping: "applicant_resumes", fileNameProperty: "resume")]
    private ?File $resumeFile;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $submitedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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
}
