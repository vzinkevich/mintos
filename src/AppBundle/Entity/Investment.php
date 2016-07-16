<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table("investment")
 * @ORM\Table(name="investment", indexes={
 *     @ORM\Index(name="investor", columns={"investor_key"}),
 *     @ORM\Index(name="loan", columns={"loan_key"})
 * })
 * @ORM\Entity
 */
class Investment
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
	 * @var integer
	 *
	 * @ORM\Column(name="investor_key", type="integer", nullable=false)
	 */
	protected $investor;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="loan_key", type="integer", nullable=false)
	 */
	protected $loan;
	/**
	 * @var float
	 *
	 * @ORM\Column(name="amount", type="float", options={"unsigned":true, "default":0})
	 */
	protected $amount;

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
	 * @return int
	 */
	public function getInvestor()
	{
		return $this->investor;
	}

	/**
	 * @param int $investor
	 */
	public function setInvestor($investor)
	{
		$this->investor = $investor;
	}

	/**
	 * @return int
	 */
	public function getLoan()
	{
		return $this->loan;
	}

	/**
	 * @param int $loan
	 */
	public function setLoan($loan)
	{
		$this->loan = $loan;
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
}