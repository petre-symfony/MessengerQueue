<?php


namespace App\MessageHandler;


use App\Message\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageHandler implements MessageHandlerInterface, LoggerAwareInterface {
	use LoggerAwareTrait;
	/**
	 * @var PhotoPonkaficator
	 */
	private $photoPonkaficator;
	/**
	 * @var PhotoFileManager
	 */
	private $photoManager;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var ImagePostRepository
	 */
	private $imagePostRepository;

	public function __construct(
		PhotoPonkaficator $photoPonkaficator,
		PhotoFileManager $photoManager,
		EntityManagerInterface $entityManager,
		ImagePostRepository $imagePostRepository
	){
		$this->photoPonkaficator = $photoPonkaficator;
		$this->photoManager = $photoManager;
		$this->entityManager = $entityManager;
		$this->imagePostRepository = $imagePostRepository;
	}

	public function __invoke(AddPonkaToImage $addPonkaToImage) {
		$imagePostId = $addPonkaToImage->getImagePostId();
		$imagePost = $this->imagePostRepository->find($imagePostId);

		if(!$imagePost){
			// could throw an exception... it would be retried
			// or return and this message will be discarded

			if($this->logger){
				$this->logger->alert(sprintf('Image post %s was missing!', $imagePostId));
			}

			return;
		}

		$updatedContents = $this->photoPonkaficator->ponkafy(
			$this->photoManager->read($imagePost->getFilename())
		);
		$this->photoManager->update($imagePost->getFilename(), $updatedContents);
		$imagePost->markAsPonkaAdded();
		$this->entityManager->flush();
	}
}