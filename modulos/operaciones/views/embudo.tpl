
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>

                </th>
                {if isset($empresas) && count($empresas)}
                    {foreach item=empresa from=$empresas}
                     <th class="text-center">
                        {$empresa.nombre_empresa}
                    </th>
                    {/foreach}
                    <th class="text-center">Total</th>
                    <th class="text-center">Porcentaje</th>
                {/if}
            </tr>
        </thead>
        <tbody>
            {if isset($statusReferencias) && count($statusReferencias)}
                {foreach item=st from=$statusReferencias}
                    <tr>
                        <th>{$st.estatus}</th>
                        {foreach item=cantidad from=$st.datos}
                        <td class="text-center {if $cantidad.cantidad == 0} valor-cero {/if}"><strong>{$cantidad.cantidad}</strong> | {number_format($cantidad.cantidad / $st.porcentaje*100, 2,'.', '')|default:''} %</td>
                        {/foreach}
                        <td class="text-center bg-info">{if $st.porcentaje !=0}<a href="{$_layoutParams.root}estatus/perfil_estatus/{$st.codigo_estatus}">{/if}{$st.porcentaje}{if $st.porcentaje !=0}</a>{/if}</td>
                        <td class="text-center">{number_format($st.porcentaje / $total*100, 2,'.', '')|default:''} %</td>

                    </tr>
                {/foreach}
                <tr class="bg-info">
                    <th colspan="5">Total de operaciones</th>
                    <td class="text-center bg-primary">{$total}</td>
                    <td></td>
                </tr>
            {/if}

        </tbody>
    </table>

    <div class="panel panel-default">
        <div class="panel-heading">Gráfica</div>
            <div class="panel-body">
            {if isset($statusReferencias) && count($statusReferencias)}
                {foreach item=st from=$statusReferencias}
                <div class="bar-border">
                    <div class="col-md-6">
                        {$st.estatus} <span class="title-porcentaje">{$st.porcentaje} | {number_format($st.porcentaje / $total*100, 2,'.', '')|default:''} %</span>
                    </div>
                    <div class="col-md-6">
                        <span class="bar-grafica" style="width: {$st.porcentaje / $total*100}%"></span>
                    </div>
                </div>
                {/foreach}
            {/if}
            </div>
    </div>
