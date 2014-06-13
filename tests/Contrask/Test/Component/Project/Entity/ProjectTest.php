<?php

namespace Contrask\Test\Component\Project\Entity;

use Contrask\Component\Project\Entity\Project;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 */
class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Contrask\Component\Project\Entity\Project::getId
     */
    public function testId()
    {
        $project = new Project();
        $this->assertNull($project->getId());
    }
}