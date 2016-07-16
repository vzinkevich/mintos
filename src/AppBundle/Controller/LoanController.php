<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Investment;
use AppBundle\Entity\Loan;
use AppBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoanController extends Controller
{
    /**
     * @Route("/loans", name="Loans")
     */
    public function index()
    {
        $user = $this->getUser();
        // validate
        if (!($user instanceof User) || !$user->getId()) {
            return $this->redirect('/mintos/web/app_dev.php/login');
        }

        /** @var  $queryBuilder QueryBuilder*/
        /** @var $user User */
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $queryBuilder = $this->getDoctrine()->getRepository('AppBundle:Loan')->createQueryBuilder('loan');
        $loans = $queryBuilder
            ->where('loan.availableForInvestments > 0')
            ->orderBy('loan.availableForInvestments', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render( 'investments/loan.html.twig', array(
            'loans' => $serializer->normalize($loans),
            'moneyAvailable' => $user->getMoneyAvailable()
        ));
    }

    /**
     * @Route("/invest", name="invest")
     */
    public function invest(Request $request)
    {
        /** @var $loan Loan*/

        // getting request values
        $loanId = $request->get('loan_id') ? (int) $request->get('loan_id') : null;
        $amount = $request->get('invest_amount') ? (float) $request->get('invest_amount') : null;

        try {
            $this->validate($loanId, $amount);
            $availableForInvestments = $this->updateLoan($loanId, $amount);
            $moneyAvailable = $this->updateUser($amount);
            $this->saveInvestment($loanId, $amount);
        } catch (\ErrorException $err) {
            return new JsonResponse(array(
                'status' => false,
                'message' => $err->getMessage())
            );
        }

        return new JsonResponse(array(
            'status' => true,
            'availableForInvestments' => $availableForInvestments,
            'moneyAvailable' => $moneyAvailable
        ));
    }

    private function updateLoan($loanKey, $investmentAmount)
    {
        /** @var $loan Loan*/
        // getting changed loan
        $entityManager = $this->getDoctrine()->getManager();
        $loan = $entityManager->getRepository('AppBundle:Loan')->find($loanKey);

        // generate new value
        $availableForInvestments = $loan->getAvailableForInvestments() - $investmentAmount;

        // save new value
        $loan->setAvailableForInvestments($availableForInvestments);
        $entityManager->flush();

        return $availableForInvestments;
    }

    private function updateUser($investmentAmount)
    {
        /** @var $userEntity User */
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $userEntity = $entityManager->getRepository('AppBundle:User')->find($user->getId());

        // generate new value
        $moneyAvailable = $userEntity->getMoneyAvailable() - $investmentAmount;

        // save new value
        $userEntity->setMoneyAvailable($moneyAvailable);
        $entityManager->flush();

        return $moneyAvailable;
    }

    private function saveInvestment($loanKey, $investmentAmount)
    {
        /** @var $investment Investment */
        /** @var $user User */
        $user = $this->getUser();

        // getting investment model
        $entityManager = $this->getDoctrine()->getManager();
        $investment = new Investment();

        // setting values
        $investment->setLoan((int) $loanKey);
        $investment->setInvestor((int) $user->getId());
        $investment->setAmount((float) $investmentAmount);

        // save
        $entityManager->persist($investment);
        $entityManager->flush();
    }

    private function validate($loanKey, $investmentAmount)
    {
        /** @var $loan Loan*/
        /** @var $user User */

        // check user
        $user = $this->getUser();
        if (!($user instanceof User)) {
            throw new \ErrorException('You are not authenticated.');
        }
        if ($investmentAmount > $user->getMoneyAvailable()) {
            throw new \ErrorException('Not enough money.');
        }

        // check loan
        if (!is_int($loanKey) || !$loanKey) {
            throw new \ErrorException('Loan you want to invest can\'t be detected.');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $loan = $entityManager->getRepository('AppBundle:Loan')->find($loanKey);

        if (!($loan instanceof Loan)) {
            throw new \ErrorException('Loan you want to invest can\'t be detected.');
        }
        if (!preg_match('/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d{1,2})?$/', $investmentAmount) || !$investmentAmount) {
            throw new \ErrorException('Please enter valid float number.');
        }
        if ($loan->getAvailableForInvestments() < $investmentAmount) {
            throw new \ErrorException('Can\'t invest more than available.');
        }
        if (!is_finite($investmentAmount) || !$investmentAmount) {
            throw new \ErrorException('Invalid investment amount.');
        }
    }
}
