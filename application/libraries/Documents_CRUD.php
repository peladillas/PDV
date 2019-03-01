<?php
class Documents_CRUD {
    private $headTable = 'presupuesto';
    private $headIdTable = 'id_presupuesto';
    private $headDate = 'fecha';
    private $headEntity = 'cliente';
    private $headIdEntity = 'id_cliente';


    private $headTotal = 'monto';
    private $headDiscount = 'descuento';
    private $headInteres = 'interes';
    private $headMethodPayment = 'id_tipo';

    private $headComPrivate = 'com_privado';
    private $headComPublic = 'com_publico';

    private $headResponsable = 'id_vendedor';

    private $detailTable = 'reglon_presupuesto';
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

    private $html;

    function __construct() {
        $this->set_default_Model();
    }


    public function set_table_head($tableName, $headIdTable){
        $this->headTable = $tableName;
        $this->headIdTable = $headIdTable;
    }

    public function set_entity($fieldName, $relatedTable){
        $this->headIdEntity = $fieldName;
        $this->headEntity = $relatedTable;

        if($this->headEntity == 'cliente') {
            $this->headEntityController = 'Clientes';
        }
    }

    public function set_date($date){
        $this->headDate = $date;
    }

    public function set_total($total){
        $this->headTotal = $total;
    }

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


    public function set_html_heat(){
        $this->html->head = $this->setFormGroup($this->headEntity, '', 'autocomplete="off"');
        $this->html->head .= $this->setFormGroup($this->headDate,  date('d-m-Y'), 'disabled');
        $this->html->head .= $this->setButton($this->btnSelect, $this->btnSelect);
        $this->html->head .= $this->setFormGroup($this->headTotal, 0, 'disabled');
        $this->html->head .= $this->setButton($this->btnSafe, $this->headTotal);
        $this->html->head .= $this->setHiddenInput($this->headIdEntity);

        $this->defineDivs();

        return $this->html->head;
    }


    public function defineDivs(){

        $this->html->head .= '<script>';

        /* Head */
        $this->html->head .= 'var inputHeadEntity = $("#'.$this->headEntity.'");';
        $this->html->head .= 'var inputHeadIdEntity = $("#'.$this->headIdEntity.'");';
        $this->html->head .= 'var inputHeadDate = $("#'.$this->headDate.'");';
        $this->html->head .= 'var inputHeadTotal = $("#'.$this->headTotal.'");';

        $this->html->head .= 'var btnSelect = $("#'.$this->btnSelect.'");';
        $this->html->head .= 'var btnSave = $("#'.$this->btnSafe.'");';
        $this->html->head .= 'var functionInsert = "'.$this->headTable.'/insert";';

        /* Detail */
        $this->html->head .= 'var inputDetailItem =$("#'.$this->detailItem.'");';
        $this->html->head .= 'var inputIdDetailItem =$("#'.$this->detailIdItem.'");';
        $this->html->head .= 'var inputPrice =$("#'.$this->detailPrice.'");';
        $this->html->head .= 'var inputDetailQuantity =$("#'.$this->detailQuantity.'");';
        $this->html->head .= 'var inputTotalLine =$("#'.$this->detailTotal.'");';

        $this->html->head .= 'var btnSelecctLine =$("#'.$this->btnSelectDetail.'");';

        $this->html->head .= 'var divDetail = $("#note-detail");';
        $this->html->head .= 'var Entity = "'.$this->headEntityController.'"; ';
        $this->html->head .= 'var Detail = "'.$this->headDetailController.'"; ';

        $this->html->head .= '</script>';

        $this->html->head = $this->setJs('main/js/Documents_CRUD.js');
    }

    protected function set_default_Model() {
        $ci = &get_instance();
        $ci->load->model('documents_CRUD_Model');

        $this->basic_model = new documents_CRUD_Model();
    }
}
