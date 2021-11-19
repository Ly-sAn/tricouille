<?php

namespace App\Controller;

use App\Service\BalanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends AbstractController
{
    private BalanceService $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    #[Route('/balance/{id}', name: 'balance')]
    public function index(int $id): Response
    {
        $balance = $this->balanceService->CalculateBalance($id);

        return $this->render('balance/index.html.twig', [
            'controller_name' => 'BalanceController',
            'balance' => $balance,
        ]);

    }
}
