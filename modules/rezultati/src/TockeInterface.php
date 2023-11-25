<?php

namespace Drupal\rezultati;

use Drupal\node\NodeInterface;

interface TockeInterface {

  /**
   * Calculates the players points.
   *
   * @return int
   */
  public function calculatePoints(NodeInterface $igralka): int;

}
