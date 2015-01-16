<div id="rm_general">
	<div class="row" id="rm_general">
	    <div class="col-md-1">
	      <span class="col-md-2 lead">Fecha</span>
	    </div>
	    <div class="col-md-2">
	      <div class="input-group">
	        <a class="btn btn-default input-group-addon" href="{$_layoutParams.root}sdt/rm/{$fecha}/rest">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	        </a>
	          <input type="text" class="form-control datepicker" id="searchdate" name="vigencia" placeholder="Buscar Fecha" value="{$fecha}">
	        <a class="btn btn-default input-group-addon" href="{$_layoutParams.root}sdt/rm/{$fecha}/add">
	          <span class="glyphicon glyphicon-chevron-right"></span>
	        </a>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <span class="col-md-2 lead">RM</span>
	      <span class="col-md-2 lead"></span>
	    </div>
	    <div class="col-md-6">
	      <button type="button" class="btn btn-default" id="btn_mail" >
	        <span class="glyphicon glyphicon-tags" ></span>
	      </button>
	      <button type="button" class="btn btn-default" id="btn_mail" >
	        <span class="glyphicon glyphicon-envelope" ></span>
	      </button>
	      <button type="button" class="btn btn-default" id="btn_help" >
	        <span class="glyphicon glyphicon-exclamation-sign" ></span>
	      </button>
	      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#searchRM" id="bt-searchRM" data-toggle="tooltip" title="Nuevo!" data-placement="bottom">
	        <span class="glyphicon glyphicon-search" ></span>
	      </button>
	      <span class="label label-success" id="conexion">Online</span>
	    </div>
	  </div>
	</div>
	<div id="rm_contenido">
		
	</div>
<div id="checklist">
	<button type="button" class="btn btn-default" id="ch">
		Llamar checklist
	</button>
</div>
<div id="hoja_diario">
hoja de trabajo diario
</div>