<?php
/**
 * @file: 
 *  BreakpointRestResource.php
 * Date: 27.04.15
 * Time: 14:09
 */
namespace Drupal\grid_layouts\Plugin\rest\resource;

use Drupal\breakpoint\BreakpointManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "breakpoint_rest_resource",
 *   label = @Translation("Breakpoint"),
 *   uri_paths = {
 *     "canonical" = "/breakpoint"
 *   }
 * )
 */
class BreakpointRestResource extends ResourceBase {
  /**
   * A curent user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   *  A instance of breakpoint manager.
   *
   * @var Drupal\breakpoint\BreakpointManagerInterface
   */
  protected $breakpointManager;


  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    BreakpointManagerInterface $breakpoint_manager,
    AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->breakpointManager = $breakpoint_manager;
    $this->currentUser = $current_user;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('breakpoint.manager'),
      $container->get('current_user')
    );
  }
  /**
   * Responds to GET requests.
   *
   * Returns a list of bundles for specified entity.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get() {
    $permission = 'View published content';
    if(!$this->currentUser->hasPermission($permission)) {
      throw new AccessDeniedHttpException();
    }
    $breakpoints = array();
    $breakpoint_groups = $this->breakpointManager->getGroups();
    foreach($breakpoint_groups as $group => $name) {
      $breakpoints[] = $this->breakpointManager->getBreakpointsByGroup($group);
    }

    if (!empty($breakpoints)) {
      return new ResourceResponse($breakpoints);
    }
    throw new NotFoundHttpException(t('Breakpoints were not found'));
  }

}
