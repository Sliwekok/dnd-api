<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document]
class Spell extends BaseModel
{

    public static array $allowedFields = [
        'level' => ['key' => 'level', 'type' => 'integer'],
        'school' => ['key' => 'school', 'type' => 'string'],
        'actionType' => ['key' => 'actionType', 'type' => 'string'],
        'classes' => ['key' => 'classes', 'type' => 'array'],
        'concentration' => ['key' => 'concentration', 'type' => 'boolean'],
        'ritual' => ['key' => 'ritual', 'type' => 'boolean'],
    ];


    #[ODM\Id]
    private string $id;

    #[ODM\Field(type: 'string')]
    private string $name;

	#[ODM\Field(type: 'string')]
	private string $nameGeneric;

    #[ODM\Field(type: 'int')]
    private int $level;

    #[ODM\Field(type: 'string')]
    private string $school;

    #[ODM\Field(type: 'string')]
    private string $actionType;

    #[ODM\Field(type: 'string')]
    private string $range;

    #[ODM\Field(type: 'string')]
    private string $duration;

    #[ODM\Field(type: 'collection')]
    private array $components = [];

	#[ODM\Field(type: 'string')]
	private ?string $componentMaterial = null;

	#[ODM\Field(type: 'string')]
    private string $description;

    #[ODM\Field(type: 'string')]
    private string $castingTime;

    #[ODM\Field(type: 'collection')]
    private array $classes = [];

    #[ODM\Field(type: 'bool')]
    private bool $concentration = false;

    #[ODM\Field(type: 'bool')]
    private bool $ritual = false;

	#[ODM\Field(type: 'bool')]
	private bool $accepted = false;

    public function getId(): ?string
    {
        return $this->id;
    }

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

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getSchool(): string
    {
        return $this->school;
    }

    public function setSchool(string $school): self
    {
        $this->school = $school;
        return $this;
    }

    public function getActionType(): string
    {
        return $this->actionType;
    }

    public function setActionType(string $actionType): self
    {
        $this->actionType = $actionType;
        return $this;
    }

    public function getCastingTime(): string
    {
        return $this->castingTime;
    }

    public function setCastingTime(string $castingTime): self
    {
        $this->castingTime = $castingTime;
        return $this;
    }

    public function getRange(): string
    {
        return $this->range;
    }

    public function setRange(string $range): self
    {
        $this->range = $range;
        return $this;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function setComponents(array $components): self
    {
        $this->components = $components;
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

    public function getClasses(): array
    {
        return $this->classes;
    }

    public function setClasses(array $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    public function isConcentration(): bool
    {
        return $this->concentration;
    }

    public function setConcentration(bool $concentration): self
    {
        $this->concentration = $concentration;
        return $this;
    }

    public function isRitual(): bool
    {
        return $this->ritual;
    }

    public function setRitual(bool $ritual): self
    {
        $this->ritual = $ritual;
        return $this;
    }

	public function getComponentMaterial(): ?string
	{
		return $this->componentMaterial;
	}

	public function setComponentMaterial(string $componentMaterial): self
	{
		$this->componentMaterial = $componentMaterial;
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
