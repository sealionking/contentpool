<?php

namespace Drupal\contentpool_remote_register\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Defines the Remote registration entity.
 *
 * @ingroup remote_registration
 *
 * @ContentEntityType(
 *   id = "remote_registration",
 *   label = @Translation("Remote registration"),
 *   handlers = {
 *     "list_builder" = "Drupal\contentpool_remote_register\RemoteRegistrationListBuilder",
 *     "views_data" = "Drupal\contentpool_remote_register\Entity\RemoteRegistrationViewsData",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *    "form" = {
 *       "delete" = "Drupal\contentpool_remote_register\Form\RemoteRegistrationDeleteForm",
 *     },
 *   },
 *   base_table = "remote_registration",
 *   admin_permission = "administer remote registrations",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/remote-registrations/{remote_registration}",
 *     "collection" = "/admin/config/remote-registrations",
 *     "delete-form" = "/admin/config/remote-registrations/{remote_registration}/delete",
 *   },
 *   field_ui_base_route = false
 * )
 */
class RemoteRegistration extends ContentEntityBase implements RemoteRegistrationInterface {

  use EntityChangedTrait;
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl() {
    return $this->get('url')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getSiteUuid() {
    return $this->get('site_uuid')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setUrl($url) {
    $this->set('url', $url);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpointUri() {
    return $this->get('endpoint_uri')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPushNotifications() {
    return (bool) $this->get('push_notifications')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPushNotifications($push_notifications) {
    $this->set('push_notifications', $push_notifications);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the remote site.'))
      ->setSettings([
        'max_length' => 255,
      ])
      ->setRequired(TRUE);

    $fields['url'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Url'))
      ->setDescription(t('The url of the remote site.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE);

    $fields['endpoint_uri'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Relaxed Endpoint URI'))
      ->setDescription(t('The encoded endpoint of the relaxed module api.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setRequired(TRUE);

    $fields['push_notifications'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Push notifications'))
      ->setDescription(t('Immediately push the content to the remote when updated.'))
      ->setRequired(FALSE)
      ->setDefaultValue(FALSE);

    $fields['site_uuid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Site UUID'))
      ->setDescription(t('The uuid of the remote site.'))
      ->setSettings([
        'max_length' => 255,
      ])
      ->setRequired(TRUE);

    $fields['replication_filters'] = BaseFieldDefinition::create('map')
      ->setLabel(t('Replication filters'))
      ->setDescription(t('The list of entity types and entities to be replicated.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
