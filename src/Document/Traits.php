<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Race')]
class Traits extends BaseModel
{
	#[MongoDB\Id]
	private string $id;

	#[MongoDB\Field(type: "string")]
	private string $title;

	#[MongoDB\Field(type: "string")]
	private string $titleGeneric;

	#[MongoDB\Field(type: "string")]
	private string $description;

	public function getId(): ?string
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}
	public function setTitle(string $title): self
	{
		$this->title = $title;
		return $this;
	}

	public function getTitleGeneric(): string
	{
		return $this->titleGeneric;
	}
	public function setTitleGeneric(string $titleGeneric): self
	{
		$this->titleGeneric = $titleGeneric;
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
}
