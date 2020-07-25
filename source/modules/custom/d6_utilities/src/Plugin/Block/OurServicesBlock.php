<?php
namespace Drupal\mwb_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Block(
 *   id = "front_our_services_block",
 *   admin_label = @Translation("Front Our Services  Block")
 * )
 */
class OurServicesBlock extends BlockBase {
    /**
     * @return array
     * Setting up the defualt block configurations
     */
    public function defaultConfiguration() {
        return [
            'service_block_title' => $this->t('markets we serve'),
            'service_block_description' => $this->t('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, dignissimos! 
Lorem ipsum dolor sit amet, consectetur.'),
            'market_items' => 3
        ];
    }

    /**
     * @param $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form['service_block_title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#default_value' => $this->configuration['service_block_title'],
        ];

        $form['service_block_description'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Description'),
            '#default_value' => $this->configuration['service_block_description'],
        ];

        $form['service_block_items'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Items Per Block'),
            '#default_value' => $this->configuration['service_block_items'],
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     *
     * This method processes the blockForm() form fields when the block
     * configuration form is submitted.
     *
     * The blockValidate() method can be used to validate the form submission.
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['service_block_title'] = $form_state->getValue('service_block_title');
        $this->configuration['service_block_description'] = $form_state->getValue('service_block_description');
        $this->configuration['service_block_items'] = $form_state->getValue('service_block_items');

    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $query = \Drupal::entityQuery('node');
        $query->condition('status', 1);
        $query->condition('type', 'market_we_serve');
        $query->sort('created' , 'DESC');
        $entity_ids = $query->execute();
        $service_node = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($entity_ids);

        $services = [];
        foreach ($service_node as $service){
            $fid = $service->get('field_market_icon')->getValue()[0]['target_id'];
            if($fid){
                $file = \Drupal\file\Entity\File::load($fid);
                $path = $file->getFileUri();
                $image_url = file_create_url($path);
            }else{
                $image_url='';
            }

            if($service->get('field_market_uri')->getValue()){
                $uri = $service->get('field_market_uri')->getValue()[0]['uri'];
            }else{
                $uri = '#';
            }

            $service_data = [
                'market_image' => $image_url,
                'uri' => $uri
            ];

            array_push($services,$service_data);

        }



        $data = [
            'market_title' => $this->configuration['market_title'],
            'market_description' => $this->configuration['market_description'],
            'market_items' => $this->configuration['market_items'],
            'markets_node' => $services
        ];
        return array(
            '#theme' => 'front-our-services',
            '#data' => $data,
        );
    }

}