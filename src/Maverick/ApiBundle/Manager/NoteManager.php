<?php

namespace Maverick\ApiBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Practo\ApiBundle\Entity\Notes;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * Note Manager
 */
class NoteManager
{
    protected $doctrine;
    protected $validator;
    protected $securityContext;

    /**
     * Constructor
     *
     * @param Doctrine                 $doctrine           - Doctrine
     * @param ValidatorInterface       $validator          - Validator
     * @param SecurityContextInterface $securityContext    - Security Context
     */
    public function __construct(Doctrine $doctrine, ValidatorInterface $validator,
        SecurityContextInterface $securityContext)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
        $this->securityContext = $securityContext;
    }

    /**
     * UpdateFields
     *
     * @param Notes  $notes         - Notes
     * @param Array  $requestParams - Request Params
     * @param UserId $userId        - User Id
     *
     * @return null
     */
    public function updateFields($notes, $requestParams)
    {
        $notes->setAttributes($requestParams);
        $errors = $this->validator->validate($notes);

        if (0 < count($errors)) {
            throw new ValidationError($errors);
        }

        return;
    }

    /**
     * Add
     *
     * @param Array $requestParams
     *
     * @return Notes
     */
    public function add($requestParams)
    {
        $notes = new Notes();
        $notes->setSoftDeleted(false);
        $notes->setUserId(1);
        $this->updateFields($notes, $requestParams);

        $em = $this->doctrine->getManager();
        $em->persist($notes);
        $em->flush();

        return $notes;
    }
}

