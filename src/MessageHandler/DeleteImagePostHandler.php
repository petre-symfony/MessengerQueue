<?php


namespace App\MessageHandler;


use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;

class DeleteImagePostHandler {
	/**
	 * @var PhotoFileManager
	 */
	private $photoManager;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		PhotoFileManager $photoManager,
		EntityManagerInterface $entityManager
	) {
		$this->photoManager = $photoManager;
		$this->entityManager = $entityManager;
	}

	public function __invoke(DeleteImagePost $deleteImagePost) {
		$imagePost = $deleteImagePost->getImagePost();
		$this->photoManager->deleteImage($imagePost->getFilename());

		$this->entityManager->remove($imagePost);
		$this->entityManager->flush();
	}
}