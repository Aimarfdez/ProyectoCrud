<form>
    <button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>
</form>
<br>
<div class="table-container">
<table>
    <tr>
        <th style="text-align: center;">id
            <form style="display: inline;">
                <button type="submit" name="ordenacion" value="id-Asc" style="border: none; background: none; cursor: pointer;">↑</button>
                <button type="submit" name="ordenacion" value="id-Desc" style="border: none; background: none; cursor: pointer;">↓</button>
            </form>
        </th>
        <th style="text-align: center;">first_name
            <form style="display: inline;">
                <button type="submit" name="ordenacion" value="fname-Asc" style="border: none; background: none; cursor: pointer;">↑</button>
                <button type="submit" name="ordenacion" value="fname-Desc" style="border: none; background: none; cursor: pointer;">↓</button>
            </form>
        </th>
        <th style="text-align: center;">email
            <form style="display: inline;">
                <button type="submit" name="ordenacion" value="email-Asc" style="border: none; background: none; cursor: pointer;">↑</button>
                <button type="submit" name="ordenacion" value="email-Desc" style="border: none; background: none; cursor: pointer;">↓</button>
            </form>
        </th>
        <th style="text-align: center;">gender
            <form style="display: inline;">
                <button type="submit" name="ordenacion" value="gen-Asc" style="border: none; background: none; cursor: pointer;">↑</button>
                <button type="submit" name="ordenacion" value="gen-Desc" style="border: none; background: none; cursor: pointer;">↓</button>
            </form>
        </th>
        <th style="text-align: center;">ip_address
            <form style="display: inline;">
                <button type="submit" name="ordenacion" value="ip-Asc" style="border: none; background: none; cursor: pointer;">↑</button>
                <button type="submit" name="ordenacion" value="ip-Desc" style="border: none; background: none; cursor: pointer;">↓</button>
            </form>
        </th>
        <th style="text-align: center;">teléfono</th>
    </tr>
    <?php foreach ($tvalores as $valor) : ?>
        <tr>
            <td><?= $valor->id ?> </td>
            <td><?= $valor->first_name ?> </td>
            <td><?= $valor->email ?> </td>
            <td><?= $valor->gender ?> </td>
            <td><?= $valor->ip_address ?> </td>
            <td><?= $valor->telefono ?> </td>
            <td><a href="#" onclick="confirmarBorrar('<?= $valor->first_name ?>',<?= $valor->id ?>);"><button type="button" style="background-color: red; color: white;">Borrar</button></a></td>
            <td><a href="?orden=Modificar&id=<?= $valor->id ?>"><button type="button" style="background-color: green; color: white;">Modificar</button></a></td>
            <td><a href="?orden=Detalles&id=<?= $valor->id ?>"><button type="button" style="background-color: yellow; color: black;">Detalles</button></a></td>

        <tr>
        <?php endforeach ?>
</table>
</div>
<form>
    <br>
    <button type="submit" name="nav" value="Primero">
        << </button>
            <button type="submit" name="nav" value="Anterior">
                < </button>
                    <button type="submit" name="nav" value="Siguiente"> > </button>
                    <button type="submit" name="nav" value="Ultimo"> >> </button>
</form>