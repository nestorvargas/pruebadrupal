<?php

/**
 * @file
 * Contains \Drupal\pruebadrupal\Form\registrousuarioform.
 */
namespace Drupal\pruebadrupal\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class registrousuarioform extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		// Nombre del formulario
		return 'registrousuario_form';
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {

		//$form['#attached']['library'][] = 'pruebadrupal/pruebadrupallib';

		// Definimos los campos

		$form['usuario'] = [
			'#type'     => 'textfield',
			'#title'    => $this->t('Usuario'),
			'#required' => TRUE,
		];

		$form['correo'] = [
			'#type'     => 'email',
			'#title'    => $this->t('Correo Electrónico'),
			'#required' => TRUE,
		];

		$form['submit'] = [
			'#type'  => 'submit',
			'#value' => $this->t('Guardar'),
		];
		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array&$form, FormStateInterface $form_state) {

		// validaciones necesarias

		if (empty($form_state->getValue('correo')) && !\Drupal::service('email.validator')->isValid($value)) {
			$form_state->setError($element, t('Es necesario introducir un Correo y formato %mail no es valido.', array('%mail' => $value)));
		}

		if (empty($form_state->getValue('usuario'))) {
			$form_state->setErrorBynombre('usuario', $this->t('Es necesario introducir un usuario'));
		}
	}

	/**
	 * {@inheritdoc}
	 */

	public function submitForm(array&$form, FormStateInterface $form_state) {

		$values = array(
			'nombre' => $form_state->getValue('usuario'),
			'correo' => $form_state->getValue('correo'),
		);

		$table = 'myusers';

		\Drupal::database()->insert($table)
		                   ->fields(array(
				'nombre' => $values['nombre'],
				'correo' => $values['correo'],
			))
			->execute();

		drupal_set_message('Guardado Correctamente.', 'status');

		// Mostrar resultados al enviar el formulario en un mensaje de drupal
		//foreach ($form_state->getValues() as $key => $value) {
		//drupal_set_message($key.': '.$value);
		//}
	}

}
