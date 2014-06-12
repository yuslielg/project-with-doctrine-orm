<?php

namespace Contrask\Component\Project\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Yusliel Garcia <yuslielg@gmail.com>
 * @ORM\Entity
 */
class Project implements ProjectInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}