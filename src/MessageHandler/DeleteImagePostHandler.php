<?php


namespace App\MessageHandler;


use App\Message\DeleteImagePost;
use App\Message\DeletePhotoFile;
use App\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteImagePostHandler implements MessageHandlerInterface {
	/**
	 * @var MessageBusInterface
	 */
	private $messageBus;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		MessageBusInterface $messageBus,
		EntityManagerInterface $entityManager
	) {
		$this->messageBus = $messageBus;
		$this->entityManager = $entityManager;
	}

	public function __invoke(DeleteImagePost $deleteImagePost) {
		$imagePost = $deleteImagePost->getImagePost();
		$filename = $imagePost->getFilename();

		$this->entityManager->remove($imagePost);
		$this->entityManager->flush();

		$this->messageBus->dispatch(new DeletePhotoFile($filename));
	}
}