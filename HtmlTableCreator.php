<?php

namespace TableCreator;

class HtmlTableCreator extends TableCreator {

  /**
   * @return string
   */
  public function getTable() {
    $table = $this->openTable();

    $table .= $this->getHeader();
    $table .= $this->getBody();

    $table .= $this->closeTable();

    return $table;
  }

  /**
   * @return string
   */
  private function getBody(){
    $body = '<tbody>';

    foreach( $this->rows as $row ){
      $body .= '<tr>';

      foreach( $row as $column ){
        $body .= "<td>$column</td>";
      }

      $body .= '</tr>';
    }

    $body .= '<tbody>';

    return $body;
  }

  /**
   * @return string
   */
  private function getHeader(){
    $header = '<thead>';
    $header .= '<tr>';

    foreach( $this->header as $column ){
      $header .= "<th>$column</th>";
    }

    $header .= '</tr>';
    $header .= '</thead>';

    return $header;
  }

  /**
   * @return string
   */
  private function openTable(){
    return '<table>';
  }

  /**
   * @return string
   */
  private function closeTable(){
    return '</table>';
  }
}