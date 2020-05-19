<?php


namespace App\Event;


class UserRegistered
{
	public $userId;
	public function __construct(int $userId)
	{
		$this->userId = $userId;
	}

}