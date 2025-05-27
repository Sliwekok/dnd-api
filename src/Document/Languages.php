<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Languages')]
class Languages extends BaseModel
{
	#[MongoDB\Id]
	private string $id;

	#[MongoDB\Field(type: "string")]
	private string $name;

	#[MongoDB\Field(type: "string")]
	private string $nameGeneric;

    #[MongoDB\Field(type: "string")]
    private string $rarity;

    #[MongoDB\Field(type: "string")]
    private string $origin;

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

    public function getRarity(): string
    {
        return $this->rarity;
    }
    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;
        return $this;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }
    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;
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

    public function __toString(): string
    {
        return $this->name;
    }
}
