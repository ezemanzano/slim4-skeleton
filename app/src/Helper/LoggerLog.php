<?php

declare (strict_types = 1);

namespace App\Helper;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;
use Glopgar\Monolog\Processor\TimerProcessor;

class LoggerLog{

	const PROFILE = false;

	private static $instances = [];

	public static function get($file = 'accions'){

		if(!isset(self::$instances[$file]) OR self::$instances[$file] == null){
		
			try {
				
				$log = new Logger($file);

				$handler = new RotatingFileHandler(
					__DIR__ . '/../../logs/'.$file.'.log',
					15,
					Logger::DEBUG,
					true,
					644
				);

				$formatter = new LineFormatter(
					"[%datetime%] %file%.%level_name%: %message% %context% %extra%".PHP_EOL.PHP_EOL,
					"Y-m-d H:i:s",
					true
				);
				
				$handler->setFormatter($formatter);

				$log->pushHandler($handler);

				if(self::PROFILE){
					$log->pushProcessor(new TimerProcessor());
				}

			} catch (Exception $e) {
			    print "¡Error!: " . $e->getMessage();
			    die();
			}

			LoggerLog::$instances[$file] = $log;
		}

		return LoggerLog::$instances[$file];
	}

}