<?php

namespace Maverick\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Response\Codes;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class NotesController extends Controller
{
	public function postNotesAction()
	{
		$postData = $this->getRequest()->request->all();
		var_dump($postData);die;

        $notesManager = $this->get('maverick_api.notes_manager');
        try {
	        $notes = $notesManager->add($postData);
        } catch (ValidationError $e) {
            return View::create($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        } catch (BadAttributeException $e) {
            return View::create($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        } catch (AccessDeniedException $e) {
            return View::create($e->getMessage(), Codes::HTTP_FORBIDDEN);
        }
    }

    public function getNotesAction()
    {
    	var_dump("here");die;
    }
}

