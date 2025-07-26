<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'Logger')]
class Logger extends BaseModel
{
	#[MongoDB\Id]
	private string $id;

	#[MongoDB\Field(type: 'string')]
	private string $ip;

	#[MongoDB\Field(type: 'string')]
	private string $method;

	#[MongoDB\Field(type: 'string')]
	private string $uri;

	#[MongoDB\Field(type: 'hash')]
	private array $parameters = [];

	#[MongoDB\Field(type: 'int')]
	private int $statusCode;

	#[MongoDB\Field(type: 'date')]
	private \DateTime $timestamp;

	public function __construct(
		string $ip,
		string $method,
		string $uri,
		array $parameters,
		int $statusCode
	) {
		$this->ip = $ip;
		$this->method = $method;
		$this->uri = $uri;
		$this->parameters = $parameters;
		$this->statusCode = $statusCode;
		$this->timestamp = new \DateTime();
	}
}
