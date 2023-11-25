<?php

namespace Drupal\rezultati;

use Drupal\node\NodeInterface;

interface TockeInterface {

  /**
   * Calculates the players points.
   */
  public function calculatePoints(): void;

  /**
   * Calculates one player's points.
   *
   * @param \Drupal\node\NodeInterface $igralka
   *   Player.
   *
   * @return int
   *   Number of points.
   */
  public function calculateSinglePoints(NodeInterface $igralka): int;

}
