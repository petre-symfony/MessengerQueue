<?php
namespace App\MessageHandler\Command;


use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\Command\LogEmoji;

class LogEmojiHandler implements MessageHandlerInterface {
	private static $emojis = [
		'🍪',
		'🦖',
		'🧀',
		'🤖',
		'💩'
	];

	private $logger;

	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	public function __invoke(LogEmoji $logEmoji) {
		$index = $logEmoji->getEmojiIndex();

		$emoji = self::$emojis[$index] ?? self::$emojis[0];

		$this->logger->info('Important message! '.$emoji);
	}
}