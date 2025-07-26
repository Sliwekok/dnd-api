<?php
	namespace App\Service;

	use Psr\Log\LoggerInterface;
	use Symfony\Component\HttpFoundation\RequestStack;

	class Logger
	{
		private LoggerInterface $logger;
		private RequestStack $requestStack;

		public function __construct(LoggerInterface $logger, RequestStack $requestStack)
		{
			$this->logger = $logger;
			$this->requestStack = $requestStack;
		}

		public function log(string $action, array $dbData = []): void
		{
			$request = $this->requestStack->getCurrentRequest();

			if (!$request) {
				return;
			}

			$logData = [
				'ip' => $request->getClientIp(),
				'method' => $request->getMethod(),
				'uri' => $request->getRequestUri(),
				'parameters' => $request->request->all() ?: $request->query->all(),
				'action' => $action,
				'dbData' => $dbData,
			];

			$this->logger->info('Logger', $logData);
		}
	}
