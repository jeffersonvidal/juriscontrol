<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use HelpersAdm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    
    public function index(){

        // Consulta para obter os dados de receitas e despesas por mês
        $invoices = Invoice::select(
            DB::raw("MONTHNAME(due_at) as month_name"),
            DB::raw("type"),
            DB::raw("SUM(amount) as total")
        )
        ->whereYear("created_at", date("Y"))
        ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"), "type")
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->get();

        // Preparar os dados para o gráfico
        $data = [];
        foreach ($invoices as $invoice) {
            $monthName = Carbon::parse($invoice->month_name)->translatedFormat('M');
            $type = $invoice->type;
            $total = $invoice->total;

            if (!isset($data[$monthName])) {
                $data[$monthName] = ['income' => 0, 'expense' => 0];
            }

            if ($type === 'income') {
                $data[$monthName]['income'] = $total;
            } elseif ($type === 'expense') {
                $data[$monthName]['expense'] = $total;
            }
        }

        // Formatar os dados para o Google Charts
        $chartData = [];
        foreach ($data as $month => $totals) {
            $chartData[] = [
                'month' => $month,
                'income' => $totals['income'],
                'expense' => $totals['expense']
            ];
        }

        return view('dashboard.index', [
            'incomeWeek' => $this->helperAdm->getIncomeWeek(),
            'expenseWeek' => $this->helperAdm->getExpenseWeek(),
            'cashBalance' => $this->helperAdm->getCashBalance(),
            'invoices' => $chartData,
            'hearingsToday' => $this->helperAdm->getHearingToday(),
            'tasksToday' => $this->helperAdm->getTaskToday(),
            'lateTasks' => $this->helperAdm->getLateTasks(),
            'getTomorowHearing' => $this->helperAdm->getTomorowHearing(),
            'getTomorowTask' => $this->helperAdm->getTomorowTask(),
            'getTomorowExternalPetition' => $this->helperAdm->getTomorowExternalPetition(),
        ]);
    }
}
