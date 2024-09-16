<?php

class HelpersAdm{

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

} /**Fim classe Helper */