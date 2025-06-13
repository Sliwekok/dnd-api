<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Monster')]
class Monster
{
	#[MongoDB\Id]
	private string $id;

	#[MongoDB\Field(type: 'string')]
	private string $name;

	#[MongoDB\Field(type: 'string')]
	private string $type;

	#[MongoDB\Field(type: 'string')]
	private string $initiative = '';

	#[MongoDB\Field(type: 'string')]
	private string $ac;

	#[MongoDB\Field(type: 'string')]
	private string $hp;

	#[MongoDB\Field(type: 'string')]
	private string $speed;

	#[MongoDB\Field(type: 'collection')]
	private array $abilities = [];

	#[MongoDB\Field(type: 'string')]
	private string $skills = '';

	#[MongoDB\Field(type: 'string')]
	private string $senses;

	#[MongoDB\Field(type: 'string')]
	private string $languages;

	#[MongoDB\Field(type: 'string')]
	private string $cr;

	#[MongoDB\Field(type: 'collection')]
	private array $actions = [];

	#[MongoDB\Field(type: 'collection')]
	private array $reactions = [];

	#[MongoDB\Field(type: 'string')]
	private string $description;

	#[MongoDB\Field(type: 'collection')]
	private array $habitat = [];

	#[MongoDB\Field(type: 'string')]
	private string $source;

	#[MongoDB\Field(type: 'string')]
	private string $url;

	#[MongoDB\Field(type: 'bool')]
	private bool $accepted = false;


	#[MongoDB\Field(type: 'string')]
	private string $nameGeneric;

	/**
	 * @return string
	 */
	public function getId (): string
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 *
	 * @return Monster
	 */

	/**
	 * @return string
	 */
	public function getNameGeneric (): string
	{
		return $this->nameGeneric;
	}

	/**
	 * @param string $nameGeneric
	 *
	 * @return Monster
	 */
	public function setNameGeneric (string $nameGeneric): Monster
	{
		$this->nameGeneric = $nameGeneric;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isAccepted (): bool
	{
		return $this->accepted;
	}

	/**
	 * @param bool $accepted
	 *
	 * @return Monster
	 */
	public function setAccepted (bool $accepted): Monster
	{
		$this->accepted = $accepted;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl (): string
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 *
	 * @return Monster
	 */
	public function setUrl (string $url): Monster
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSource (): string
	{
		return $this->source;
	}

	/**
	 * @param string $source
	 *
	 * @return Monster
	 */
	public function setSource (string $source): Monster
	{
		$this->source = $source;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getHabitat (): array
	{
		return $this->habitat;
	}

	/**
	 * @param array $habitat
	 *
	 * @return Monster
	 */
	public function setHabitat (array $habitat): Monster
	{
		$this->habitat = $habitat;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription (): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 *
	 * @return Monster
	 */
	public function setDescription (string $description): Monster
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getReactions (): array
	{
		return $this->reactions;
	}

	/**
	 * @param array $reactions
	 *
	 * @return Monster
	 */
	public function setReactions (array $reactions): Monster
	{
		$this->reactions = $reactions;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getActions (): array
	{
		return $this->actions;
	}

	/**
	 * @param array $actions
	 *
	 * @return Monster
	 */
	public function setActions (array $actions): Monster
	{
		$this->actions = $actions;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCr (): string
	{
		return $this->cr;
	}

	/**
	 * @param string $cr
	 *
	 * @return Monster
	 */
	public function setCr (string $cr): Monster
	{
		$this->cr = $cr;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguages (): string
	{
		return $this->languages;
	}

	/**
	 * @param string $languages
	 *
	 * @return Monster
	 */
	public function setLanguages (string $languages): Monster
	{
		$this->languages = $languages;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSenses (): string
	{
		return $this->senses;
	}

	/**
	 * @param string $senses
	 *
	 * @return Monster
	 */
	public function setSenses (string $senses): Monster
	{
		$this->senses = $senses;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSkills (): string
	{
		return $this->skills;
	}

	/**
	 * @param string $skills
	 *
	 * @return Monster
	 */
	public function setSkills (string $skills): Monster
	{
		$this->skills = $skills;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAbilities (): array
	{
		return $this->abilities;
	}

	/**
	 * @param array $abilities
	 *
	 * @return Monster
	 */
	public function setAbilities (array $abilities): Monster
	{
		$this->abilities = $abilities;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSpeed (): string
	{
		return $this->speed;
	}

	/**
	 * @param string $speed
	 *
	 * @return Monster
	 */
	public function setSpeed (string $speed): Monster
	{
		$this->speed = $speed;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHp (): string
	{
		return $this->hp;
	}

	/**
	 * @param string $hp
	 *
	 * @return Monster
	 */
	public function setHp (string $hp): Monster
	{
		$this->hp = $hp;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAc (): string
	{
		return $this->ac;
	}

	/**
	 * @param string $ac
	 *
	 * @return Monster
	 */
	public function setAc (string $ac): Monster
	{
		$this->ac = $ac;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getInitiative (): string
	{
		return $this->initiative;
	}

	/**
	 * @param string $initiative
	 *
	 * @return Monster
	 */
	public function setInitiative (string $initiative): Monster
	{
		$this->initiative = $initiative;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType (): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return Monster
	 */
	public function setType (string $type): Monster
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName (): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return Monster
	 */
	public function setName (string $name): Monster
	{
		$this->name = $name;
		return $this;
	}

}
