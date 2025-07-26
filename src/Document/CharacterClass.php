<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Traits')]
class CharacterClass extends BaseModel
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
    private array $primaryAbility = [];

    #[MongoDB\Field(type: "int")]
    private int $hitPointsDie;

    #[MongoDB\Field(type: "collection")]
    private array $savingThrowProficiency = [];

    #[MongoDB\Field(type: "collection")]
    private array $skillProficiencies = [];

    #[MongoDB\Field(type: "collection")]
    private array $weaponProficiencies = [];

    #[MongoDB\Field(type: "collection")]
    private array $armorTraining = [];

	#[MongoDB\Field(type: 'bool')]
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

	public function getDescription(): string
	{
		return $this->description;
	}
	public function setDescription(string $description): self
	{
		$this->description = $description;
		return $this;
	}

    public function getPrimaryAbility(): array
    {
        return $this->primaryAbility;
    }

    public function setPrimaryAbility(array $primaryAbility): void
    {
        $this->primaryAbility = $primaryAbility;
    }

    public function getHitPointsDie(): int
    {
        return $this->hitPointsDie;
    }

    public function setHitPointsDie(int $hitPointsDie): void
    {
        $this->hitPointsDie = $hitPointsDie;
    }

    public function getSavingThrowProficiency(): array
    {
        return $this->savingThrowProficiency;
    }

    public function setSavingThrowProficiency(array $savingThrowProficiency): void
    {
        $this->savingThrowProficiency = $savingThrowProficiency;
    }

    public function getSkillProficiencies(): array
    {
        return $this->skillProficiencies;
    }

    public function setSkillProficiencies(array $skillProficiencies): void
    {
        $this->skillProficiencies = $skillProficiencies;
    }

    public function getWeaponProficiencies(): array
    {
        return $this->weaponProficiencies;
    }

    public function setWeaponProficiencies(array $weaponProficiencies): void
    {
        $this->weaponProficiencies = $weaponProficiencies;
    }

    public function getArmorTraining(): array
    {
        return $this->armorTraining;
    }

    public function setArmorTraining(array $armorTraining): void
    {
        $this->armorTraining = $armorTraining;
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
