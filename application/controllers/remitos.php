<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remitos extends MY_Controller{

	public function __construct() {
		parent::__construct();

		$this->load->model('articulos_model');
		$this->load->model('clientes_model');
		$this->load->model('proveedores_model');
		$this->load->model('grupos_model');
		$this->load->model('presupuestos_model');
		$this->load->model('remitos_model');
		$this->load->model('remitos_detalle_model');
		$this->load->model('categorias_model');
		$this->load->model('subcategorias_model');
		$this->load->model('config_impresion_model');
		$this->load->model('devoluciones_model');
		$this->load->model('devoluciones_detalle_model');
		$this->load->model('renglon_presupuesto_model');

		$this->path = 'remitos';
		$this->load->library('grocery_CRUD');
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				CRUD Remitos
 *
 * ********************************************************************************
 **********************************************************************************/

    public function remitos_abm() {
        $crud = new grocery_CRUD();

        $crud->set_table('remito');

        $crud->order_by('id_remito','desc');

        $crud->columns('id_remito','fecha', 'monto','id_cliente');

        $crud->display_as('id_cliente','Descripción')
            ->display_as('id_remito','Número')
            ->display_as('id_estado','Estado');

        $crud->set_subject('remiro');
        /*
        $crud->required_fields('descripcion','id_estado');
         */
        $crud->set_relation('id_cliente','cliente','{alias} - {nombre} {apellido}');
        $crud->set_relation('id_estado','estado','estado');

        $_COOKIE['tabla']='remito';
        $_COOKIE['id']='id_remito';

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_read();
        $crud->unset_delete();

        $crud->callback_after_insert(array($this, 'insert_log'));

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_delete(array($this,'delete_log'));
        $crud->add_action('Detalle', '', '','icon-exit', array($this, 'buscar_articulos'));

        $output = $crud->render();

        $this->viewCrud($output);
    }

    function buscar_articulos($id) {
        return site_url($this->path.'/remito_vista').'/'.$id;
    }

/**********************************************************************************
 **********************************************************************************
 * 
 * 				Remito Form
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function remito() {
        $db['texto']		= getTexto();
        $db['clientes']		= $this->clientes_model->select();

        if($this->input->post('buscar')==1) {
            $id_cliente = 0;

            if($this->input->post('cliente_alias') != 0) {
                $id_cliente = $this->input->post('cliente_alias');
            } else if($this->input->post('cliente_apellido') != 0) {
                $id_cliente = $this->input->post('cliente_apellido');
            }

            if($id_cliente != 0) {
                $datos = array(
                    'id_cliente'=> $id_cliente,
                    'tipo'		=> 2,	//Cuenta corriente
                    'estado'	=> 1	//Falta de pago
                );
                $db['id_cliente']		= $id_cliente;
                $db['presupuestos']		= $this->presupuestos_model->select($datos);
                $db['devoluciones']		= $this->devoluciones_model->getCliente($id_cliente);
            }
        }

        $this->view($db, $this->path.'/remito.php');
	}

/**********************************************************************************
 **********************************************************************************
 * 
 * 				Remito insert
 * 
 * ********************************************************************************
 **********************************************************************************/

	public function remito_insert() {
        $id_cliente 	= $this->input->post('cliente');
        $total			= $this->input->post('total');
        $total_hidden	= $this->input->post('total_hidden');
        $total_dev		= $this->input->post('total_dev');

        $datos = array(
            'id_cliente'	=> $id_cliente,
            'tipo'			=> 2,
            'estado'		=> 1
        );

        $db['presupuestos']	= $this->presupuestos_model->select($datos);
        $presupuestos 		= $db['presupuestos'];

        if($total_hidden == $total) { //No se realizo el pago automatico
            $remito = array(
                "fecha"			=> date('Y-m-d H:i:s'),
                "monto"			=> $total,
                "id_cliente"	=> $id_cliente,
                "estado"		=> 1
            );

            $id_remito = $this->remitos_model->insert($remito);

            foreach ($presupuestos as $row) {
                if($this->input->post($row->id_presupuesto) != 0) {
                    $remito_detalle = array(
                        'id_remito'			=> $id_remito,
                        'id_presupuesto'	=> $row->id_presupuesto,
                        'monto'				=> $this->input->post($row->id_presupuesto),
                        'estado'			=> 1
                    );

                    $this->remitos_detalle_model->insert($remito_detalle);//Insert detalle remito

                    //Update del remito
                    $a_cuenta	= $row->a_cuenta + $this->input->post($row->id_presupuesto);

                    if($a_cuenta == $row->monto) {//se completo el pago del presupuesto
                        $update_pres = array(
                                'a_cuenta'	=> $a_cuenta,
                                'estado'	=> 2
                        );

                        $this->presupuestos_model->update($update_pres, $row->id_presupuesto);
                    } else if($row->monto > $a_cuenta) {//el monto sigue siendo mayor al pago
                        $update_pres = array(
                            'a_cuenta'	=> $a_cuenta
                        );

                        $this->presupuestos_model->update($update_pres, $row->id_presupuesto);
                    }
                }
            }
        } else {
            $remito = array(
                "fecha"			=> date('Y-m-d H:i:s'),
                "monto"			=> $total,
                "id_cliente"	=> $id_cliente,
                "estado"		=> 1
            );
            $id_remito = $this->remitos_model->insert($remito);

            foreach ($presupuestos as $row) {
                if($total > 0) {//Verificamos que aun hay monto para pagar
                    $resto_apagar	= $row->monto - $row->a_cuenta;

                    if($resto_apagar < $total) {//Si el monto a pagar del presupuesto no supera el del pago
                        $pago		= $resto_apagar;
                        $total		= $total - $resto_apagar;
                        $a_cuenta	= $row->monto;
                        $estado		= 2;
                    } else {//Si lo supera
                        $pago		= $total;
                        $a_cuenta	= $row->a_cuenta + $total;
                        $total		= 0;
                        $estado		= 1;
                    }

                    $remito_detalle = array(
                        'id_remito'			=> $id_remito,
                        'id_presupuesto'	=> $row->id_presupuesto,
                        'monto'				=> $pago,
                        'estado'			=> 1
                    );

                    $this->remitos_detalle_model->insert($remito_detalle);//Insert detalle remito

                    $update_pres = array(
                        'a_cuenta'	=> $a_cuenta,
                        'estado'	=> $estado
                    );

                    $this->presupuestos_model->update($update_pres, $row->id_presupuesto);
                }
            }
        }

        // Hacer los insert de devoluciones
        if ($total_dev > 0) {
            $this->insert_devoluciones($id_remito);
        }

        redirect($this->path.'/remito_vista/'.$id_remito.'/'.$id_cliente,'refresh');//Redireccionamos para evitar problemas con la recarga de la pagina f5
	}


 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Insert de devoluciones
 * 
 * ********************************************************************************
 **********************************************************************************/	
	
	
	function insert_devoluciones($id_remito) {
		$remitos		= $this->remitos_model->getRemito($id_remito);
		
		foreach ($remitos as $row) {
			$total		= $row->monto;
			$devoluciones	= $this->devoluciones_model->getCliente($row->id_cliente);
		}
		
		$total_dev = 0;
		
		foreach ($devoluciones as $row) {
			if($total >0) {
				$resto_apagar	= $row->monto - $row->a_cuenta;
							
				if($resto_apagar < $total) {//Si el monto a pagar del presupuesto no supera el del pago
					$pago		= $resto_apagar;
					$total		= $total - $resto_apagar;
					$a_cuenta	= $row->monto;
					$estado		= 2;
				} else {//Si lo supera
				    $pago		= $total;
					$a_cuenta	= $row->a_cuenta + $total;
					$total		= 0;
					$estado		= 1;
				}
						
				$remito_detalle = array(
					'id_remito'			=> $id_remito,
					'id_devolucion'		=> $row->id_devolucion,
					'monto'				=> -$pago,
					'estado'			=> 1
				);
							
				$this->remitos_detalle_model->insert($remito_detalle);//Insert detalle remito
							
				$update_dev = array(
					'a_cuenta'	=> $a_cuenta,
					'id_estado'	=> $estado
				);
								
				$this->devoluciones_model->update($update_dev, $row->id_devolucion);
				
				$total_dev =  $total_dev + $pago;	
			}	
			
            $update_remito = array(
                'devolucion'	=> $total_dev
            );

            $this->remitos_model->update($update_remito, $id_remito);
		}
	}

 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Vista detalle
 * 
 * ********************************************************************************
 **********************************************************************************/	


	function remito_vista2($id, $id_cliente = NULL) {
		$db['remitos']			= $this->remitos_model->getRemito($id);
		$db['remitos_detalle']	= $this->remitos_detalle_model->getRemitos($id);
		$db['remitos_dev']		= $this->remitos_detalle_model->getRemitos($id, 'dev');
		$db['impresiones']		= $this->config_impresion_model->select(1);
		
		if($id_cliente === NULL) {
			$remitos = $db['remitos'];
			
			foreach ($remitos as $row) {
				$id_cliente = $row->id_cliente;	
			}
		}
		
		$datos = array(
			'id_cliente'=> $id_cliente,
			'tipo'		=> 2,
			'estado'	=> 1
		);
			
		$db['presupuestos']		= $this->presupuestos_model->select($datos);

		$this->view($db, $this->path.'/remito_insert.php');
	}

 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Vista final remito
 * 
 * ********************************************************************************
 **********************************************************************************/	

	function remito_vista($id, $id_cliente = NULL) {
		$db['remitos']			= $this->remitos_model->getRemito($id);
		$db['remitos_detalle']	= $this->remitos_detalle_model->getRemitos($id);
		$db['remitos_dev']		= $this->remitos_detalle_model->getRemitos($id, 'dev');
		$db['impresiones']		= $this->config_impresion_model->select(1);
		
		if($id_cliente === NULL) {
			$remitos = $db['remitos'];
			
			foreach ($remitos as $row) {
				$id_cliente = $row->id_cliente;	
			}
		}
		
		$datos = array(
			'id_cliente'=> $id_cliente,
			'tipo'		=> 2,
			'estado'	=> 1
		);
			
		$db['presupuestos']		= $this->presupuestos_model->select($datos);

		$this->view($db, $this->path.'/remito_vista.php');
	}


 /**********************************************************************************
 **********************************************************************************
 * 
 * 				Generar las devoluciones sacar de aca, es de presupuesto
 * 
 * ********************************************************************************
 **********************************************************************************/

	function anular($id) {
        $condicion = array(
            'id_presupuesto' => $id
        );

        $db['texto']				= getTexto();
        $db['presupuestos']			= $this->presupuestos_model->select($id);
        $db['detalle_presupuesto']	= $this->renglon_presupuesto_model->getDetalle($id);
        $db['impresiones']			= $this->config_impresion_model->select(2);
        $db['devoluciones']			= $this->devoluciones_model->select($condicion);

        $this->view($db, 'presupuestos/anular_presupuestos.php');
	}

/**********************************************************************************
 **********************************************************************************
 *
 * 				Presupuesto de Salida
 *
 * ********************************************************************************
 **********************************************************************************/

    public function salida() {
        $db = [];
        $this->view($db, $this->path.'/presupuestos_salida.php');
    }
}