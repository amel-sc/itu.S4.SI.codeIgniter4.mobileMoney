<?php

namespace App\Controllers;

use App\Models\PrefixConfigModel;
use App\Models\MontantFraisModel;
use App\Models\OperationTypeModel;

class HomeController extends BaseController {
    // home page
    public function index() {
        $prefixModel = new PrefixConfigModel();
        $fraisModel = new MontantFraisModel();
        $operationTypeModel = new OperationTypeModel();
        
        $stats = [
            'prefixes' => $prefixModel->countAll(),
            'frais' => $fraisModel->countAll(),
            'operationTypes' => $operationTypeModel->countAll(),
            'users' => 1
        ];

        return view('home/index', [
            'title' => 'Tableau de bord',
            'stats' => $stats
        ]);
    }
}
