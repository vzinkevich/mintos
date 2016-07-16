<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table("loan")
 * @ORM\Entity
 */
class Loan
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
	 *
	 * @ORM\Column(name="amount", type="float", options={"unsigned":true, "default":0})
	 */
	protected $amount;
	/**
	 * @var float
	 *
	 * @ORM\Column(name="available_for_investments", type="float", options={"unsigned":true, "default":0})
	 */
	protected $availableForInvestments;


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
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param float $amount
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	/**
	 * @return float
	 */
	public function getAvailableForInvestments()
	{
		return $this->availableForInvestments;
	}

	/**
	 * @param float $availableForInvestments
	 */
	public function setAvailableForInvestments($availableForInvestments)
	{
		$this->availableForInvestments = $availableForInvestments;
	}
}