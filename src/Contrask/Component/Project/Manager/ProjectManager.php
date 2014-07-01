<?php

namespace Contrask\Component\Project\Manager;

use Doctrine\ORM\EntityManager;
use Contrask\Component\Project\Model\Project;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 */
class ProjectManager implements ProjectManagerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
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
     * @param EntityManager $em
     */
    public function __construct(
        EntityManager $em
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

        return $this->repository->findBy($criteria);
    }

    /**
     * Adds given project
     *
     * @param Project $project
     * @return void
     */
    public function add(Project $project)
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    /**
     * Updates given project
     *
     * @param Project $project
     * @return void
     */
    public function update(Project $project)
    {
        $this->em->flush($project);
    }

    /**
     * Removes given project
     *
     * @param Project $project
     * @return void
     */
    public function remove(Project $project)
    {
        $this->em->remove($project);
        $this->em->flush();
    }
}