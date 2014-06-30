<?php

namespace Contrask\Test\Component\Project\Manager;

use Contrask\Component\Project\Model\Project;
use Contrask\Component\Project\Manager\ProjectManager;
use Contrask\Test\Component\Project\EntityManagerBuilder;
use Doctrine\ORM\EntityManager;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 */
class ProjectManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    protected $em;
    
    public function setUp()
    {
        $builder = new EntityManagerBuilder();
        $this->em = $builder->createEntityManager(
            array(
                realpath(sprintf("%s/../../../../../../src/Contrask/Component/Project/Resources/config/doctrine", __DIR__)),
            ),
            array(
                'Contrask\Component\Project\Model\Project',
            )
        );
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::__construct
     */
    public function testConstructor()
    {
        $manager = new ProjectManager($this->em);

        $this->assertAttributeEquals($this->em, 'em', $manager);
        $this->assertAttributeEquals($this->em->getRepository('Contrask\Component\Project\Model\Project'), 'repository', $manager);
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::pick
     */
    public function testPickWithStringCriteria()
    {
        /*Fixtures*/
        $project = new Project();
        $this->em->persist($project);

        $this->em->flush();

        /*Tests*/
        $projectManager = new ProjectManager($this->em);
        $this->assertAttributeEquals(1, 'id', $projectManager->pick('1'));
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::pick
     */
    public function testPickWithArrayCriteria()
    {
        /*Fixtures*/
        $project = new Project();
        $this->em->persist($project);

        $this->em->flush();

        /*Tests*/
        $projectManager = new ProjectManager($this->em);
        $this->assertAttributeEquals(1, 'id', $projectManager->pick(array('id' => '1')));
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::collect
     */
    public function testCollectWithNullCriteria()
    {
        /*Fixtures*/
        $project = new Project();
        $this->em->persist($project);

        $project1 = new Project();
        $this->em->persist($project1);

        $this->em->flush();

        /*Tests*/
        $projectManager = new ProjectManager($this->em);
        $this->assertEquals(2, count($projectManager->collect()));
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::collect
     */
    public function testCollectWithArrayCriteria()
    {
        /*Fixtures*/
        $project = new Project();
        $this->em->persist($project);

        $project1 = new Project();
        $this->em->persist($project1);

        $this->em->flush();

        /*Tests*/
        $projectManager = new ProjectManager($this->em);
        $this->assertEquals(1, count($projectManager->collect(array('id' => '1'))));
        $this->assertEquals(0, count($projectManager->collect(array('id' => '3'))));
    }
}