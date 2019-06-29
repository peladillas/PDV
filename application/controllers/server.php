<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server extends MY_Controller {

    protected $path = 'clientes/';

	public function __construct() {
		parent::__construct($this->path);


	}

  function datetime() {

    $msg = date("d-m-y, H:i");
    echo $msg;

	}

}
