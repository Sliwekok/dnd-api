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
