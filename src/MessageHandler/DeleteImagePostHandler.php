<?php


namespace App\MessageHandler;


use App\Message\Event\ImagePostDeletedEvent;
use App\Message\DeleteImagePost;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface {
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
}