<?php

namespace Drupal\pruebadrupal\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * class controller.
 */

class UsuarioController extends ControllerBase {

	/**
	 * registro method.
	 */
	public function registro() {

		// Utilizamos el formulario
		$form = $this->formBuilder()->getForm('Drupal\pruebadrupal\Form\registrousuarioform');

		// Le pasamos el formulario y demás a la vista (tema configurado en el module)
		return [
			'#theme'    => 'registro_usuario',
			'#attached' => array(
				'library'  => array(
					'pruebadrupal/pruebadrupallib',
					'pruebadrupal/jquery_validate',
				),
			),
			'#titulo'      => $this->t('Registrar Usuario'),
			'#descripcion' => 'Por favor llena los siguientes ',
			'#formulario'  => $form,
			'#markup'      => " ",
		];

	}

	/**
	 * listar usuarios method.
	 */

	public function listarusuarios() {

		// Sacar datos de la base de datos

		// Sacar datos de la base de datos
		$database = \Drupal::database();
		$query    = $database->query("SELECT * FROM {myusers}");
		$usuarios = $query->fetchAll();

		// Cargamos datos en una vísta, usando hook_theme
		return array(
			'#attached' => array(
				'library'  => array(
					'pruebadrupal/pruebadrupallib',
				),
			),
			'#theme'       => 'listar_usuarios',
			'#titulo'      => $this->t('Listado de Usuarios'),
			'#descripcion' => $this->t('Usuarios disponibles'),
			'#usuarios'    => $usuarios,
		);

	}

	/**
	 * reports usuarios method.
	 */

	public function exportarusuarios(Request $request) {

		//$headers       = array('ID ', 'Nombre ', 'Correo');
		$db_connection = Database::getConnection('default');
		$query         = $db_connection->select('myusers', 'u');
		$query->fields('u', ['id', 'nombre', 'correo']);
		$result = $query->execute();
		if (!empty($result)) {
			$data = [];

			foreach ($result as $record) {
				$data[] = ['id' => $record->id, 'nombre' => $record->nombre, 'correo' => $record->correo];
			}

			$output[] = [
				'#attached' => array(
					'library'  => array(
						'pruebadrupal/pruebadrupallib',
					),
				),
				'#theme' => 'exportar_datos',
				//'#header_data' => $headers,
				'#record_data' => $data,
			];

			return $output;
		}
	}

	/**
	 * exportar usuarios method.
	 */

	public function downloadusuarios() {

		$download_folder = 'public://exportData';
		$str             = rand();
		$str_result      = md5($str);
		$file_name       = 'Data-usuarios'.$str_result.'.csv';
		//$file_name = 'Data-usuarios.csv';
		$fwp    = fopen($download_folder.'/'.$file_name, 'a');
		$result = db_query("SELECT * FROM myusers ORDER BY id DESC");
		if (!empty($result)) {
			foreach ($result as $record) {

				$fields = array($record->id, $record->nombre, $record->correo);
				fputcsv($fwp, $fields);
				//print_r($record);
			}
		}

		$file = 'http://localhost/drupal/sites/default/files/exportData/'.$file_name;

		$response = new Response();

		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $file_name));
		$response->headers->set('Content-Length', filesize($file_name));
		$response->headers->set('Content-Transfer-Encoding', 'binary');
		$response->setContent(readfile($file));

		return $response;
	}

	/**
	 * registro method.
	 */
	public function importarusuarios() {

		// Utilizamos el formulario
		$form = $this->formBuilder()->getForm('Drupal\pruebadrupal\Form\importarusuariosform');

		// Le pasamos el formulario y demás a la vista (tema configurado en el module)
		return [
			'#theme'    => 'importar_user',
			'#attached' => array(
				'library'  => array(
					'pruebadrupal/pruebadrupallib',
					'pruebadrupal/jquery_validate',
				),
			),
			'#titulo'      => $this->t('Importar Usuario'),
			'#descripcion' => 'Por favor llena los siguientes ',
			'#formulario'  => $form,
			'#markup'      => " ",
		];

	}

}

?>