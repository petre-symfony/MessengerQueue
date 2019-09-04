<?php


namespace App\Message;


use App\Entity\ImagePost;

class AddPonkaToImage {
	/**
	 * @var ImagePost
	 */
	private $imagePost;

	public function __construct(int $imagePostId){

		$this->imagePost = $imagePostId;
	}

	public function getImagePostId():int{
		return $this->imagePostId;
	}
}