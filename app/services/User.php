<?php

namespace Services;

use Engine\Service as EngineService;

class User extends EngineService
{
	public function getLast()
	{
        return 'Small service answer: Hello ;-)' . '<br>UNIQID: <code>' . uniqid() . '</code>';

	}
}
