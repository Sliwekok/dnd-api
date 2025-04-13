<?php
	declare(strict_types=1);

	namespace App\Document;

	use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

	#[MongoDB\EmbeddedDocument]
	class Subrace
	{
		#[MongoDB\Field(type: "string")]
		private string $name;

		#[MongoDB\Field(type: "string")]
		private string $description;

		#[MongoDB\Field(type: "hash")]
		private array $abilityScoreIncreases = [];

		#[MongoDB\Field(type: "collection")]
		private array $traits = [];

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
	}
