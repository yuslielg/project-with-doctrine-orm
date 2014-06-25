<?php

namespace Contrask\Component\Project\Manager;

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
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * Additionally it creates a repository using $em, for given class
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('Contrask\Component\Project\Model\Project');
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
           $criteria = array('strid' => $criteria);
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
           $criteria = array('strid' => $criteria);
        }

        return $this->repository->findBy($criteria);
    }
}