<?php
    declare(strict_types=1);

    namespace App\Document;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

    #[MongoDB\Document]
    class Race
    {
	    #[MongoDB\Field(type: "string")]
	    private string $name;

	    #[MongoDB\Field(type: "string")]
	    private string $description;

	    // For example: ['str' => 1, 'cha' => 2]
	    #[MongoDB\Field(type: "hash")]
	    private array $abilityScoreIncreases = [];

	    // For example: ['Darkvision', 'Fey Ancestry']
	    #[MongoDB\Field(type: "collection")]
	    private array $traits = [];

	    // For example: ['Common', 'Elvish']
	    #[MongoDB\Field(type: "collection")]
	    private array $languages = [];

	    // Walking speed in feet
	    #[MongoDB\Field(type: "int")]
	    private int $speed = 30;

	    // Optional subraces if applicable (e.g. High Elf, Wood Elf)
	    #[MongoDB\EmbedMany(targetDocument: Subrace::class)]
	    private iterable $subraces = [];

	    public function getName(): string
	    {
		    return $this->name;
	    }

	    public function setName(string $name): self
	    {
		    $this->name = $name;
		    return $this;
	    }

	    public function getDescription(): string
	    {
		    return $this->description;
	    }

	    public function setDescription(string $description): self
	    {
		    $this->description = $description;
		    return $this;
	    }

	    public function getAbilityScoreIncreases(): array
	    {
		    return $this->abilityScoreIncreases;
	    }

	    public function setAbilityScoreIncreases(array $scores): self
	    {
		    $this->abilityScoreIncreases = $scores;
		    return $this;
	    }

	    public function getTraits(): array
	    {
		    return $this->traits;
	    }

	    public function setTraits(array $traits): self
	    {
		    $this->traits = $traits;
		    return $this;
	    }

	    public function getLanguages(): array
	    {
		    return $this->languages;
	    }

	    public function setLanguages(array $languages): self
	    {
		    $this->languages = $languages;
		    return $this;
	    }

	    public function getSpeed(): int
	    {
		    return $this->speed;
	    }

	    public function setSpeed(int $speed): self
	    {
		    $this->speed = $speed;
		    return $this;
	    }

	    public function getSubraces(): iterable
	    {
		    return $this->subraces;
	    }

	    public function addSubrace(Subrace $subrace): self
	    {
		    $this->subraces[] = $subrace;
		    return $this;
	    }
    }
