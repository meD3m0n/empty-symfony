<?php

namespace Maverick\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Response\Codes;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TestController extends Controller
{
	public function getTestHelloworldAction()
	{
		var_dump('hello world');die;
	}
}

