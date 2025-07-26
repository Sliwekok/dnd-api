<?php

namespace App\EventSubscriber;

use App\Document\Logger;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LoggerSubscriber implements EventSubscriberInterface
{
	private DocumentManager $dm;
	private array $tempLogData = [];

	public function __construct(DocumentManager $dm)
	{
		$this->dm = $dm;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::REQUEST => ['onKernelRequest', 0],
			KernelEvents::RESPONSE => ['onKernelResponse', 0],
		];
	}

	public function onKernelRequest(RequestEvent $event): void
	{
		$request = $event->getRequest();

		$this->tempLogData = [
			'ip' => $request->getClientIp(),
			'method' => $request->getMethod(),
			'uri' => $request->getRequestUri(),
			'parameters' => $request->getMethod() === 'GET'
				? $request->query->all()
				: $request->request->all(),
		];
	}

	public function onKernelResponse(ResponseEvent $event): void
	{
		if (empty($this->tempLogData)) {
			return;
		}

		$response = $event->getResponse();
		$this->tempLogData['statusCode'] = $response->getStatusCode();

		$log = new Logger(
			$this->tempLogData['ip'],
			$this->tempLogData['method'],
			$this->tempLogData['uri'],
			$this->tempLogData['parameters'],
			$this->tempLogData['statusCode'],
		);

		$this->dm->persist($log);
		$this->dm->flush();
	}
}
