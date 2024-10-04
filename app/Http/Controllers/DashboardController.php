<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use HelpersAdm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    
    public function index(){
        return view('dashboard.index',[
            'incomeWeek' => $this->helperAdm->getIncomeWeek(),
            'expenseWeek' => $this->helperAdm->getExpenseWeek(),
            'cashBalance' => $this->helperAdm->getCashBalance(),
        ]);
    }
}
