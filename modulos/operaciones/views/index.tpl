
          <ul class="nav nav-tabs">
            {if isset($datos)}
              {foreach item=dato from=$datos}
                {if $identifica == $dato.id_u_empresa}
                  <li class="active"><a href="{$_layoutParams.root}operaciones/index/{$dato.id_u_empresa}">{$dato.nombre_empresa}</a></li>
                {else}
                <li><a href="{$_layoutParams.root}operaciones/index/{$dato.id_u_empresa}">{$dato.nombre_empresa}</a></li>
                {/if}
              {/foreach}
            </ul>

            {/if}




            {$panel_operaciones}
