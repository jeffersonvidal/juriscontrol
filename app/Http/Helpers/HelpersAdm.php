<?php

use App\Models\Invoice;
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
    \Carbon\Carbon::setLocale('pt_BR');
    $data = \Carbon\Carbon::now();
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


} /**Fim classe Helper */