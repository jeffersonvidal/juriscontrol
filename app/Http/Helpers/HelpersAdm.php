<?php

class HelpersAdm{

  /**Remove caracteres de campos (CPF, CEP, Data, etc) */
  public function clearField($param){
    if(empty($param)){
        return '';
    }

    return str_replace(['.','-','(',')','/',' '], '', $param);
  }

  /**Limpa Campo */
  public function limpaCampo($field, $value){
      return $field = $this->clearField($value);
  }

} /**Fim classe Helper */