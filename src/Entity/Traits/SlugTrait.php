<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait SlugTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'ascii_string', unique: true)]
    private AbstractUnicodeString $slug;

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = (new AsciiSlugger())->slug($slug);

        return $this;
    }
}