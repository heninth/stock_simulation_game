<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockSymbol extends Model
{
  /**
   * Model's primary key.
   *
   * @var string
   */
  public $primaryKey = 'symbol';
  public $incrementing = false;

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;
}
