<?php

namespace TableCreator;

/**
 * Class TextTableCreator
 *
 * Creates a text based table for printing out simple arrays
 *
 * CONVERTS:
 *
 * $table = new TextTableCreator();
 *
 * $table->setHeader( [ 'Item', 'Quantity' ] );
 *
 * $table->addRow( [ 'Bread',     '1 loaf'                   ] )
 *       ->addRow( [ 'Milk',      '3 pints'                  ] )
 *       ->addRow( [ 'Bananas',   'a bunch'                  ] )
 *       ->addRow( [ 'Coke',      '1 can'                    ] )
 *       ->addRow( [ 'Chocolate', 'as much as you can carry' ] );
 *
 * echo $table->getTable();
 *
 * INTO:
 *
 * |--------------------------------------|
 * | Item      | Quantity                 |
 * |======================================|
 * | Bread     | 1 loaf                   |
 * |--------------------------------------|
 * | Milk      | 3 pints                  |
 * |--------------------------------------|
 * | Bananas   | a bunch                  |
 * |--------------------------------------|
 * | Coke      | 1 can                    |
 * |--------------------------------------|
 * | Chocolate | as much as you can carry |
 * |--------------------------------------|
 */
class TextTableCreator extends TableCreator {
  const TD = '|';

  private $columnWidths = [];

  /**
   * @return string
   */
  public function getTable() {
    $table = $this->getHeader();

    foreach( $this->rows as $row ) {
      $table .= $this->createRowContent( $row );
      $table .= PHP_EOL;
      $table .= $this->createRowSplitter();
      $table .= PHP_EOL;
    }

    return $table;
  }

  /**
   * @return string
   */
  private function getHeader() {
    $headerString = $this->createRowSplitter();
    $headerString .= PHP_EOL;
    $headerString .= $this->createRowContent( $this->header );
    $headerString .= PHP_EOL;
    $headerString .= $this->createRowSplitter( '=' );
    $headerString .= PHP_EOL;

    return $headerString;
  }

  /**
   * @return array
   */
  private function getColumnWidths() {
    if( empty( $this->columnWidths ) ) {
      $this->columnWidths = [];

      foreach( $this->header as $content ) {
        $content = (string)$content;
        $this->columnWidths[] = strlen( $content );
      }

      foreach( $this->rows as $row ) {
        foreach( $row as $column => $content ) {
          $length = strlen( (string)$content );

          if( !isset( $this->columnWidths[ $column ] ) || $this->columnWidths[ $column ] < $length ) {
            $this->columnWidths[ $column ] = $length;
          }
        }
      }
    }

    return $this->columnWidths;
  }

  /**
   * @param array $row
   * @return string
   */
  private function createRowContent( array $row ) {
    $rowString = self::TD;
    $columnWidths = $this->getColumnWidths();

    foreach( $row as $column => $cell ) {
      $maxWidth = $columnWidths[ $column ];
      $rowString .= self::createCell( $cell, $maxWidth );
      $rowString .= self::TD;
    }

    return $rowString;
  }

  /**
   * @param string $char
   * @return string
   */
  private function createRowSplitter( $char = '-', $includeColumns = true ) {
    $columnWidths = $this->getColumnWidths();
    $splitter = $includeColumns ? self::TD : $char;

    foreach( $columnWidths as $width ) {
      $totalWidth = $width + $this->padding;
      for( $i = 0; $i <= $totalWidth; $i++ ) {
        $splitter .= $char;
      }
      $splitter .= $char;
    }

    $end = $includeColumns ? self::TD : $char;

    return substr( $splitter, 0, -1 ) . $end;
  }

  /**
   * @param string  $string
   * @param integer $length
   *
   * @return string
   */
  private function createCell( $string, $length ) {
    while( strlen( $string ) < $length ) {
      $string .= ' ';
    }

    // add padding
    for( $i = 0; $i < $this->padding; $i++ ) {
      $string = " $string ";
    }

    return $string;
  }
}