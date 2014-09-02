<?php

namespace Contrask\Component\Project\Features;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Contrask\Component\Project\Model\Project;
use Contrask\Component\Project\Manager\ProjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Yosmanyga\DoctrineExtension\Context\DoctrineAwareContext;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 */
class ProjectContext implements SnippetAcceptingContext, DoctrineAwareContext
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \Contrask\Component\Project\Model\Project
     */
    private $project;

    /**
     * @var \Contrask\Component\Project\Model\Project[]
     */
    private $projects;

    /**
     * {@inheritdoc}
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @BeforeScenario
     */
    public function resetSchema()
    {
        $entities = array(
            "Contrask\\Component\\Project\\Model\\Project",
        );

        foreach ($entities as $key => $class) {
            $entities[$key] = $this->em->getClassMetadata($class);
        }

        $this->em->clear();

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropSchema($entities);
        $schemaTool->createSchema($entities);
    }

    /**
     * @Given /^there are the following projects:$/
     */
    public function thereAreProjectsWithTheFollowingData(TableNode $table)
    {
        foreach ($table->getHash() as $data) {
            $project = new Project();
            $project->setStrid($data['strid']);
            $project->setName($data['name']);
            $this->em->persist($project);
        }

        $this->em->flush();
    }

    /**
     * @When /^I pick the project "([^"]*)"$/
     */
    public function iPickTheProject($strid)
    {
        $manager = new ProjectManager($this->em);

        $this->project = $manager->pick($strid);
    }

    /**
     * @When /^I collect projects$/
     */
    public function iCollectProjects()
    {
        $manager = new ProjectManager($this->em);

        $this->projects = $manager->collect();
    }

    /**
     * @When /^I add the following project$/
     */
    public function iAddTheFollowingProject(TableNode $table)
    {
        $data = $table->getRowsHash();

        $project = new Project();
        $project->setStrid($data['strid']);
        $project->setName($data['name']);

        $manager = new ProjectManager($this->em);
        $manager->add($project);
    }
    
    /**
     * @When I add the following project:
     */
    public function iAddTheFollowingProject2(TableNode $table)
    {
        $data = $table->getRowsHash();

        $project = new Project();
        $project->setStrid($data['strid']);
        $project->setName($data['name']);

        $manager = new ProjectManager($this->em);
        $manager->add($project);
    }


    /**
     * @When /^I remove the picked project$/
     */
    public function iRemoveThePickedProject()
    {
        if (!$this->project) {
            throw new \Exception("No project was picked");
        }

        $manager = new ProjectManager($this->em);
        $manager->remove($this->project);
    }

    /**
     * @Then /^I should get the following project:$/
     */
    public function iShouldGetTheFollowingProject(TableNode $table)
    {
        if (!$this->project) {
            throw new \Exception("No project was picked");
        }

        $project = array(
            'strid' => $this->project->getStrid()
        );

        if ($project != $table->getRowsHash()) {
            throw new \Exception("Projects don't match");
        }
    }

    /**
     * @Then /^I should get the following projects:$/
     */
    public function iShouldGetTheFollowingProjects(TableNode $table)
    {
        if (!$this->projects) {
            throw new \Exception("No projects were collected");
        }

        $projects = array();
        foreach ($this->projects as $project) {
            $projects[] = array(
                'strid' => $project->getStrid()
            );
        }

        if ($projects != $table->getHash()) {
            throw new \Exception("Projects don't match");
        }
    }
}
