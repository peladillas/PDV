<script>
	$(document).ready(function() {
    $('#get100').DataTable();
	
	
} );
</script>
<?php startContent('top');?>
				

<table id="get100" class="table table-hover" style="font-size: 13px">
    <thead>
        <tr>
            <th>N°</th>
            <th>Cant</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
<?php
if($articulos)
{$numero=1;
    foreach ($articulos as $row)
    {
        echo "<tr>";
        echo "<td>".$numero."</td>";
        echo "<td>".$row->cantidad."</td>";
        echo "<td><a title='Ver detalle' href='".base_url()."index.php/articulos/articulo_abm/read/".$row->id_articulo."'>";
        echo $row->descripcion."</a></td>";
        echo "</tr>";
        $numero++;
    }
}
?>
    </tbody>
</table>

<?php echo endContent();?>
			
			
