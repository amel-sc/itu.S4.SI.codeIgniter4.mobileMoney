<?php

namespace App\Controllers;
use App\Models\MontantFraisModel;

class FraisController extends BaseController {


    public function list() {
        $montantFraisModel = new MontantFraisModel();
        $frais = $montantFraisModel->findAll();

        return view('frais/list', [
            'title' => 'Frais',
            'frais' => $frais
        ]);
    }
}