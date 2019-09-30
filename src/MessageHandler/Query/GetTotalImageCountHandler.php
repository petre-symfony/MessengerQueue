<?php


namespace App\MessageHandler\Query;


use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Message\Query\GetTotalImageCount;

class GetTotalImageCountHandler implements MessageHandlerInterface {
	public function __invoke(GetTotalImageCount $getTotalImageCount){
		return 50;
	}

}