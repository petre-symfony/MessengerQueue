<?php


namespace App\MessageHandler\Command;


use App\Message\Event\ImagePostDeletedEvent;
use App\Message\Command\DeleteImagePost;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageSubscriberInterface {
	/**
	 * @var MessageBusInterface
	 */
	private $eventBus;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		MessageBusInterface $eventBus,
		EntityManagerInterface $entityManager
	) {
		$this->eventBus = $eventBus;
		$this->entityManager = $entityManager;
	}

	public function __invoke(DeleteImagePost $deleteImagePost) {
		$imagePost = $deleteImagePost->getImagePost();
		$filename = $imagePost->getFilename();

		$this->entityManager->remove($imagePost);
		$this->entityManager->flush();

		$this->eventBus->dispatch(new ImagePostDeletedEvent($filename));
	}

	public static function getHandledMessages(): iterable{
		yield DeleteImagePost::class => [
			'method' => '__invoke',
			'priority' => 10,
			//'from_transport' => 'async'
		];
	}

}