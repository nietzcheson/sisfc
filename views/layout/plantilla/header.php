<!DOCTYPE html>
<?php ob_start();?>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php if(isset($this->titulo))echo $this->titulo;?></title>
		<link rel="stylesheet" href="<?php echo $layoutParams['ruta_bootstrap']?>css/bootstrap.css"/>
		<link rel="stylesheet" href="<?php echo $layoutParams['ruta_css']?>estilos.css"/>
		<script src="<?php echo $layoutParams['ruta_js']?>jQuery.js"></script>
		<script src="<?php echo $layoutParams['ruta_bootstrap']?>js/bootstrap.min.js"/></script>
		<script src="<?php echo $layoutParams['ruta_js']?>funciones.js"></script>

		<?php if(isset($layoutParams["js"]) && count(is_array($layoutParams["js"]))): ?>
			<?php for($i=0; $i < count($layoutParams["js"]); $i++):?>
				<script src="<?php echo $layoutParams['js'][$i];?>"></script>
			<?php endfor;?>
		<?php endif;?>
	</head>
	<body>

		<header id="header-principal">
			<a href="<?php echo BASE_URL; ?>"><?php echo APP_NAME;?></a>
		</header>
		<section>
			<div id="wrap-contenedor">
				<div id="contenedor">

					<nav id="nav-menu">
						<div class="btn-group-vertical">
							<?php if(isset($layoutParams["menu"])):?>
								<?php foreach($layoutParams["menu"] as $menu):?>
									<?php 
										if($item && $menu["id"]==$item){
											$item_style = "current";
										}else{
											$item_style = "";
										}
									?>
									<?php if(isset($menu["submenu"])):?>
										<div class="btn-group">

									    	<button id="btnGroupVerticalDrop1" type="button" class="btn btn-default dropdown-toggle <?php echo $item_style;?>" data-toggle="dropdown">
									          <?=$menu["titulo"]?>
									        	<span class="caret"></span>
									        </button>
									       
										        <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
										        	 <?php foreach($menu["submenu"] as $submenu):?>
										          <li><a href="<?php echo $submenu["enlace"]?>"><?php echo $submenu["titulo"]?></a></li>
										           <?php endforeach;?>
										        </ul>
									    </div>
									<?php else:?>
										<button type="button" class="btn btn-default"><a href="<?=$menu['enlace']?>"><?=$menu["titulo"]?></a></button>
									<?php endif;?>
					      		<?php endforeach;?>
					    	<?php endif;?>
					    </div>

						<!--<ul id="menu">
							<?php if(isset($layoutParams["menu"])):?>
								<?php foreach($layoutParams["menu"] as $menu):?>

									<?php 

										if($item && $menu["id"]==$item){
											$item_style = "current";
										}else{
											$item_style = "";
										}

									?>
									<li class="<?php echo $item_style;?>">
										<a class="nav-p" id="<?=$menu['id']?>" href="<?=$menu['enlace']?>">
											<?=$menu["titulo"]?>
										</a>
										<?php if(isset($menu["submenu"])):?>
										<ul class="submenu">
											<?php foreach($menu["submenu"] as $submenu):?>
											<li>
												<a href=""><?php echo $submenu["titulo"]?></a>
											</li>
											<?php endforeach;?>
										</ul>
										<?php endif;?>
									</li>
								<?php endforeach;?>
							<?php endif;?>
						</ul>-->
					</nav>

					<div id="wrap-contenido">
						
							<?php if(isset($this->error)):?>
							<div class="alert alert-warning fade in">
							    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							    <strong><span class="glyphicon glyphicon-warning-sign"></span></strong> <?php echo $this->error;?>
						    </div>
							<?php endif;?>

							<?php if(isset($this->mensaje)):?>
								<div id="mensaje">
									<?php echo $this->mensaje;?>
								</div>
							<?php endif;?>




		<!--<header>
			
		</header>-->

		<!--<div id="wrap">
			<div id="wrap-template">
				<nav>
					<ul id="menu">
						<?php if(isset($layoutParams["menu"])):?>
							<?php foreach($layoutParams["menu"] as $menu):?>

								<?php 

									if($item && $menu["id"]==$item){
										$item_style = "current";
									}else{
										$item_style = "";
									}

								?>
								<li class="<?php echo $item_style;?>">
									<a id="<?=$menu['id']?>" href="<?=$menu['enlace']?>">
										<?=$menu["titulo"]?>
									</a>
								</li>
							<?php endforeach;?>
						<?php endif;?>
					</ul>
				</nav>
				

				
			
			
				

		<!--<h1><?php echo APP_NAME;?></h1>-->



