<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configs extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->load->helper('url');
		$this->load->helper('menu_helper');
		$this->load->library('grocery_CRUD');
		

	}
	
	
	public function config_abm()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('config');
			$crud->columns('dias_pago');
			$crud->display_as('dias_pago','Días de pago para la alerta')
				 ->display_as('cantidad','Cantidad de artículos a mostrar en Estadísticas')
				 ->display_as('cantidad_inicial','Cantidad por defecto de articulos en presupuesto');
			$crud->set_subject('configuración');
			
			$crud->unset_back_to_list();
			
			$_COOKIE['tabla']='config';
			$_COOKIE['id']='id_config';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	
			
			$crud->unset_add();
			$crud->unset_delete();
			
			$output = $crud->render();

			$this->_example_output($output);
	}
	

 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				CRUD CONFIGS IMPRESION
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function impresion_abm()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('config_impresion');
			$crud->columns('impresion');
			$crud->display_as('impresion','Impresión');
			$crud->set_subject('impresion');
			//$crud->required_fields('impresion','id_estado');
			//$crud->fields('cabecera', 'pie', 'impresion_automatica');
			$crud->field_type('impresion', 'readonly');
			$crud->field_type('impresion_automatica', 'true_false');
			
			
			$_COOKIE['tabla']='config_impresion';
			$_COOKIE['id']='id_config';	
			
			$crud->callback_after_insert(array($this, 'insert_log'));
			$crud->callback_after_update(array($this, 'update_log'));
			$crud->callback_delete(array($this,'delete_log'));	
			
			$crud->unset_add();
			$crud->unset_delete();
			//$this->permisos_model->getPermisos_CRUD('permiso_articulo', $crud);
			
			$output = $crud->render();

			$this->_example_output($output);
	}
	
	
	 
 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Backup
 * 
 * ********************************************************************************
 **********************************************************************************/

	
	public function backup()
	{
		if($this->session->userdata('logged_in')){
			$tables = $this->db->list_tables();
			
			$query = $this->db->query("SELECT * FROM `config_backup`");
			
			foreach ($query->result() as $row) {
				$directorio		= $row->directorio;
				$formato_fecha	= $row->formato_fecha;
			}
			
			$file = fopen($directorio."/".date($formato_fecha)." BACKUP.sql", "w");
			
			if(file_exists($directorio))
			{
				foreach ($tables as $table)
				{
					$insert_cadena	= 'INSERT INTO '.$table.' (';
					$create_table	= "CREATE TABLE IF NOT EXISTS `$table` (";
					$fields			= $this->db->field_data($table);
					$i				= 0;
					
					foreach ($fields as $field)
					{
						if($i==0)
						{
							$insert_campos_cadena	= "`".$field->name."`";
							
							if($field->type != 'float' && $field->type != 'text')
							{
								$create_table_fields	= "`$field->name` $field->type($field->max_length)"; 
							}
							else
							{
								$create_table_fields		= "`$field->name` $field->type"; 
							} 
						}
						else
						{
							$insert_campos_cadena .= ", `".$field->name."`";
						
							if($field->type != 'float' && $field->type != 'text' && $field->type != 'datetime')
							{
								$create_table_fields	.= ", `$field->name` $field->type($field->max_length)"; 
							}
							else
							{
								$create_table_fields	.= ", `$field->name` $field->type"; 
							} 
						}
						
						$create_table_fields .= "<br>";
						
						if($field->primary_key)
						{
							$primary_key = $field->name ;
						}
						$i = $i+1;
					   //echo $field->type." ";
					   //echo $field->max_length." ";
					   //echo $field->primary_key." ";
					} 
					$insert_cadena	.= $insert_campos_cadena." ) VALUES";
					$create_table	.= $create_table_fields." ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;";
					$create_table	.= "<br>";
					$primary_table	= "ALTER TABLE `$table` ADD PRIMARY KEY (`$primary_key`);";
					
					$query = $this->db->query("SELECT $insert_campos_cadena FROM $table");
					
					$cant_registros = 1;
					$insert_datos_cadena = '';
					
					if($query->num_rows() > 0){
						
						foreach ($query->result() as $row) {
							$k = 0;
							
							//$insert_datos_cadena .= $cant_registros;
							foreach ($fields as $campo) {
								$name = $campo->name;
								//echo $row->$name;
								if($k==0)
								{
									if($campo->type == 'int' || $campo->type == 'float' || $campo->type == 'bigint')
									{
										$insert_datos_cadena .= "(".$row->$name;
									}
									else
									{
										$insert_datos_cadena .= "(`".$row->$name."`";
									}	
								}
								else
								{
									if($campo->type == 'int' || $campo->type == 'float' || $campo->type == 'bigint')
									{
										$insert_datos_cadena .= ", ".$row->$name;	
									}
									else
									{
										$insert_datos_cadena .= ", '".$row->$name."'";	
									}			
								}
								$k = $k+1; 
							}
							
							if(is_int($cant_registros / 400))
							{
								$insert_datos_cadena .= ");";
								$insert_datos_cadena .= "<br>";
								$insert_datos_cadena .= $insert_cadena;
								$insert_datos_cadena .= "<br>";
							}
							else
							if($query->num_rows() > $cant_registros)
							{
								$insert_datos_cadena .= "),";
								$insert_datos_cadena .= "<br>";
							}	
							else
							{
								$insert_datos_cadena .= ");";
								$insert_datos_cadena .= "<br>";
							}
							$cant_registros = $cant_registros + 1;
						}
					}
					else
					{
						$insert_cadena = '';
					}

					//echo $create_table."<br>";
					//echo $insert_cadena."<br>";   
					//echo $insert_datos_cadena."<br>";
					
					$create_table			= str_replace("<br>", "\n", $create_table);
					$insert_cadena			= str_replace("<br>", "\n", $insert_cadena);
					$insert_datos_cadena	= str_replace("<br>", "\n", $insert_datos_cadena);
					
					fwrite($file, $create_table . PHP_EOL);
					fwrite($file, $insert_cadena . PHP_EOL);
					fwrite($file, $insert_datos_cadena . PHP_EOL);
					fwrite($file, $primary_table . PHP_EOL);
					
					//fclose($file);
					
					//$backupFile = 'C:/xampp/htdocs/sarmiento/backup/'.date('Y-m-d H i s').' '.$table.'.xls';
					//$query = $this->db->query("SELECT * INTO OUTFILE '$backupFile' FROM $tableName");
				}

				fclose($file);	
				
				$db['mensaje'] = setMensaje("Backup generado el backup en $directorio", 'success');
			}
			else 
			{
				$db['mensaje'] = setMensaje("Por favor cree el directorio $directorio", 'danger');
			}
			
			$this->load->view('head.php');
			$this->load->view('menu.php');
			$this->load->view('backup.php', $db);
			
			}else{
			redirect('/','refresh');
			}
			
		}
		
}