<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait SlugTrait
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $slug;

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    private function getValueToSlugify(): string
    {
        return $this->name;
    }

    #[ORM\PrePersist]
    public function setSlugOnCreate(): void
    {
        $slugger = new AsciiSlugger();

        $this->setSlug($slugger->slug($this->getValueToSlugify())->snake()->toString());
    }
}