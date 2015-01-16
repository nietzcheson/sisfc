<a href="{$_layoutParams.root}sdt_live"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Regresar</button></a>
<table class="table table-hover" width="100%" >
  <thead>
    <tr>
      <td>Fuente</td>
      <td>Tamaño</td>
      <td>Color letra</td>
      <td>Color Fondo</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <select id="LetraFont">
          <option value="Arial">Arial</option>
          <option value="Cambria">Cambria</option>
          <option value="Georgia">Georgia</option>
          <option value="Helvetica">Helvetica</option>
          <option value="Klavika" selected>Klavika</option>
          <option value="Verdana">Verdana</option>
        </select>
      </td>
      <td>
        <select id="LetraSize">
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14" selected>14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
          <option value="32">32</option>
        </select>
      </td>
      <td>
        <div style="border-width:3px;border-style:solid;border-color:#000000;width:24px">
          <select id="color1" name="colorpicker-picker-delay">
            <option value="#000000">Black</option>
            <option value="#ffffff">White</option>
            <option value="#ff1d15">Red</option>
            <option value="#ffe527">Yellow</option>
            <option value="#dc6519">Orange</option>
            <option value="#293cff">Turquoise</option>
            <option value="#771edc">Light green</option>
            <option value="#287d17">Bold green</option>
            <option value="#f0a7a5">Yellow</option>
            <option value="#7d7980">Orange</option>
          </select>
        </div>
      </td>
      <td>
        <div style="border-width:3px;border-style:solid;border-color:#000000;width:24px">
          <select id="color2" name="colorpicker-picker-delay2">
            <!-- <option value="#000000">Black</option>
            <option value="#ffffff">White</option> -->
            <option value="#ff1d15">Red</option>
            <option value="#ffe527">Yellow</option>
            <option value="#dc6519">Orange</option>
            <option value="#293cff">Turquoise</option>
            <option value="#771edc">Light green</option>
            <option value="#287d17">Bold green</option>
            <option value="#f0a7a5">Yellow</option>
            <option value="#7d7980">Orange</option>
          </select>
        </div>
      </td>
      </td>
    </tr>
  </tbody>
</table>

<table class="table">
  <thead>
    <tr>
      <th><input type="checkbox" id="checkAll"></th>
      <th>Nombre de la etiqueta</th>
      <th>Formato</th>
    </tr>
  </thead>
  <tbody>
    {foreach item=dato from=$datos}
      {if {$dato.nombre_etiqueta!="default"}}
        <tr>
          <td>
            <input type="checkbox" id="chek{$dato.id_etiqueta}" class="chek">
          </td>
          <td>
            <input type="text" class="form-control" id="text{$dato.id_etiqueta}" value="{$dato.nombre_etiqueta}">
          </td>
          <td>
            <div id="et{$dato.id_etiqueta}" style="font-family:{$dato.ffamily};font-size:{$dato.fsize}px;color:{$dato.fcolor};background-color:{$dato.fcback}">{$dato.ffamily}  {$dato.fsize}px</div>
          </td>
        </tr>
      {/if}
    {/foreach}
  </tbody>
</table>
<a href="{$_layoutParams.root}sdt/etiquetas/true"><button type="button" class="btn btn-{$_layoutParams.btn_return}">Reiniciar valores</button></a>
