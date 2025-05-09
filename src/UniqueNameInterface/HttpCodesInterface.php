<?php

	declare(strict_types=1);

	namespace App\UniqueNameInterface;

	class HttpCodesInterface {
		public const SUCCESS = 200;
		public const NO_CONTENT = 204;
		public const INTERNAL_ERROR = 500;
		public const BAD_REQUEST = 400;
		public const UNAUTHORIZED = 401;
		public const NOT_FOUND = 404;
	}
