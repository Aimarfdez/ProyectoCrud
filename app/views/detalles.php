<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Cliente</title>
    <link rel="stylesheet" href="https://unpkg.com/ol@7.2.2/dist/ol.css">
    <script src="https://unpkg.com/ol@7.2.2/dist/ol.js"></script>
</head>
<body>
<hr>
<button onclick="location.href='./'"> Volver </button>
<br><br>

<?php if (codigoPais($cli->ip_address) === 'no disponible'): ?>
    <p style="color: red; font-size: small;">No se ha podido obtener la IP del cliente</p>
<?php endif; ?>

<table>
    <tr>
        <td>id:</td>
        <td><input type="number" name="id" value="<?= $cli->id ?>" readonly> </td>
        <td rowspan="7">
            <?= foto($id) ?>
        </td>
    </tr>
    <tr>
        <td>first_name:</td>
        <td><input type="text" name="first_name" value="<?= $cli->first_name ?>" readonly> </td>
    </tr>
    <tr>
        <td>last_name:</td>
        <td><input type="text" name="last_name" value="<?= $cli->last_name ?>" readonly></td>
    </tr>
    <tr>
        <td>email:</td>
        <td><input type="email" name="email" value="<?= $cli->email ?>" readonly></td>
    </tr>
    <tr>
        <td>gender</td>
        <td><input type="text" name="gender" value="<?= $cli->gender ?>" readonly></td>
    </tr>
    <tr>
        <td>ip_address:</td>
        <td><input type="text" name="ip_address" value="<?= $cli->ip_address ?>" readonly>
            <?php
            $countryCode = strtolower(codigoPais($cli->ip_address));
            if ($countryCode !== 'no disponible') {
                echo '<img src="https://flagcdn.com/256x192/' . $countryCode . '.png" style="width: 30px;" alt="Bandera del país">';
            } else {
                echo '<h1>Ninguna bandera asociada a la IP</h1>';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>telefono:</td>
        <td><input type="tel" name="telefono" value="<?= $cli->telefono ?>" readonly></td>
    </tr>
</table> <br><br>

<?php
$coordenadas = obtenerCoordenadas($cli->ip_address);
if ($coordenadas['lat'] !== null && $coordenadas['lon'] !== null): ?>
    <div id="map" style="width: 100%; height: 400px;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lon = <?= $coordenadas['lon'] ?>;
            var lat = <?= $coordenadas['lat'] ?>;
            console.log('Coordenadas:', [lon, lat]); // Verificar coordenadas en la consola

            var map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([lon, lat]),
                    zoom: 10
                })
            });

            var marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat]))
            });

            var vectorSource = new ol.source.Vector({
                features: [marker]
            });

            var markerVectorLayer = new ol.layer.Vector({
                source: vectorSource,
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 1],
                        src: 'https://openlayers.org/en/latest/examples/data/icon.png'
                    })
                })
            });

            map.addLayer(markerVectorLayer);
        });
    </script>
<?php endif; ?>

<form>
    <input type="hidden" name="id" value="<?= $cli->id ?>">
    <button type="submit" name="nav-detalles" value="Anterior">Anterior &lt;&lt;</button>
    <button type="submit" name="nav-detalles" value="Siguiente">Siguiente &gt;&gt;</button>
</form><br><br>

<form method="post" action="index.php">
    <input type="hidden" name="id" value="<?= $cli->id ?>">
    <input type="hidden" name="first_name" value="<?= $cli->first_name ?>">
    <input type="hidden" name="last_name" value="<?= $cli->last_name ?>">
    <input type="hidden" name="email" value="<?= $cli->email ?>">
    <input type="hidden" name="gender" value="<?= $cli->gender ?>">
    <input type="hidden" name="ip_address" value="<?= $cli->ip_address ?>">
    <input type="hidden" name="telefono" value="<?= $cli->telefono ?>">
    <button type="submit" name="orden" value="Imprimir">Imprimir</button>
</form>
</body>
</html>