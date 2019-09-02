<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImagePostControllerTest extends WebTestCase {
	public function testCreate(){
		$client = static::createClient();

		$uploadedFile = new UploadedFile(
			__DIR__.'/../Fixtures/diaconescu.jpg',
			'diaconescu.jpg'
		);

		$client->request('POST', '/api/images', [], [
			'file' => $uploadedFile
		]);


		$this->assertResponseIsSuccessful();


		$transport = self::$container->get('messenger.transport.async_priority_high');
		dd($transport);
	}
}
