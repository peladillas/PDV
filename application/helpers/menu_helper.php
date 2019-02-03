<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	
	function buscarReservas(){
		$CI =& get_instance();
		$CI->load->model('reservas_model');
		$CI->load->model('estados_reserva_model');
						
		$db['cant_reservas']=$CI->reservas_model->getCantNuevas();
		
		if($db['cant_reservas']>0){
			$db['reservas']=$CI->reservas_model->getNuevas();
			$db['estados_reserva']=$CI->estados_reserva_model->getEstados();
		}
				
		return $db;		
	}	
	
	function buscarMensajes(){
		$CI =& get_instance();
		$CI->load->model('mensajes_model');
		$CI->load->model('estados_mensaje_model');
		
		$db['cant_mensajes']=$CI->mensajes_model->getCantNuevos();
		
		if($db['cant_mensajes']>0){
			$db['mensajes']=$CI->mensajes_model->getNuevos();
			$db['estados_mensaje']=$CI->estados_mensaje_model->getEstados();
		}
		
		return $db;
	}
	
	function getTexto(){
		$CI =& get_instance();
		include_once('texto.php');
		
		return $texto;
	}
	
	function setMensaje($mensaje, $tipo=NULL)
	{
		if($tipo==NULL)
		{
			$tipo='info';
		}
		
		$return =	"<div class='alert alert-$tipo alert-dismissible' role='alert'>
				 		<button type='button' class='close' data-dismiss='alert'>
					 		<span aria-hidden='true'>&times;</span><span class='sr-only'>
					 			Cerrar
					 		</span>
					 	</button>
				  		$mensaje
					</div>";
		
		return $return;
	}
	
	function getRealIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){		
			$ip=$_SERVER['HTTP_CLIENT_IP'];				
		}

		
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){				
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];			
		}
		
		if (!empty($_SERVER['REMOTE_ADDR'])){
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
	
	
	
	

