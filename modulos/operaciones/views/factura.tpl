</div>

{if count($facturas)==0}
  {include file=$formFactura}
{else}

  {if $activas==0}
    {include file=$formFactura}
  {/if}
<h1></h1>
  {foreach from=$facturas item=factura}
    {if $factura.estado==1}
      <div class="panel panel-default col-md-12">
        <div class="panel-body">
          <div class="page-header">
            <h1>Reporte de facturación</h1>
          </div>

          <table class="table table-bordered">
            <tbody>
              <tr>
                <td colspan="2" class="text-right">
                  <h4><small>Fecha de facturación: {$factura.fecha_facturacion} | <span class="label label-success">Activada</span> | <strong>{$factura.usuario_facturacion}</strong></small> </h4>
                </td>
              </tr>
              <tr>
                <td class="col-md-6">
                  <p class="lead">
                    <strong>Tipo facturación: </strong>
                    {$factura.nombre}
                  </p>
                </td>
                <td>
                  <p class="lead">
                    <strong>Razón social: </strong>
                    {$factura.razon_social}
                  </p>
                </td>
              </tr>
              <tr>
                <td class="col-md-6">
                  <p class="lead">
                    <strong>Moneda operación: </strong>
                    {$factura.divisa_referencia} | {$factura.valor_divisa_referencia}
                  </p>
                </td>
                <td>
                  <p class="lead">
                    <strong>Moneda facturación: </strong>
                    {$factura.divisa_facturacion}
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <p class="lead">
                    <strong>Importe: </strong>
                    {$factura.signo_divisa} {number_format($factura.subtotal_factura)|default:''} ({$factura.divisa_facturacion|lower})
                  </p>
                  <p class="lead">
                    <strong>IVA: </strong>
                    {$factura.signo_divisa} {number_format($factura.iva_factura)|default:''} ({$factura.divisa_facturacion|lower})
                  </p>
                  <p class="lead">
                    <strong>Total: </strong>
                    {$factura.signo_divisa} {number_format($factura.total_factura)|default:''} ({$factura.divisa_facturacion|lower})
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <p class="lead">
                    <strong>Comentarios: </strong>
                    {$factura.comentarios_factura}
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-right">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default">XML</button>
                    <button type="button" class="btn btn-default">PDF</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                      Enviar correo
                      <span class="glyphicon glyphicon-send"></span>
                    </button>
                    <button type="button" class="btn btn-danger" id="b_cancelar">
                      Cancelar
                      <span class="glyphicon glyphicon-remove-sign"></span>
                      </button>
                  </div>

                  <form id="f_cancelar" action="{$_layoutParams.root}operaciones/cancelarFactura" method="post">
                    <input type="hidden" name="cancelar" value="1">
                    <input type="hidden" name="referencia" value="{$referencia}">
                    <input type="hidden" name="cotizacion" value="{$cotizacion}">
                    <input type="hidden" name="comprobante" value="{$factura.comprobante}">
                  </form>

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    {/if}

  {/foreach}

  {foreach from=$facturas item=factura}

    {if $factura.estado==0}
      <div class="panel panel-default col-md-6 ">
        <div class="panel-body">
          <div class="text-right">
            <strong><span class="label label-default">Facturado:</span></strong> {$factura.fecha_facturacion} | <span class="label label-danger">Cancelado:</span> {$factura.fecha_cancelacion}</strong>
          </div>
          <p>
            Tipo de facturación: {$factura.nombre}
          </p>
          <p>
            Razón social: {$factura.razon_social}
          </p>
          <p>
            <strong>{$factura.comentarios_factura}</strong>
          </p>
          <p>
            Moneda operación: {$factura.divisa_referencia} | {$factura.valor_divisa_referencia}
          </p>
          <p>
            Moneda facturación: {$factura.divisa_facturacion}
          </p>
          <p>
            Importe: {$factura.signo_divisa} {number_format($factura.subtotal_factura)|default:''} ({$factura.divisa_facturacion|lower})
          </p>
          <p>
            IVA: {$factura.signo_divisa} {number_format($factura.iva_factura)|default:''} ({$factura.divisa_facturacion|lower})
          </p>
          <p>
            Total: {$factura.signo_divisa} {number_format($factura.total_factura)|default:''} ({$factura.divisa_facturacion|lower})
          </p>
          <p>
            Quién factura: {$factura.usuario_facturacion}
          </p>
          <p>
            Quién cancela: {$factura.usuario_cancelacion}
          </p>
        </div>
      </div>
    {/if}

  {/foreach}

{/if}

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Envío de documentos PDF y XML a los correos indicados</h4>
      </div>
      <div class="modal-body">
        <div id="wrap-mails">
          <div class="row">
            <div class="col-lg-12" id="mail-rs">
              <label for="">Correo de la Razón social</label>
              <div class="input-group">
                <input type="text" class="form-control" value="cristianangulonova@gmail.com" name="emails">
                <span class="input-group-btn delete-mail">
                  <button id="delete-mail-rs" class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                </span>
              </div>
            </div>
          </div>
        </div>

      <h1></h1>
      <button type="button" class="btn btn-default" id="nuevo-mail">
        Nuevo eMail
        <span class="glyphicon glyphicon-plus"></span>
      </button>

      <form id="enviarMailFactura" action="{$_layoutParams.root}operaciones/enviarMailFactura" method="post">
        <input type="hidden" name="enviar" value="1">
        <input type="hidden" name="ruta" value="factura">
        <input type="hidden" name="comprobante" value="{$factura.comprobante}">
        <input type="hidden" name="referencia" value="{$referencia}">
        <input type="hidden" name="cotizacion" value="{$cotizacion}">
        <input type="hidden" name="correos">
      </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="enviar_pdfXML">Enviar</button>
      </div>
    </div>
  </div>
</div>


<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cancelar">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Razón para cancelar</h4>
      </div>
      <div class="modal-body">
        <form id="form_id" action="index.html" method="post">
          <textarea class="form-control input-lg" "Name" rows="8" cols="40"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger">Cancelar</button>
      </div>
    </div>
  </div>
</div>
