<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;
    /**
     * @var bool
     *
     * @ORM\Column(name="priority", type="boolean")
     */
    private $priority;
    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean")
     */
    private $done;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="task", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Task
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Set priority.
     *
     * @param bool $priority
     *
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    /**
     * Get priority.
     *
     * @return bool
     */
    public function getPriority()
    {
        return $this->priority;
    }
    /**
     * Set done.
     *
     * @param bool $done
     *
     * @return Task
     */
    public function setDone($done)
    {
        $this->done = $done;
        return $this;
    }
    /**
     * Get done.
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set user.
     *
     * @param \App\Entity\User $user
     *
     * @return Task
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
