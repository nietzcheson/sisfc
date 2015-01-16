<h2>Editar Role de usuario</h2>
<form name="form1" action="" method="post">
    <input type="hidden" name="editar" value="1" />
    <table>
        <tr>
            <td>Usuario</td>
            <td>
                {foreach from=$info item=pr}
                    {$pr.usuario}
                    {assign var="rolea" value=$pr.role}
                {/foreach}
            </td>
        </tr>
        <tr>
            <td>Role</td>
            <td>
                <select name="usur_{$ide}">
                    {foreach from=$roles item=rl}
                        <option value="{$rl.id_role}" {if $rolea == $rl.role} selected="selected" {/if} >{$rl.role}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
    </table>
    <p><input type="submit" value="guardar" /></p>
</form>
<p><a href="{$_layoutParams.root}usuarios">Regresar</a></p>