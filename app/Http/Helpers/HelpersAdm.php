<?php

use App\Models\Customer;
use App\Models\DocumentTemplate;
use App\Models\ExternalPetition;
use App\Models\Hearing;
use App\Models\Invoice;
use App\Models\Task;
use Carbon\Carbon;

class HelpersAdm{

  /**Laravel Helper Now e Today | Jeito fácil de obter datas e horas no Laravel
   * https://www.youtube.com/watch?v=dhEQi6z4ghU */

  /**Remove caracteres de campos (CPF, CEP, Data, etc) */
  private function clearField($param){
    if(empty($param)){
        return '';
    }

    return str_replace(['.','-','(',')','/',' '], '', $param);
  }

  /**Limpa Campo */
  public function limpaCampo($value){
      return $this->clearField($value);
  }

  /**Converte string to Double - para valores monetários Ex: 1.234,56 => 1234.56*/
  public function convertStringToDouble($param){
    if(empty($param)){
        return null;
    }

    return str_replace(',', '.', str_replace('.', '', $param));
  }

  public function getMonth(){
    Carbon::setLocale('pt_BR');
    $data = Carbon::now();
    $mes = $data->translatedFormat('M'); // Formato local abreviado do mês
    return ucfirst($mes);
  }

  /**Retorna total de contas a receber na semana corrente */
  public function getIncomeWeek(){
    // Data de início da semana
    $startOfWeek = Carbon::now()->startOfWeek();

    // Data de fim da semana
    $endOfWeek = Carbon::now()->endOfWeek();

    // Soma dos registros da semana corrente
    return Invoice::where('company_id', auth()->user()->company_id)
      ->where('type','income')
      ->whereBetween('due_at', [$startOfWeek, $endOfWeek])
      ->sum('amount');
  }

  /**Retorna total de contas a pagar na semana corrente */
  public function getExpenseWeek(){
    // Data de início da semana
    $startOfWeek = Carbon::now()->startOfWeek();

    // Data de fim da semana
    $endOfWeek = Carbon::now()->endOfWeek();

    // Soma dos registros da semana corrente
    return Invoice::where('company_id', auth()->user()->company_id)
      ->where('type','expense')
      ->whereBetween('due_at', [$startOfWeek, $endOfWeek])
      ->sum('amount');
  }

  /**Pega Saldo do caixa */
  public function getCashBalance(){
    /**Somar todas as despesas pagas */
    $despesasTotal = Invoice::where('status', '=', 'paid')
    ->where('company_id', auth()->user()->company_id)
    ->where('type', 'expense')->sum('amount');

    /**Somar todas as receitas pagas */
    $receitasTotal = Invoice::where('status', '=', 'paid')
    ->where('company_id', auth()->user()->company_id)
    ->where('type', 'income')->sum('amount');

    /**Contabiliza saldo em caixa */
    return ($receitasTotal - $despesasTotal);
  }

  /**Deixar tudo bem maiúsculo */
  public function setUppercase($text){
    return strtoupper($text);
  }

  /**Retorna o cabeçalho de documentos com os dados do clietne */
  public function mountClientHeaderDocs($dadosCliente, $enderecoCliente){
    $variaveis = array('[[name]]','[[nationality]]','[[marital_status]]','[[profession]]',
    '[[phone]]','[[email]]','[[rg]]','[[rg_expedidor]]','[[cpf]]','[[street]]','[[num]]',
    '[[complement]]','[[neighborhood]]','[[city]]','[[state]]','[[zipcode]]');

    $texto = "[[name]], [[nationality]], [[nationality]], [[profession]], portador(a) do RG nº [[rg]] [[rg_expedidor]], 
    inscrito(a) no CPF sob o nº [[cpf]], residente e domiciliado em [[street]] nº [[num]], 
    [[complement]], [[neighborhood]], [[city]] - [[state]], CEP [[zipcode]], 
    telefone: [[phone]], e-mail: [[email]]";

    $camposDB = [
      $dadosCliente->name = $this->setUppercase($dadosCliente->name),
      $dadosCliente->nationality, $dadosCliente->marital_status, $dadosCliente->profession,
      $dadosCliente->phone, $dadosCliente->email, $dadosCliente->rg, $dadosCliente->rg_expedidor, 
      $dadosCliente->cpf,
      $enderecoCliente->street, $enderecoCliente->num, $enderecoCliente->complement,
      $enderecoCliente->neighborhood, $enderecoCliente->city,
      $enderecoCliente->state, $enderecoCliente->zipcode,
    ];

    return str_replace($variaveis, $camposDB, $texto);
  }

  /**Retorna situação se está atrasado ou no prazo */
  public function getSituation($dataPrazo){
    $isToday = Carbon::now()->format('Y-m-d');
    if($dataPrazo < $isToday){
      echo "<span class='badge text-bg-danger'>Atrasada</span>";
    }else if($dataPrazo == $isToday){
      echo "<span class='badge text-bg-warning'>Hoje</span>";
    }else{
        echo 'No Prazo';
    }
  }

  /**DASHBOARD */
  /**RETORNA DADOS DO ESCRITÓRIO NO DASHBOAR */

  /**Retorna total de audiências para o dia corrente */
  public function getHearingToday(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Hearing::where('company_id', auth()->user()->company_id)
      ->whereDate('date_happen', '=', $isToday)
      ->count();
  }

  /**Retorna total de tarefas para o dia corrente */
  public function getTaskToday(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
      ->whereDate('end_date', '=', $isToday)
      ->count();
  }

  /**Retorna total de tarefas atrasadas */
  public function getLateTasks(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
      ->where('status','<>',6)
      ->whereDate('end_date', '<', $isToday)
      ->count();
  }

  /**Retorna qtd audiências de amanhã */
  public function getTomorowHearing(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return Hearing::where('company_id', auth()->user()->company_id)
      ->whereDate('date_happen', '=', $tomorowDay)
      ->count();
  }

  /**Retorna qtd tarefas de amanhã */
  public function getTomorowTask(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
      ->whereDate('end_date', '=', $tomorowDay)
      ->count();
  }

  /**Retorna qtd petições de amanhã */
  public function getTomorowExternalPetition(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return ExternalPetition::where('company_id', auth()->user()->company_id)
      ->whereDate('delivery_date', '=', $tomorowDay)
      ->count();
  }

  /**RRETORNA DADOS DO USUÁRIO LOGADO NO DASHBOARD */

  /**Retorna total de audiências para o dia corrente */
  public function getUserHearingToday(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Hearing::where('company_id', auth()->user()->company_id)
      ->where('responsible', auth()->user()->id)
      ->whereDate('date_happen', '=', $isToday)
      ->count();
  }

  /**Retorna total de tarefas para o dia corrente */
  public function getUserTaskToday(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
      ->where('responsible_id', auth()->user()->id)
      ->whereDate('end_date', '=', $isToday)
      ->count();
  }

  /**Retorna total de tarefas atrasadas */
  public function getUserLateTasks(){
    // Data de início da semana
    $isToday = Carbon::now()->format('Y-m-d');

    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
      ->where('responsible_id', auth()->user()->id)
      ->where('status','<>',6)
      ->whereDate('end_date', '<', $isToday)
      ->count();
  }

  /**Retorna qtd petições de amanhã */
  public function getUserExternalPetition(){
    $isToday = Carbon::now();
    // Soma dos registros da semana corrente
    return ExternalPetition::where('company_id', auth()->user()->company_id)
      ->where('responsible', auth()->user()->id)
      ->whereDate('delivery_date', '=', $isToday)
      ->count();
  }

  /**Retorna qtd audiências de amanhã */
  public function getUserTomorowHearing(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return Hearing::where('company_id', auth()->user()->company_id)
      ->where('responsible', auth()->user()->id)
      ->whereDate('date_happen', '=', $tomorowDay)
      ->count();
  }

  /**Retorna qtd tarefas de amanhã */
  public function getUserTomorowTask(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return Task::where('company_id', auth()->user()->company_id)
    ->where('responsible_id', auth()->user()->id)
      ->whereDate('end_date', '=', $tomorowDay)
      ->count();
  }

  /**Retorna qtd petições de amanhã */
  public function getUserTomorowExternalPetition(){
    $isToday = Carbon::now();
    $addOneDay = $isToday->addDays(1);
    $tomorowDay = $addOneDay->format('Y-m-d');
    // Soma dos registros da semana corrente
    return ExternalPetition::where('company_id', auth()->user()->company_id)
      ->where('responsible', auth()->user()->id)
      ->whereDate('delivery_date', '=', $tomorowDay)
      ->count();
  }

  /**Retorna Aniversariantes do mês corrente */
  public function getBirthdays(){
    $currentMonth = Carbon::now()->month; 
    $customersWithBirthdaysThisMonth = Customer::whereMonth('birthday', $currentMonth)->get();
    return $customersWithBirthdaysThisMonth;
  }

  

  


} /**Fim classe Helper */