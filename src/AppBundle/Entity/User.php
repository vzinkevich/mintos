<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table("user")
 * @ORM\Entity
 */
class User extends BaseUser
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @var float
	 * @ORM\Column(name="moneyAvailable", type="float", nullable=true, options={"unsigned":true, "default":0})
	 */
	protected $moneyAvailable;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return float
	 */
	public function getMoneyAvailable()
	{
		return $this->moneyAvailable ?: 0;
	}

	/**
	 * @param float $moneyAvailable
	 */
	public function setMoneyAvailable($moneyAvailable)
	{
		$this->moneyAvailable = $moneyAvailable;
	}
}