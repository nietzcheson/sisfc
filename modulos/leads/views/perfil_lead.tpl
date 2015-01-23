

		<div class="cover-relative col-md-6">
			<div class="cover-relative-content">

				{$prospecto}


			</div>
		</div>

		<div class="cover-relative col-md-6">
			<div class="cover-relative-content">
			</div>
		</div>

		<div class="cover-relative col-md-6">
			<div class="cover-relative-content">
				<form role="form" method="POST" action="">
				<input type="hidden" name="crear3" value="1" />
				<fieldset>
					<table class="table">
						<tbody>
							<tr>
								<td class="form-group col-md-4">
									<p>Comunicación vía:</p>
								</td>
								<td class"form-group col-md-8">
									<div class="bloque text-center">
										<div class="btn-group text-center" data-toggle="buttons">
												{if isset($datos4)}
													<label class="btn btn-{if $datos4.telefonica_lead==1}primary active{else}default{/if}" id="comuni_1" >
														<input type="checkbox" name="telefonica_lead" value="1" {if $datos4.telefonica_lead==1} checked {/if} > Telefónica
													</label>
													<label class="btn btn-{if $datos4.personal_lead==1}primary active{else}default{/if}" id="comuni_2">
														<input type="checkbox" name="personal_lead" value="1" {if $datos4.personal_lead==1} checked {/if}> Personal
													</label>
													<label class="btn btn-{if $datos4.email_lead==1}primary active{else}default{/if}" id="comuni_3">
														<input type="checkbox" name="email_lead" value="1" {if $datos4.email_lead==1} checked {/if}> Email
													</label>
												{else}
													<label class="btn btn-default" id="comuni_1" >
													<input type="checkbox" name="telefonica_lead" value="telefono" > Telefónica
												</label>
												<label class="btn btn-default" id="comuni_2">
													<input type="checkbox" name="personal_lead" value="personal" > Personal
												</label>
												<label class="btn btn-default" id="comuni_3">
													<input type="checkbox" name="email_lead" value="email" > Email
												</label>
												{/if}
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="form-group col-md-4">
									<p>Información general</p>
								</td>
								<td class"form-group col-md-8">
									<div class="bloque text-center">
										<textarea rows="6" cols="40" name="informacion_general" class="form-control input-lg"> {if isset($datos4)} {$datos4.informacion_general}{/if}</textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td class="form-group col-md-4">
									<p>
										Compromiso del ACE
									</p>
								</td>
								<td class"form-group col-md-8">
									<div class="bloque text-center">
										<textarea rows="6" cols="40" name="compromiso_ace" class="form-control input-lg">{if isset($datos4)} {$datos4.compromiso_ace}{/if}</textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td class="form-group col-md-4">
									<p>Compromiso del ETA</p>
								</td>
								<td class"form-group col-md-8">
									<div class="bloque text-center">
										<textarea rows="6" cols="40" name="compromiso_lead" class="form-control input-lg">{if isset($datos4)} {$datos4.compromiso_lead}{/if}</textarea>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				<button type="submit" class="btn btn-{$_layoutParams.btn_create}">Guardar</button>
				</fieldset>
			</form>
			</div>
		</div>
