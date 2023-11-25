<?php

namespace Drupal\rezultati;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Service description.
 */
class Tocke implements TockeInterface{

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a Tocke object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function calculatePoints(): void {
    $igralke = $this->entityTypeManager->getStorage('node')
      ->loadByProperties(['type' => 'igralka']);
    /** @var NodeInterface $igralka */
    foreach ($igralke as $igralka) {
      $tocke = $this->calculateSinglePoints($igralka);
      $igralka->set('field_tocke', $tocke);
      $igralka->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function calculateSinglePoints(NodeInterface $igralka): int {
    $winsQ = $this->entityTypeManager->getStorage('node')->getQuery();
    $winsQ->count()->condition('type', 'rezultat')->condition('field_zmagovalka', $igralka->id());
    /** @var int $wins */
    $wins = $winsQ->execute();

    $losesQ = $this->entityTypeManager->getStorage('node')->getQuery();
    $losesQ->count()->condition('type', 'rezultat')->condition('field_porazenka', $igralka->id());
    /** @var int $loses */
    $loses = $losesQ->execute();
    $result = 3*$wins + $loses;
    return $result;
  }

}
