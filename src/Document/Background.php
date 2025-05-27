<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Background')]
class Background extends BaseModel
{
	#[MongoDB\Id]
	private string $id;

    #[MongoDB\Field(type: "string")]
    private string $name;

    #[MongoDB\Field(type: "string")]
    private string $nameGeneric;

    #[MongoDB\Field(type: "string")]
    private string $description;

	#[MongoDB\Field(type: "collection")]
	private array $abilityScores = [];

	#[MongoDB\Field(type: "string")]
	private string $feature;

	#[MongoDB\Field(type: "collection")]
	private array $skillProficiency = [];

	#[MongoDB\Field(type: "collection")]
	private array $toolProficiency = [];

	#[MongoDB\Field(type: "collection")]
	private array $equipment = [];

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

    public function getAbilityScores(): array
    {
	    return $this->abilityScores;
    }

    public function addAbilityScores(array $abilityScores): self
    {
	    $this->abilityScores = $abilityScores;
	    return $this;
    }

	public function getFeature(): string
	{
		return $this->feature;
	}

	public function setFeature(string $feature): self
	{
		$this->feature = $feature;
		return $this;
	}

	public function getSkillProficiency(): array
	{
		return $this->skillProficiency;
	}

	public function setSkillProficiency(array $skillProficiency): self
	{
		$this->skillProficiency = $skillProficiency;
		return $this;
	}

	public function getToolProficiency(): array
	{
		return $this->toolProficiency;
	}

	public function setToolProficiency(array $toolProficiency): self
	{
		$this->toolProficiency = $toolProficiency;
		return $this;
	}

	public function getEquipment(): array
	{
		return $this->equipment;
	}

	public function setEquipment(array $equipment): self
	{
		$this->equipment = $equipment;
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
