<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

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

		/* @var  InMemoryTransport $transport */
		$transport = self::$container->get('messenger.transport.async_priority_high');
		$this->assertCount(1, $transport->get());
	}
}
