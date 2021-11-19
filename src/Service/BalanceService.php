<?php

namespace App\Service;

use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use App\Repository\TricountRepository;
use Doctrine\ORM\EntityManagerInterface;

class BalanceService
{
    private EntityManagerInterface $entityManager;
    private TricountRepository $tricountRepository;
    private ExpenseRepository $expenseRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ExpenseRepository $expenseRepository,
        TricountRepository $tricountRepository)
    {
        $this->entityManager = $entityManager;
        $this->tricountRepository = $tricountRepository;
        $this->expenseRepository = $expenseRepository;
    }

    public function CalculateBalance(int $tricountId): int
    {
        // Récupère un objet tricount avec son id
        $expenses = $this->expenseRepository->findBy(['Tricount' => $this->tricountRepository->find($tricountId)]);
        // Récupère  les dépenses liés à ce tricount
        $participants = [];
        $payers = [];

        foreach ($expenses as $expense)
        {
            array_push($participants, $expense->getParticipant()->getValues());
            $amount =  $expense->getAmount();
            $payer =  $expense->getPayer();
            $p = [
                'id' => $payer->getId(),
                'name' => $payer->getName(),
                'balance' => $amount
            ];
            array_push($payers, $p);
        }


        dump($payers, $participants );
        die;



        return 1;
        //Il faudra ensuite récupèrer le montant total de toutes les dépenses puis faire les calculs
        // afin de faire une balance par user

    }
}