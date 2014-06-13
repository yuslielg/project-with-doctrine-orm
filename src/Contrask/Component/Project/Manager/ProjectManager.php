<?php

namespace Contrask\Component\Project\Manager;

use Contrask\Component\Project\Manager\ProjectManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 */
class ProjectManager implements ProjectManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $class;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * Additionally it creates a repository using $em, for given class
     *
     * @param EntityManagerInterface $em
     * @param string $class
     */
    public function __construct(
        EntityManagerInterface $em,
        $class = 'Contrask\Component\Project\Entity\Project'
    )
    {
        $this->em = $em;
        $this->class = $em->getClassMetadata($class)->getName();
        $this->repository = $this->em->getRepository($class);
    }

    /**
     * Picks a project using given criteria.
     *
     * @api
     * @param string|array $criteria
     * @return mixed
     */
    public function pick($criteria)
    {
        if (is_string($criteria)) {
           $criteria = array('id' => $criteria);
        }

        return $this->repository->findOneBy($criteria);
    }

    /**
     * Collects the projects by given criteria.
     * It returns all projects if criteria is null.
     *
     * @api
     * @param mixed $criteria
     * @return array
     */
    public function collect($criteria = null)
    {
        if (null === $criteria) {
            return $this->repository->findAll();
        }

        if (is_string($criteria)) {
           $criteria = array('id' => $criteria);
        }

        return $this->repository->findBy($criteria);
    }
}