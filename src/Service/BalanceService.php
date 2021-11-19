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
        ExpenseRepository      $expenseRepository,
        TricountRepository     $tricountRepository)
    {
        $this->entityManager = $entityManager;
        $this->tricountRepository = $tricountRepository;
        $this->expenseRepository = $expenseRepository;
    }

    public function CalculateBalance(int $tricountId): array
    {
        // Récupère un objet tricount avec son id
        $expenses = $this->expenseRepository->findBy(['Tricount' => $this->tricountRepository->find($tricountId)]);
        // Récupère  les dépenses liés à ce tricount
        $participants = [];
        $payers = [];
        $beforeFinalBalance = [];
        $finalBalance = [];

        foreach ($expenses as $expense) {
            $amount = $expense->getAmount();
            $payer = $expense->getPayer();
            $p = [
                'id' => $payer->getId(),
                'name' => $payer->getName(),
                'balance' => $amount
            ];
            array_push($payers, $p);
            $participant = $expense->getParticipant()->getValues();
            $pppp = [];
            foreach ($participant as $pp) {
                $ppp = [
                    'id' => $pp->getId(),
                    'name' => $pp->getName(),
                    'balance' => -$amount / count($participant)
                ];
                array_push($pppp, $ppp);
            }
            array_push($participants, $pppp);
        }

        dump($payers, $participants);

        $expenseLength = count($expenses);

        for ($i = 0; $i < $expenseLength; $i++) {
            $intermediateBalance = [];
            $payerId = $payers[$i]["id"];


            foreach ($participants[$i] as $p) {
                $uuu = [];
                if ($payerId == $p["id"]) {
                    $uuu = [
                        "id" => $payerId,
                        "name" => $payers[$i]["name"],
                        "balance" => $payers[$i]["balance"] + $p["balance"]
                    ];
                } else {
                    $uuu = [
                        "id" => $p["id"],
                        "name" => $p["name"],
                        "balance" => $p["balance"]
                    ];
                }
                array_push($intermediateBalance, $uuu);
            }
            $payerExists = false;
            foreach ($intermediateBalance as $elem) {
                if ($elem["id"] == $payerId) {
                    $payerExists = true;
                }
            }
            if (!$payerExists) {
                array_push($intermediateBalance, $payers[$i]);
            }

            array_push($beforeFinalBalance, $intermediateBalance);
        }

        foreach ($beforeFinalBalance as $item) {
            foreach ($item as $i) {
                if (array_key_exists($i["id"], $finalBalance)) {
                    $finalBalance[$i["id"]]["balance"] += $i["balance"];
                } else {
                    $finalBalance[$i["id"]] = $i;
                }
            }
        }
        dump($finalBalance);

        return $finalBalance;
        //Il faudra ensuite récupèrer le montant total de toutes les dépenses puis faire les calculs
        // afin de faire une balance par user

    }
}