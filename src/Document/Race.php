<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Document\Traits;

#[MongoDB\Document(collection: 'Race')]
class Race extends BaseModel
{
	#[MongoDB\Id]
	private string $id;

    #[MongoDB\Field(type: "string")]
    private string $name;

    #[MongoDB\Field(type: "string")]
    private string $nameGeneric;

    #[MongoDB\Field(type: "string")]
    private string $description;

	#[MongoDB\ReferenceMany(targetDocument: Traits::class)]
	private array $traits = [];

    // For example: ['Common', 'Elvish']
    #[MongoDB\Field(type: "collection")]
    private array $languages = [];

    // Walking speed in feet
    #[MongoDB\Field(type: "int")]
    private int $speed = 30;

    // Optional subrace if applicable
	#[MongoDB\Field(type: "collection")]
    private array $subrace = [];

	#[MongoDB\Field(type: "string")]
	private string $type;

    #[MongoDB\Field(type: "string")]
    private string $size;

	#[MongoDB\Field(type: 'bool')]
	private bool $accepted = false;

    public function getName(): string
    {
	    return $this->name;
    }

    public function setName(string $name): self
    {
	    $this->name = $name;
	    return $this;
    }

    public function getNameGeneric(): string
    {
	    return $this->nameGeneric;
    }

    public function setNameGeneric(string $nameGeneric): self
    {
	    $this->nameGeneric = $nameGeneric;
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

    public function getSubrace(): array
    {
	    return $this->subrace;
    }

    public function addSubrace(array $subrace): self
    {
	    $this->subrace = $subrace;
	    return $this;
    }

	public function getSize(): string
	{
		return $this->size;
	}

	public function setSize(string $size): self
	{
		$this->size = $size;
		return $this;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): self
	{
		$this->type = $type;
		return $this;
	}

	public function isAccepted(): bool
	{
		return $this->accepted;
	}

	public function setAccepted (bool $accepted): self
	{
		$this->accepted = $accepted;
		return $this;
	}
}
