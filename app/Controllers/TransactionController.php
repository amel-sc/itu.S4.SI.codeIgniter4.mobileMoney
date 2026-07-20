<?php
namespace App\Controllers;
use App\Models\OperationTypeModel;

class TransactionController extends BaseController{    
	// function to get form for transaction
    public function form() {        
        $operationTypeModel = new OperationTypeModel();

        $type_operations = $operationTypeModel->findAll();

        return view('transaction/form', [
            'title' => 'Transaction',
            'type_operations' => $type_operations
        ]);    
    }
}