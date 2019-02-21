<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Presupuestos extends CI_Controller {

    public function __construct(){
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
        $this->load->model('anulaciones_model');

        $this->load->library('grocery_CRUD');
    }

/**********************************************************************************
 **********************************************************************************
 *
 * 				Presupuesto de Salida
 *
 * ********************************************************************************
 **********************************************************************************/

    public function salida()
    {
        if($this->session->userdata('logged_in')){
            $this->load->view('head.php');
            $this->load->view('menu.php');
            $this->load->view('presupuestos/presupuestos_salida');
            $this->load->view('footer.php');
        }else{
            redirect('/','refresh');
        }
    }

/**********************************************************************************
 **********************************************************************************
 *
 * 				CRUD Presupuestos
 *
 * ********************************************************************************
 **********************************************************************************/

    function cargaPresupuesto() {
        $fecha		= date('Y-m-d H:i:s');
        $monto		= $_POST['total'];
        $id_cliente	= $_POST['cliente'];
        $tipo		= $_POST['tipo'];
        $estado		= $_POST['estado'];
        $dto		= $_POST['desc'];
        $id_vendedor   = $_POST['vendedor'];
        $comentario	= $_POST['comentario'];
        $com_publico  = $_POST['com_publico'];
        $codigos_a_cargar	= $_POST['codigos_art'];
        $cant_a_cargar		= $_POST['cantidades'];
        $precios_a_cargar	= $_POST['precios'];
        //CARGO PRESUPUESTO
        $consulta	= "INSERT INTO presupuesto (fecha, monto, id_cliente,tipo,estado,descuento, id_vendedor, comentario, com_publico) VALUES('$fecha',$monto,$id_cliente,$tipo,$estado,$dto, '$id_vendedor', '$comentario', $com_publico)";
        $query = $this->db->query($consulta);
        //$result		= mysql_query($qstring) or die(mysql_error());//query the database for entries containing the term
        //CARGO PRESUPUESTO
        //CARGO REGLON PRESUPUESTO //
        //$id_presupuesto = mysql_insert_id();
        $id_presupuesto = $this->db->insert_id();
        $codigos_cargados = array();
        for ($i=0; $i<count($codigos_a_cargar); $i++ )
        {
            if(in_array($codigos_a_cargar[$i], $codigos_cargados))
            {
                $file = fopen("carga_presupuestos.log", "a");
                fwrite($file, date('Y-m-d H:i:s'). "El presupuesto nro ".$id_presupuesto." esta repitiendo los codigos\n" . PHP_EOL);
                fclose($file);
            }
            else
            {
                $qstring = "
		INSERT INTO 
			reglon_presupuesto (
				id_presupuesto,
				id_articulo,
				cantidad,
				precio,
				estado
			) 
		VALUES(
			$id_presupuesto,
			$codigos_a_cargar[$i],
			$cant_a_cargar[$i],
			$precios_a_cargar[$i],
			1
		)";
                $result = $this->db->query($qstring);
                //$result = mysql_query($qstring) or die(mysql_error());//query the database for entries containing the term
            }
        }
        //CARGO REGLON PRESUPUESTO //
    }













/**********************************************************************************
 **********************************************************************************
 *
 * 				CRUD Presupuestos
 *
 * ********************************************************************************
 **********************************************************************************/

    public function presupuesto_abm() {
        $crud = new grocery_CRUD();

        $crud->set_table('presupuesto');

        $crud->order_by('id_presupuesto','desc');

        $crud->columns('id_presupuesto', 'fecha', 'monto', 'descuento','id_cliente', 'tipo', 'estado', 'id_vendedor');

        $crud->display_as('id_cliente','Cliente')
            ->display_as('id_presupuesto','Número')
            ->display_as('id_estado','Estado')
            ->display_as('id_vendedor','Vendedor');

        $crud->set_subject('remiro');

        $crud->set_relation('id_cliente','cliente','{alias} - {nombre} {apellido}');
        $crud->set_relation('estado','estado_presupuesto','estado');
        $crud->set_relation('tipo','tipo','tipo');
        $crud->set_relation('id_vendedor','vendedor','vendedor');

        $_COOKIE['tabla']='remito';
        $_COOKIE['id']='id_remito';

        $crud->unset_read();
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();

        $crud->callback_after_insert(array($this, 'insert_log'));
        $crud->callback_after_update(array($this, 'update_log'));
        $crud->callback_delete(array($this,'delete_log'));
        $crud->callback_column('fecha',array($this,'_calcularatraso'));
        $crud->add_action('Detalle', '', '','icon-exit', array($this, 'buscar_presupuestos'));

        $output = $crud->render();

        $this->viewCrud($output);
    }

    function _calcularatraso($value, $row) {

        $config = $this->config_model->select(1);
        if($config > 0) {
            foreach ($config as $fila) {
                $dias_pago = $fila->dias_pago;
            }
        }

        $fecha = date('Y-m-d', strtotime($row->fecha));
        $nuevafecha = strtotime ( '+'.$dias_pago.' day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

        if ($nuevafecha < date('Y-m-d') && $row->estado == 1) {
            $datetime1 = date_create($fecha);
            $datetime2 = date_create(date('Y-m-d'));
            $interval = date_diff($datetime1, $datetime2);

            return '<label class="label label-danger">'.date('d-m-Y', strtotime($row->fecha)).'</label> <span class="badge">'.$interval->format('%R%a días').'</span>';
        } else {
            return date('d-m-Y', strtotime($row->fecha));
        }
    }

    function buscar_presupuestos($id) {
        return site_url('/presupuestos/detalle_presupuesto').'/'.$id;
    }

    /**********************************************************************************
     **********************************************************************************
     *
     * 				Muestra el detalle del presupuesto
     *
     * ********************************************************************************
     **********************************************************************************/

    function detalle_presupuesto($id, $llamada = NULL) {
        $_presupuesto = $this->presupuestos_model->select($id);
        if($_presupuesto){
            if($this->input->post('interes_tipo')){

                foreach ($_presupuesto as $_row) {
                    $presupuesto_monto = $_row->monto;
                }

                if ($this->input->post('interes_tipo') == 'porcentaje') {
                    $interes_monto = $presupuesto_monto * $this->input->post('interse_monto') / 100 ;
                } else {
                    $interes_monto = $this->input->post('interse_monto');
                }

                if ($this->input->post('descripcion_monto') == "") {
                    $descripcion = date('d-m-Y').' Intereses generados por atraso';
                } else {
                    $descripcion = date('d-m-Y').' '.$this->input->post('descripcion_monto');
                }

                $interes = array(
                    'id_presupuesto'	=> $id,
                    'id_tipo'			=> 1,
                    'monto'				=> $interes_monto,
                    'descripcion'		=> $descripcion,
                    'fecha'				=> date('Y-m-d H:i:s'),
                    'id_usuario'		=> 1, //agregar nombre de usuario
                );

                $this->intereses_model->insert($interes);

                $_presupuesto = array(
                    'monto'				=> $presupuesto_monto + $interes_monto,
                );

                $this->presupuestos_model->update($_presupuesto, $id);
            }

            $condicion = array(
                'id_presupuesto' => $id
            );

            $db['texto']				= getTexto();
            $db['presupuestos']			= $this->presupuestos_model->select($id);
            $db['detalle_presupuesto']	= $this->renglon_presupuesto_model->getDetalle($id);
            $db['interes_presupuesto']	= $this->intereses_model->select($condicion);
            $db['impresiones']			= $this->config_impresion_model->select(2);
            $db['devoluciones']			= $this->devoluciones_model->select($condicion);
            $db['anulaciones']			= $this->anulaciones_model->select($condicion);

            if($llamada == NULL) {
                $db['llamada'] = FALSE;
            }else {
                $db['llamada'] = TRUE;
                $this->load->view('head.php',$db);
                $this->load->view('presupuestos/detalle_presupuestos.php');
            }

            $this->view($db, 'presupuestos/detalle_presupuestos.php');
        } else {
            redirect('/','refresh');
        }
    }

}