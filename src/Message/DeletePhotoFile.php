<?php


namespace App\Message;


class DeletePhotoFile {
	/**
	 * @var string
	 */
	private $filename;

	public function __construct(string $filename) {

		$this->filename = $filename;
	}

	/**
	 * @return string
	 */
	public function getFilename(): string {
		return $this->filename;
	}
}