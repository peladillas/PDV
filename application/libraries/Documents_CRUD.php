<?php
class Documents_CRUD {
    private $headTable = '';
    private $headIdTable = '';
    private $headEntity = '';
    private $headIdEntity = '';
	
	private $headDate = 'fecha';
   	private $headTotal = 'monto';
    private $headDiscount = 'descuento';
    private $headInteres = 'interes';
    private $headMethodPayment = 'id_tipo';
    private $headComPrivate = 'com_privado';
    private $headComPublic = 'com_publico';
    private $headResponsable = 'id_vendedor';
    private $detailTable = '';
    private $detailItem = 'articulo';
    private $detailIdItem = 'id_articulo';
    private $detailQuantity = 'cantidad';
    private $detailPrice = 'precio';
    private $detailTotal = 'total';
    private $btnSelect = 'seleccionar';
    private $btnSelectDetail = 'cargar';
    private $btnSafe = 'guardar';
    private $headEntityController = 'Clientes';
    private $headDetailController = 'Articulos';

	private $divDetail = 'presupuesto_detalle';
    private $stockInOut = 'in';
    private $html;
    function __construct() {
        $this->set_default_Model();
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Declaracion del modelo de la libreria
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    protected function set_default_Model() {
        $ci = &get_instance();
        $ci->load->model('documents_CRUD_Model');
        $this->basic_model = new documents_CRUD_Model();
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Cargas iniciales. Obligatorias
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function set_table_head($tableName, $headIdTable){
        $this->headTable = $tableName;
        $this->headIdTable = $headIdTable;
    }
	
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Edentidad que esta relacionada con el documento, 
 * puede ser cliente, proveedor o nulo (caso de moviemientos de stock)
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
    public function set_entity($fieldName, $relatedTable){
        $this->headIdEntity = $fieldName;
        $this->headEntity = $relatedTable;
        if($this->headEntity != 'cliente') {
            $this->headEntityController = 'Clientes';
        }
    }
	
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
        Estos campos si se nombran de otra manera, 
 * 	con estos metodos permite cambiar los que vienen por default
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function set_head_date($date){
        $this->headDate = $date;
    }
    public function set_head_total($total){
        $this->headTotal = $total;
    }
    public function set_detail_item($item){
        $this->detailItem = $item;
    }
    public function set_detail_id_item($idItem){
        $this->detailIdItem = $idItem;
    }
    public function set_detail_quantity($quantity){
        $this->detailQuantity = $quantity;
    }
    public function set_detail_price($price){
        $this->detailPrice = $price;
    }
    public function set_detail_total($total){
        $this->detailTotal = $total;
    }
    public function set_btn_select($btn){
        $this->btnSelect = $btn;
    }
    public function set_btn_select_detail($btn){
        $this->btnSelectDetail = $btn;
    }
    public function set_btn_safe($btn){
        $this->btnSafe = $btn;
    }
    public function set_stock($stock){
        $this->stockInOut = $stock;
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
       Carga del detalle del comprobante, esto es obligatorio
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/
	
	public function set_table_detail($tableName){
		$this->detailTable = $tableName;
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
       Function para devolver el html con el formulario
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

	public function get_form(){
	    $requiredFields = TRUE;
	    if($this->headTable == ''){
            $this->html = 'Se debe cargar la variable headTable';
            $requiredFields = FALSE;
        }
        if($this->headIdTable == ''){
            $this->html = 'Se debe cargar la variable headIdTable';
            $requiredFields = FALSE;
        }
        if($this->headEntity == ''){
            $this->html = 'Se debe cargar la variable headEntity';
            $requiredFields = FALSE;
        }
        if($this->headIdEntity == ''){
            $this->html = 'Se debe cargar la variable headIdEntity';
            $requiredFields = FALSE;
        }
        if($this->detailTable == ''){
            $this->html = 'Se debe cargar la variable detailTable';
            $requiredFields = FALSE;
        }
        if($requiredFields){
            $this->set_html_heat();
        }
		return $this->html;
	}

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
       Function para devolver el html con el formulario
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function set_html_heat(){
    	$this->html .= setJs('main/js/Documents_CRUD.js');
    	
		$this->html .= '<div id="form-heading">';
        $this->html .= setFormGroup($this->headEntity, '', 'autocomplete="off"');
        $this->html .= setFormGroup($this->headDate,  date('d-m-Y'), 'disabled');
        $this->html .= setButton(lang($this->btnSelect), $this->btnSelect);
        $this->html .= setFormGroup($this->headTotal, 0, 'disabled');
        $this->html .= setButton(lang($this->btnSafe), $this->btnSafe);
        $this->html .= setHiddenInput($this->headIdEntity);
		$this->html .= '<hr>';

        $this->html .= '</div>';
		if(TRUE){
            $this->html .= '<div id="form-payment">';
            $this->html .= $this->getFormasPago();
            $this->html .= '</div>';
        }

		$this->html .= '<div id="form-detail" class="hide">';
		$this->html .= setFormGroup($this->detailItem, '', 'autocomplete="off"');
		$this->html .= setFormGroup($this->detailQuantity);
		$this->html .= setFormGroup($this->detailPrice);
		$this->html .= setFormGroup($this->detailTotal);
		$this->html .= setButton(lang($this->btnSelectDetail), $this->btnSelectDetail);
		$this->html .= setHiddenInput($this->detailIdItem);
		$this->html .= '</div>';
		
		$this->html .= '<div id="'.$this->divDetail.'" ></div>';
        $this->defineDivs();	
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
       Function variables para el js
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function defineDivs(){
        $this->html .= '<script>';
        // HEAD //
        /* Inputs */
        $this->html .= 'var inputHeadEntity = $("#'.$this->headEntity.'");';
        $this->html .= 'var inputHeadIdEntity = $("#'.$this->headIdEntity.'");';
        $this->html .= 'var inputHeadDate = $("#'.$this->headDate.'");';
        $this->html .= 'var inputHeadTotal = $("#'.$this->headTotal.'");';
        /* Buttons */
        $this->html .= 'var btnSelect = $("#'.$this->btnSelect.'");';
        $this->html .= 'var btnSave = $("#'.$this->btnSafe.'");';
        /* Data */
        $this->html .= 'var headTable = "'.$this->headTable.'";';
        $this->html .= 'var headIdTable = "'.$this->headIdTable.'";';
        $this->html .= 'var headIdEntity = "'.$this->headIdEntity.'";';
        $this->html .= 'var headDate = "'.$this->headDate.'";';
        $this->html .= 'var headTotal = "'.$this->headTotal.'";';
        // DETAIL //
        /* Inputs */
        $this->html .= 'var inputDetailItem =$("#'.$this->detailItem.'");';
        $this->html .= 'var inputIdDetail =$("#'.$this->detailIdItem.'");';
        $this->html .= 'var inputDetailPrice =$("#'.$this->detailPrice.'");';
        $this->html .= 'var inputDetailQuantity =$("#'.$this->detailQuantity.'");';
        $this->html .= 'var inputDetailTotal =$("#'.$this->detailTotal.'");';
        /* Buttons */
        $this->html .= 'var btnSelecctDetail =$("#'.$this->btnSelectDetail.'");';
        /* Data */
		$this->html .= 'var detailTable = "'.$this->detailTable.'";';
		$this->html .= 'var detailIdItem = "'.$this->detailIdItem.'";';
		$this->html .= 'var detailQuantity = "'.$this->detailQuantity.'";';
		$this->html .= 'var detailPrice = "'.$this->detailPrice.'";';
		$this->html .= 'var detailTotal = "'.$this->detailTotal.'";';
        // EXTRAS //
        $this->html .= 'var divDetail = $("#'.$this->divDetail.'");';
        $this->html .= 'var entity = "'.$this->headEntityController.'"; ';
        $this->html .= 'var detail = "'.$this->headDetailController.'"; ';
        $this->html .= 'var functionInsert = "/'.$this->headTable.'s/insert";';
        $this->html .= 'var stockInOut = "'.$this->stockInOut.'"; ';
		
        $this->html .= '</script>';
    }

/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
       Funciones para armar los html de los formularios
-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function getFormasPago($formaPago = NULL){

        $paymentMethod = array(
            FORMAS_PAGOS::EFECTIVO => lang('efectivo'),
            FORMAS_PAGOS::CHEQUE => lang('cheque'),
            FORMAS_PAGOS::TARJETA => lang('tarjeta'),
            FORMAS_PAGOS::CTA_CTE => lang('cta_cte'),
        );

        $quotaQuantity = array(
            1 => 1,
            3 => 3,
            6 => 6,
            9 => 9,
            12 => 12,
        );

        $quotas = array();
        for ($i = 1; $i <= 31; $i++) {
            $quotas[$i] = $i;
        }

        $html = setSelectGroup('forma_pago', $paymentMethod, FORMAS_PAGOS::EFECTIVO);
        $html .= '<div class="paymentData hide" id="divCheck">';
        $html .= setFormGroup('inputCheck');
        $html .= '</div>';
        $html .= '<div class="paymentData hide" id="divQuota">';
        $html .= setSelectGroup('quotaQuantity', $quotaQuantity, 1);
        $html .= setSelectGroup('quotaStart', $quotas, 1);
        $html .= setSelectGroup('quotaEnd', $quotas, 2);
        $html .= setFormGroup('quotaInterest');
        $html .= setFormGroup('quotaAmount');
        $html .= '</div>';

        return  $html;
    }
}