<?php

namespace Contrask\Test\Component\Project\Manager;

use Contrask\Component\Project\Entity\Project;
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
                'Contrask\Component\Project\Entity\Project'
            ),
            array(
                
            ),
            array(
                'Contrask\Component\Project\Entity\ProjectInterface' => 'Contrask\Component\Project\Entity\Project'
            )
        );
    }

    /**
     * @covers \Contrask\Component\Project\Manager\ProjectManager::__construct
     */
    public function testConstructor()
    {
        $class = 'Contrask\Component\Project\Entity\Project';
        $metadata = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $metadata->expects($this->once())->method('getName')->will($this->returnValue($class));
        $em = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $em->expects($this->once())->method('getClassMetadata')->with($class)->will($this->returnValue($metadata));
        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $manager = new ProjectManager($em, $class);

        $this->assertAttributeEquals($em, 'em', $manager);
        $this->assertAttributeEquals($class, 'class', $manager);
        $this->assertAttributeEquals($em->getRepository('Contrask\Component\Project\Entity\Project'), 'repository', $manager);
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
}