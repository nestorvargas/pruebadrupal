<?php

namespace Drupal\pruebadrupal\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class importarusuariosform extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		// Nombre del formulario
		return 'importarusuario_form';
	}

	public function buildForm(array $form, FormStateInterface $form_state) {

		$form['importer'] = [
			'#type'       => 'container',
			'#attributes' => [
				'id'         => 'csv-importer',
			],
		];

		$form['importer']['delimiter'] = [
			'#type'    => 'select',
			'#title'   => $this->t('Escoger delimitador'),
			'#options' => [
				','       => ',',
				'~'       => '~',
				';'       => ';',
				':'       => ':',
			],
			'#default_value' => ',',
			'#required'      => TRUE,
			'#weight'        => 10,
		];

		$form['importer']['csv'] = [
			'#type'              => 'managed_file',
			'#title'             => $this->t('Seleccionar Archivo CSV '),
			'#required'          => TRUE,
			'#autoupload'        => TRUE,
			'#upload_validators' => ['file_validate_extensions' => ['csv']],
			'#weight'            => 10,
		];

		$form['actions']['#type']  = 'actions';
		$form['actions']['submit'] = [
			'#type'        => 'submit',
			'#value'       => $this->t('Import'),
			'#button_type' => 'primary',
		];

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array&$form, FormStateInterface $form_state) {
		$entity_type        = $form_state->getValue('entity_type');
		$entity_type_bundle = NULL;
		$csv                = current($form_state->getValue('csv'));
		$csv_parse          = $this->parser->getCsvById($csv, $form_state->getUserInput()['delimiter']);

		if (isset($form_state->getUserInput()['entity_type_bundle'])) {
			$entity_type_bundle = $form_state->getUserInput()['entity_type_bundle'];
		}

		$entity_fields = $this->getEntityTypeFields($entity_type, $entity_type_bundle);

		if ($required = $this->getEntityTypeMissingFields($entity_type, $entity_fields['required'], $csv_parse)) {
			$render = [
				'#theme' => 'item_list',
				'#items' => $required,
			];

			$this->messenger()->addError($this->t('Your CSV has missing required fields: @fields', ['@fields' => $this->renderer->render($render)]));
		} else {
			$this->importer->createInstance($form_state->getUserInput()['plugin_id'], [
					'csv'                => $csv_parse,
					'csv_entity'         => $this->parser->getCsvEntity($csv),
					'entity_type'        => $entity_type,
					'entity_type_bundle' => $entity_type_bundle,
					'fields'             => $entity_fields['fields'],
				])->process();
		}
	}

}
