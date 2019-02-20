<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>


<?php
echo startContent(lang('empresa_titulo'));

echo '<div id="printableArea">';

if($presupuestos) {
    echo "<table class='table table-hover'>";
    foreach ($presupuestos as $row) {
        foreach ($impresiones as $impresion) {
            $clientes	= $this->clientes_model->select($row->id_cliente);
            if($clientes) {
                foreach ($clientes as $row_cliente) {
                    $nombre = $row_cliente->nombre;
                    $apellido = $row_cliente->apellido;
                }
            }

            $_vendedor   = $this->vendedores_model->select($row->id_vendedor);

            if($_vendedor) {
                foreach ($_vendedor as $row_vendedor) {
                    $vendedor = $row_vendedor->vendedor;
                }
            } else {
               $vendedor = "";
            }


            $cabecera = $impresion->cabecera;
            $cabecera = str_replace("#presupuesto_nro#", $row->id_presupuesto, $cabecera);
            $cabecera = str_replace("#presupuesto_descuento#", $row->descuento, $cabecera);
            $cabecera = str_replace("#presupuesto_fecha#", dateFormat($row->fecha), $cabecera);
            $cabecera = str_replace("#presupuesto_monto#", $row->monto, $cabecera);
            $cabecera = str_replace("#vendedor#", $vendedor, $cabecera);

            if(isset($nombre)) {
                $cabecera = str_replace("#cliente_nombre#", $nombre, $cabecera);
            } else {
                $cabecera = str_replace("#cliente_nombre#", '', $cabecera);
            }

            if(isset($apellido)) {
                $cabecera = str_replace("#cliente_apellido#", $apellido, $cabecera);
            } else {
                $cabecera = str_replace("#cliente_apellido#", '', $cabecera);
            }

            $pie = $impresion->pie;
            echo $cabecera;

            $id_presupuesto = $row->id_presupuesto;
        }

        echo "<hr>";

        $total = 0;

        $thead = [
            lang('articulo'),
            lang('descripcion'),
            lang('cantidad'),
            lang('monto'),
            lang('total'),
        ];

        $html = startTable($thead);

        if($detalle_presupuesto) {
            foreach ($detalle_presupuesto as $row_detalle) {
                $precio = ($row_detalle->cantidad > 0 ? $row_detalle->precio/$row_detalle->cantidad : 0);
                $sub_total = $row_detalle->cantidad * $precio;
                $total = $total + $sub_total;

                $registro = [
                    "<a title='ver Articulo' class='btn btn-default btn-xs' href='".base_url()."index.php/articulos/articulo_abm/read/".$row_detalle->id_articulo."'>".$row_detalle->cod_proveedor."</a>",
                    $row_detalle->descripcion,
                    $row_detalle->cantidad,
                    moneyFormat($precio),
                    moneyFormat($sub_total),
                ];

                $html .= setTableContent($registro);
            }
        }

        if($interes_presupuesto) {
            foreach ($interes_presupuesto as $row_interes) {
                $total = $total + $row_interes->monto;

                $registro = [
                    "-",
                    $row_interes->descripcion,
                    "-",
                    "-",
                    moneyFormat($row_interes->monto),
                ];

                $html .= setTableContent($registro);
            }
        }

        $registro = [
            "",
            "",
            "",
            lang('total'),
            moneyFormat($total),
        ];

        $html .= setTableContent($registro);
        $html .= endTable();

        echo $html;
        echo "<hr>";
        echo $pie;
    }

    if($devoluciones) {
        $mensaje = lang('si_devolucion')." <a class='btn btn-warning'>Ver devolución</a>";
        echo setMensaje($mensaje, 'warning');
    }

    if($row->comentario != '') {
        if($row->com_publico == 1) {
            echo '<div class="well">Comentario: '.$row->comentario."</div></div>";
        } else {
            echo '</div><div class="well">Comentario Privado: '.$row->comentario."</div>";
        }
    } else {
        echo '</div>';
    }
} else {
    echo setMensaje(lang('no_registro'), 'success');
    echo '</div>';
}


if(!$llamada) {
    echo "<input type='button' class='btn btn-default' value='Volver a la lista' onclick='window.history.back()'>";
}

if($row->estado != 3) {
?>
    <button class="btn btn-default" type="button" onclick="printDiv('printableArea')"/>
        <i class="fa fa-print"></i> Imprimir
    </button>
    <?php

    if(!$llamada) {
        // Presupuesto pendiente de pago
        if($row->tipo == 2) {
        ?>
        <a href="<?php echo base_url().'index.php/devoluciones/generar/'.$id_presupuesto?>" class="btn btn-default"/>
            <i class="fa fa-thumbs-down"></i> Devolución
        </a>

        <a href="<?php echo base_url().'index.php/ventas/interes/'.$id_presupuesto?>" class="btn btn-default" data-toggle="modal" data-target="#interesModal"/>
            <i class="fa fa-angle-up"></i> Interes
        </a>
        <?php
        }

        // Presupuesto pagado
        if($row->tipo == 1) {
        ?>
            <a href="<?php echo base_url().'index.php/presupuestos/anular/'.$id_presupuesto?>" class="btn btn-default"/>
                <i class="fa fa-trash-o"></i> Anular
            </a>
        <?php
        }
    }
} else {
    if ($anulaciones) {
        foreach ($anulaciones as $row_a) {
            $mensaje  = "Nota de la anulación: ".$row_a->nota."<br>";
            $mensaje .= "Fecha de la anulación: ".dateFormat($row_a->fecha)."<br>";
        }

        echo setMensaje($mensaje, 'danger');
    }
}

echo '</div>';
echo endContent();

?>



<!-- Modal Interes -->

<div class="modal fade" id="interesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/ventas/detalle_presupuesto/<?php echo $id_presupuesto?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">Interes</h4>
      			</div>
      			
      			<div class="modal-body">
      				<div class="form-group">
						<label class="col-sm-2 control-label">Descripcion</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="descripcion_monto" placeholder="Descripcion">
						</div>
					</div>
      				
  					<div class="form-group">
    					<label class="col-sm-2 control-label">Tipo</label>
    					<div class="col-sm-10">
      						<select class="form-control" name="interes_tipo" required>
      							<option value="porcentaje">Porcentaje %</option>
      							<option value="valor">Valor $</option>
      						</select>
    					</div>
  					</div>
  					
					<div class="form-group">
						<label class="col-sm-2 control-label">Interes</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" name="interse_monto" placeholder="Interes" required>
						</div>
					</div>
				</div>
      
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        		<button type="submit" class="btn btn-primary">Guardar</button>
	      		</div>
      		</form>
		</div>
	</div>
</div>

