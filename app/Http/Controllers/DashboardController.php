<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ExternalPetition;
use App\Models\Hearing;
use App\Models\Invoice;
use App\Models\Task;
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
        // Data do dia corrente
        $isToday = Carbon::now()->format('Y-m-d');
        $startOfWeek = Carbon::now()->startOfWeek(); 
        $endOfWeek = Carbon::now()->endOfWeek(); 

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

        /**Cliente por mês */
        $customersPerMonth = DB::table('customers')
        ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), 
        DB::raw('COUNT(*) as count'))
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
        ->get();

        /**Origem dos clientes */
        $customersMetUs = Customer::select('met_us', DB::raw('count(*) as total'))
        ->groupBy('met_us')->get();

        /**Retorna as audiências da semana */
        $hearingsWeek = Hearing::whereBetween('date_happen', [$startOfWeek, $endOfWeek])->get();
        
        /**Retorna as petições da semana */
        $petitionsWeek = ExternalPetition::whereBetween('delivery_date', [$startOfWeek, $endOfWeek])->get();
        
        /**Retorna as tarefas da semana */
        $tasksWeek = Task::whereBetween('delivery_date', [$startOfWeek, $endOfWeek])->get();

        

        

        return view('dashboard.index', [
            'incomeWeek' => $this->helperAdm->getIncomeWeek(),
            'expenseWeek' => $this->helperAdm->getExpenseWeek(),
            'cashBalance' => $this->helperAdm->getCashBalance(),
            'isToday' => $isToday,
            'invoices' => $chartData,
            'customersPerMonth' => $customersPerMonth,
            'customersMetUs' => $customersMetUs,
            'hearingsWeek' => $hearingsWeek,
            'tasksWeek' => $tasksWeek,
            'petitionsWeek' => $petitionsWeek,
            'hearingsToday' => $this->helperAdm->getHearingToday(),
            'tasksToday' => $this->helperAdm->getTaskToday(),
            'lateTasks' => $this->helperAdm->getLateTasks(),
            'getTomorowHearing' => $this->helperAdm->getTomorowHearing(),
            'getTomorowTask' => $this->helperAdm->getTomorowTask(),
            'getTomorowExternalPetition' => $this->helperAdm->getTomorowExternalPetition(),
            'getUserLateTasks' => $this->helperAdm->getUserLateTasks(),
            'userHearingsToday' => $this->helperAdm->getUserHearingToday(),
            'userTasksToday' => $this->helperAdm->getUserTaskToday(),
            'getUserTomorowHearing' => $this->helperAdm->getUserTomorowHearing(),
            'getUserTomorowTask' => $this->helperAdm->getUserTomorowTask(),
            'getUserTomorowExternalPetition' => $this->helperAdm->getUserTomorowExternalPetition(),
            'getUserExternalPetition' => $this->helperAdm->getUserExternalPetition(),
            'getBirthdays' => $this->helperAdm->getBirthdays(),
        ]);
    }
}
