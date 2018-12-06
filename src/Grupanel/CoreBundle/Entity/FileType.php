<?php

namespace Grupanel\CoreBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="file_types")
 * @ORM\Entity()
 */
class FileType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

	/**
	 * @ORM\OneToMany(targetEntity="Grupanel\CoreBundle\Entity\File", mappedBy="id")
	 */
	private $files;

    /**
     * @var datetime $createdAt
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \Grupanel\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Grupanel\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_id", referencedColumnName="id")
     * })
     */
    private $createdId;

    /**
     * @var \Grupanel\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Grupanel\CoreBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_id", referencedColumnName="id")
     * })
     */
    private $updatedId;

	public function __construct()
	{
		$this->files = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * @param mixed $files
	 */
	public function setFiles($files)
	{
		$this->files = $files;
	}

	/**
	 * @return datetime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param datetime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return datetime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @param datetime $updatedAt
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}

	/**
	 * @return User
	 */
	public function getCreatedId()
	{
		return $this->createdId;
	}

	/**
	 * @param User $createdId
	 */
	public function setCreatedId($createdId)
	{
		$this->createdId = $createdId;
	}

	/**
	 * @return User
	 */
	public function getUpdatedId()
	{
		return $this->updatedId;
	}

	/**
	 * @param User $updatedId
	 */
	public function setUpdatedId($updatedId)
	{
		$this->updatedId = $updatedId;
	}

	public function __toString()
	{
		return $this->getName();
	}
}
