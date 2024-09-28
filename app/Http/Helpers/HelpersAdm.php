<?php

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


} /**Fim classe Helper */