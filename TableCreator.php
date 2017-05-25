<?php

namespace TableCreator;

abstract class TableCreator {

  /** @var array  */
  protected $header = [];

  /** @var array  */
  protected $rows = [];

  /** @var array  */
  protected $padding = 1;

  /**
   * @return string
   */
  abstract public function getTable();

  /**
   * @param array $header
   * @return $this
   */
  public function setHeader( array $header ){
    $this->header = $header;

    return $this;
  }

  /**
   * @param array $row
   * @return $this
   */
  public function addRow( array $row ){
    $this->rows[] = $row;

    return $this;
  }

  /**
   * @param array[] $rows
   * @return $this
   */
  public function addRows( array $rows ){
    foreach( $rows as $row ){
      $this->rows[] = $row;
    }

    return $this;
  }
}