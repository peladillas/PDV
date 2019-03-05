<?php
class Documents_CRUD {
    private $headTable;
    private $headIdTable;
    private $headEntity;
    private $headIdEntity;
	
	private $headDate = 'fecha';
   	private $headTotal = 'monto';
    private $headDiscount = 'descuento';
    private $headInteres = 'interes';
    private $headMethodPayment = 'id_tipo';

    private $headComPrivate = 'com_privado';
    private $headComPublic = 'com_publico';

    private $headResponsable = 'id_vendedor';

    private $detailTable;
    private $detailItem = 'articulo';
    private $detailIdItem = 'id_articulo';
    private $detailQuantity = 'cantidad';
    private $detailPrice = 'precio';
    private $detailTotal = 'total';
    private $detailState = 'estado';

    private $btnSelect = 'seleccionar';
    private $btnSelectDetail = 'cargar';
    private $btnSafe = 'guardar';


    private $headEntityController = 'Clientes';
    private $headDetailController = 'Articulos';
	
	private $divDetail = 'presupuesto_detalle';
    private $html;
	private $html_detail;

    function __construct() {
        $this->set_default_Model();
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

        if($this->headEntity == 'cliente') {
            $this->headEntityController = 'Clientes';
        }
    }
	
/*---------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

        Estos campos si se nombran de otra manera, 
 * 	con estos metodos permite cambiar los que vienen por default

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function set_date($date){
        $this->headDate = $date;
    }

    public function set_total($total){
        $this->headTotal = $total;
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

       Carga el form gruop de un imput

-----------------------------------------------------------------------------------
---------------------------------------------------------------------------------*/

    public function setFormGroup($name, $value = NULL, $tags = NULL){
        $value = ($value == NULL ? '' : $value);

        if(is_array($tags)) {
            $htmlTags = '';
            foreach ($tags as $tag) {
                $htmlTags .= ' '.$tag;
            }
        } else {
            $htmlTags = $tags;
        }

        $html = '<div class="form-group">';
        $html .= '<label for="'.$name.'">'.lang($name).'</label>';
        $html .= '<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$value.'" '.$htmlTags.'>';
        $html .= '</div>';

        return $html;
    }

    function setButton($value, $id){
        $html = '<button type="button" id="'.$id.'" name="'.$id.'" class="btn btn-default">'.$value.'</button>';

        return $html;
    }

    function setHiddenInput($id, $value = NULL){
        $html = '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'"/>';

        return $html;
    }

    public function  setJs($js){
        $src = base_url().'libraries/'.$js;

        return '<script src="'.$src.'" charset="utf-8" type="text/javascript"></script>';
    }

	public function get_head(){
		$this->set_html_heat();
		return $this->html;
	}


    public function set_html_heat(){
    	$this->html .= $this->setJs('main/js/Documents_CRUD.js');
    	
		$this->html .= '<div id="form-heading">';
        $this->html .= $this->setFormGroup($this->headEntity, '', 'autocomplete="off"');
        $this->html .= $this->setFormGroup($this->headDate,  date('d-m-Y'), 'disabled');
        $this->html .= $this->setButton($this->btnSelect, $this->btnSelect);
        $this->html .= $this->setFormGroup($this->headTotal, 0, 'disabled');
        $this->html .= $this->setButton($this->btnSafe, $this->btnSafe);
        $this->html .= $this->setHiddenInput($this->headIdEntity);
		$this->html .= '</div><hr>';
		
		$this->html .= '<div id="form-detail" class="hide">';
		$this->html .= $this->setFormGroup($this->detailItem, '', 'autocomplete="off"');
		$this->html .= $this->setFormGroup($this->detailQuantity);
		$this->html .= $this->setFormGroup($this->detailPrice);
		$this->html .= $this->setFormGroup($this->detailTotal);
		$this->html .= $this->setButton($this->btnSelectDetail, $this->btnSelectDetail);
		$this->html .= $this->setHiddenInput($this->detailIdItem);
		$this->html .= '</div>';
		
		$this->html .= '<div id="'.$this->divDetail.'" ></div>';

        $this->defineDivs();	
    }


    public function defineDivs(){
        $this->html .= '<script>';

        /* Head */
        $this->html .= 'var inputHeadEntity = $("#'.$this->headEntity.'");';
        $this->html .= 'var inputHeadIdEntity = $("#'.$this->headIdEntity.'");';
        $this->html .= 'var inputHeadDate = $("#'.$this->headDate.'");';
        $this->html .= 'var inputHeadTotal = $("#'.$this->headTotal.'");';

        $this->html .= 'var btnSelect = $("#'.$this->btnSelect.'");';
        $this->html .= 'var btnSave = $("#'.$this->btnSafe.'");';
       

        /* Detail */
        $this->html .= 'var inputDetailItem =$("#'.$this->detailItem.'");';
        $this->html .= 'var inputIdDetail =$("#'.$this->detailIdItem.'");';
        $this->html .= 'var inputPrice =$("#'.$this->detailPrice.'");';
        $this->html .= 'var inputDetailQuantity =$("#'.$this->detailQuantity.'");';
        $this->html .= 'var inputTotalLine =$("#'.$this->detailTotal.'");';

        $this->html .= 'var btnSelecctLine =$("#'.$this->btnSelectDetail.'");';

        $this->html .= 'var divDetail = $("#'.$this->divDetail.'");';
        $this->html .= 'var Entity = "'.$this->headEntityController.'"; ';
        $this->html .= 'var Detail = "'.$this->headDetailController.'"; ';
		
		$this->html .= 'var functionInsert = "/'.$this->headTable.'s/insert";';
		$this->html .= 'var HeadTable = "'.$this->headTable.'";';
		$this->html .= 'var HeadIdEntity = "'.$this->headIdEntity.'";';
		$this->html .= 'var HeadDate = "'.$this->headDate.'";';
		$this->html .= 'var HeadTotal = "'.$this->headTotal.'";';
		
		
        $this->html .= '</script>';
    }

	public function get_html_detail(){
		$this->set_html_detail();
		return $this->html_detail;
	}


	public function set_html_detail(){
		$this->html_detail = $this->setFormGroup($this->detailItem, '', 'autocomplete="off"');
		$this->html_detail .= $this->setFormGroup($this->detailQuantity);
		$this->html_detail .= $this->setFormGroup($this->detailPrice);
		$this->html_detail .= $this->setFormGroup($this->detailTotal);
		$this->html_detail .= $this->setButton($this->btnSelectDetail, $this->btnSelectDetail);
		$this->html_detail .= $this->setHiddenInput($this->detailIdItem);
	}

    protected function set_default_Model() {
        $ci = &get_instance();
        $ci->load->model('documents_CRUD_Model');

        $this->basic_model = new documents_CRUD_Model();
    }
}
