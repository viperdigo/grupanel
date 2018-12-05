<?php

namespace Grupanel\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="Grupanel\CoreBundle\Repository\FileRepository")
 */
class File
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
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private $name;

	/**
	 * @ORM\ManyToOne(targetEntity="Grupanel\CoreBundle\Entity\FileType")
	 * @ORM\JoinColumn(name="file_type_id", referencedColumnName="id")
	 * @Assert\NotBlank()
	 */
	private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=5)
     */
    private $extension;

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
	public function getFileType()
	{
		return $this->fileType;
	}

	/**
	 * @param mixed $fileType
	 */
	public function setFileType($fileType)
	{
		$this->fileType = $fileType;
	}

	/**
	 * @return string
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	 * @param string $extension
	 */
	public function setExtension($extension)
	{
		$this->extension = $extension;
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
}
