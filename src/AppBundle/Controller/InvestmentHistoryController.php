<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class InvestmentHistoryController extends Controller
{
	/**
	 * @Route("/investment_history", name="Investment history")
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function index()
	{
		/** @var  $queryBuilder QueryBuilder*/

		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
		$serializer = new Serializer($normalizers, $encoders);

		$user = $this->getUser();
		// validate
		if (!($user instanceof User) || !$user->getId()) {
			return $this->redirect('/mintos/web/app_dev.php/login');
		}

		$queryBuilder = $this->getDoctrine()->getRepository('AppBundle:Investment')->createQueryBuilder('inv');
		$investments = $queryBuilder
			->addSelect('loan.amount AS loanAmount')
			->addSelect('loan.availableForInvestments')
			->addSelect('SUM(inv.amount) AS invested')
			->addSelect('(SUM(inv.amount) / loan.amount) * 100 AS conversion')
			->leftJoin("AppBundle:Loan", "loan", "WITH", "inv.loan=loan.id")
			->where('inv.investor = ' . $user->getId())
			->orderBy('inv.amount', 'DESC')
			->groupBy('loan.id')
			->getQuery()
			->getResult();

		return $this->render( 'investments/investment.html.twig', array(
			'investments' => $serializer->normalize($investments)
		));
	}
}
