<?php

namespace SoftUniBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="SoftUniBlogBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="authorname", type="string", length=255)
     */
    private $authorname;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAddet", type="datetime")
     */
    private $dateAddet;

    /** @var  int
     *
     * @ORM\Column(name="articleId", type="integer")
     */
    private $articleId;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="SoftUniBlogBundle\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(name="articleId", referencedColumnName="id")
     */
    private $articletocomment;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set authorname
     *
     * @param string $authorname
     *
     * @return Comment
     */
    public function setAuthorname($authorname)
    {
        $this->authorname = $authorname;

        return $this;
    }

    /**
     * Get authorname
     *
     * @return string
     */
    public function getAuthorname()
    {
        return $this->authorname;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateAddet
     *
     * @param \DateTime $dateAddet
     *
     * @return Comment
     */
    public function setDateAddet($dateAddet)
    {
        $this->dateAddet = $dateAddet;

        return $this;
    }

    /**
     * Get dateAddet
     *
     * @return \DateTime
     */
    public function getDateAddet()
    {
        return $this->dateAddet;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     */
    public function setArticleId(int $articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @return \SoftUniBlogBundle\Entity\Article
     */
    public function getArticletocomment()
    {
        return $this->articletocomment;
    }

    /**
     * @param \SoftUniBlogBundle\Entity\Article $articletocomment
     *
     *@return Comment
     */
    public function setArticletocomment(Article $articletocomment = null)
    {
        $this->articletocomment = $articletocomment;
    }

    public function __construct()
    {
        $this->dateAddet = new \DateTime('now');
    }

}

