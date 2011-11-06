<?php

namespace CMS\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use CMSDoctrineExt\Mapping\Annotation as CMSDoctrineExt;
use CMS\Bundle\BlogBundle\Entity\PostCategory;

/**
 * CMS\Bundle\BlogBundle\Entity\Post
 * @ORM\Table(name="post")
 * @ORM\Entity
 */
class Post {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * 
     * @CMSDoctrineExt\Sluggable
     */
    private $title;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;
    

    /**
     * @ORM\ManyToOne(targetEntity="PostCategory", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @Assert\Type(type="CMS\Bundle\BlogBundle\Entity\PostCategory")
     */
    private $category;

    /**
     * @var string $image
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @CMSDoctrineExt\File(dir="files")
     * 
     * @Assert\Image(maxSize="10M")
     */
    private $image;
    
    /**
     * @var boolean $image_delete
     * 
     */
    public $image_delete = false;
    
    /**
     * @var string $file
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @CMSDoctrineExt\File(dir="files")
     * 
     * @Assert\Image(maxSize="10M")
     */
    private $file;
    
    /**
     * @var boolean $file_delete
     * 
     */
    public $file_delete = false;
    
    
    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * 
     * @CMSDoctrineExt\Slug()
     */
    private $slug;
    

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text $body
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Set category
     *
     * @param CMS\BlogBundle\Entity\PostCategory $category
     */
    public function setCategory(PostCategory $category) {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return CMS\BlogBundle\Entity\PostCategory $category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime $created
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime $updated
     */
    public function getUpdated() {
        return $this->updated;
    }
    
    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return image $image
     */
    public function getImage() {
        return $this->image;
    }


    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
}