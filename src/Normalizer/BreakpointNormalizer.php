<?php
/**
 * @file: 
 *  BreakpointNormalizer.php
 * Date: 27.04.15
 * Time: 14:44
 */

/**
 * @file
 * Contains Drupal\grid_layouts\BreakpointNormalizer.
 */

namespace Drupal\grid_layouts;


use Drupal\Component\Utility\NestedArray;
use Drupal\breakpoint\BreakpointManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\hal\Normalizer\NormalizerBase;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
/**
 * Class BreakpointNormalizer.
 *
 * @package Drupal\grid_layouts
 */
class BreakpointNormalizer extends NormalizerBase {
  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = 'Drupal\breakpoint\BreakpointInterface';

  /**
   *  A instance of breakpoint manager.
   *
   * @var
   */
  protected $breakpointManager;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructor.
   */
  public function __construct(BreakpointManagerInterface $breakpoint_manager, ModuleHandlerInterface $module_handler) {
    $this->breakpointManager = $breakpoint_manager;
    $this->moduleHandler = $module_handler;
  }
  /**
   * Implements \Symfony\Component\Serializer\Normalizer\NormalizerInterface::normalize()
   */
  public function normalize($breakpoint, $format = NULL, array $context = array()) {
    return $this->serializer->normalize($breakpoint, $format, $context);
  }

  /**
   * Implements \Symfony\Component\Serializer\Normalizer\DenormalizerInterface::denormalize().
   *
   * @param array $data
   *   Entity data to restore.
   * @param string $class
   *   Unused, entity_create() is used to instantiate entity objects.
   * @param string $format
   *   Format the given data was extracted from.
   * @param array $context
   *   Options available to the denormalizer. Keys that can be used:
   *   - request_method: if set to "patch" the denormalization will clear out
   *     all default values for entity fields before applying $data to the
   *     entity.
   *
   * @throws \Symfony\Component\Serializer\Exception\UnexpectedValueException
   */
  public function denormalize($data, $class, $format = NULL, array $context = array()) {
    return $this->serializer->denormalize($data, $format, $context);
  }
}
