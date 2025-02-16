<?php

function crudBorrar($id) {
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ($resu) {
        $_SESSION['msg'] = " El usuario " . $id . " ha sido eliminado.";
    } else {
        $_SESSION['msg'] = " Error al eliminar el usuario " . $id . ".";
    }
}

function crudTerminar() {
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta() {
    $cli = new Cliente();
    $orden = "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/detalles.php";
    }
}

function crudDetallesSiguiente($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/detalles.php";
    }
}

function crudDetallesAnterior($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/detalles.php";
    }
}

function crudModificar($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden = "Modificar";
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/formulario.php";
    }
}

function crudModificarSiguiente($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    $orden = "Modificar";
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/formulario.php";
    }
}

function crudModificarAnterior($id) {
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    $orden = "Modificar";
    if ($cli === false) {
        include_once "app/views/todo.php";
    } else {
        include_once "app/views/formulario.php";
    }
}
function validarImagen($imagen) {
    $permitidos = ['image/jpeg', 'image/png'];
    $maxSize = 500 * 1024; // 500 KB

    if ($imagen['error'] !== UPLOAD_ERR_OK) {
        return "Error al subir la imagen.";
    }

    if (!in_array($imagen['type'], $permitidos)) {
        return "El formato de la imagen no es válido. Solo se permiten JPG y PNG.";
    }

    if ($imagen['size'] > $maxSize) {
        return "El tamaño de la imagen excede el límite de 500 KB.";
    }

    return false;
}
function checkEmail($email, $id_excluir = null) {
    // Validar si el email tiene formato correcto
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '.') === false) {
        return "Error: El email no es válido o no contiene un punto.";
    }

    // Acceso a la base de datos
    $db = AccesoDatos::getModelo();
    $cli = $db->buscarEmail($email);

    // Si el email pertenece al mismo usuario que se está editando, no es un problema
    if ($id_excluir && $cli && $cli->id == $id_excluir) {
        return false;
    }

    // Si el email ya existe en la base de datos
    if ($cli) {
        return "Error: El email ya está registrado.";
    }

    return false; // El email está disponible
}

function crudPostAlta() {
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();
    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];

    $todoOK = true;

    if (($errorMsg = checkEmail($cli->email)) !== false) {
        $todoOK = false;
        echo "<p>$errorMsg</p>";
    }

    if (!checkIP($cli->ip_address)) {
        $todoOK = false;
        echo "<p>La IP tiene un formato incorrecto</p>";
    }

    if (!checkTel($cli->telefono)) {
        $todoOK = false;
        echo "<p>El teléfono tiene un formato incorrecto</p>";
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (($errorMsg = validarImagen($_FILES['foto'])) !== false) {
            $todoOK = false;
            echo "<p>$errorMsg</p>";
        } else {
            $rutaDestino = "app/uploads/" . $cli->id . "." . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino);
        }
    }

    $db = AccesoDatos::getModelo();

    if ($todoOK) {
        $db->addCliente($cli);
        $_SESSION['msg'] = "El usuario ha sido añadido";
    } else {
        $orden = "Nuevo";
        include_once "app/views/formulario.php";
    }
}

function crudPostModificar() {
    limpiarArrayEntrada($_POST); // Evito la posible inyección de código
    $cli = new Cliente();

    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];

    $todoOK = true;

    if (($errorMsg = checkEmail($cli->email, $cli->id)) !== false) {
        $todoOK = false;
        echo "<p>$errorMsg</p>";
    }

    if (!checkIP($cli->ip_address)) {
        $todoOK = false;
        echo "<p>La IP tiene un formato incorrecto</p>";
    }

    if (!checkTel($cli->telefono)) {
        $todoOK = false;
        echo "<p>El teléfono tiene un formato incorrecto</p>";
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (($errorMsg = validarImagen($_FILES['foto'])) !== false) {
            $todoOK = false;
            echo "<p>$errorMsg</p>";
        } else {
            // Eliminar la foto antigua si existe
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $rutaDestino = "app/uploads/" . $cli->id . "." . $ext;
            $rutaAntiguaJpg = "app/uploads/" . $cli->id . ".jpg";
            $rutaAntiguaPng = "app/uploads/" . $cli->id . ".png";

            if (file_exists($rutaAntiguaJpg)) {
                unlink($rutaAntiguaJpg);
            }
            if (file_exists($rutaAntiguaPng)) {
                unlink($rutaAntiguaPng);
            }

            // Guardar la nueva foto
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $todoOK = false;
                echo "<p>Error al guardar la nueva foto.</p>";
            }
        }
    }

    $db = AccesoDatos::getModelo();

    if ($todoOK) {
        $db->modCliente($cli);
        $_SESSION['msg'] = "El usuario ha sido modificado";
    } else {
        $orden = "Modificar";
        include_once "app/views/formulario.php";
    }
}

function checkIP($ip) {
    $formato = true;
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $formato = false;
    }

    return $formato;
}

function checkTel($tel) {
    $formato = true;
    $patron = "/^\d{3}-\d{3}-\d{4}$/";
    if (!preg_match($patron, $tel)) {
        $formato = false;
    }

    return $formato;
}

function foto($id) {
    $rutaJpg = "app/uploads/" . $id . ".jpg";
    $rutaPng = "app/uploads/" . $id . ".png";

    if (file_exists($rutaJpg)) {
        return "<img src='$rutaJpg' alt='Foto del cliente' style='max-height:500px;'>";
    } elseif (file_exists($rutaPng)) {
        return "<img src='$rutaPng' alt='Foto del cliente' style='max-height:500px;'>";
    } else {
        return "<img src='https://robohash.org/$id' style='max-height:500px;' alt='Foto del cliente'>";
    }
}
function codigoPais($ip) {
    $jsonIP = file_get_contents('http://ip-api.com/json/' . $ip);
    $jsonObjeto = json_decode($jsonIP);

    if (property_exists($jsonObjeto, 'countryCode') && $jsonObjeto->countryCode !== null) {
        return $jsonObjeto->countryCode;
    } else {
        return 'no disponible';
    }
}

function obtenerCoordenadas($ip) {
    $jsonIP = file_get_contents('http://ip-api.com/json/' . $ip);
    $jsonObjeto = json_decode($jsonIP);

    if (property_exists($jsonObjeto, 'lat') && property_exists($jsonObjeto, 'lon')) {
        return ['lat' => $jsonObjeto->lat, 'lon' => $jsonObjeto->lon];
    } else {
        return ['lat' => null, 'lon' => null];
    }
}


function generarPDF($id, $first_name, $last_name, $email, $gender, $ip_address, $telefono) {
    require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';


    $pdf = new TCPDF();
    $pdf->SetTitle('Cliente PDF');
    $pdf->SetSubject('Detalles del Cliente');
    $pdf->AddPage();

    $html = '
    <h1 style="text-align: center;">Detalles del Cliente</h1>
    <table border="1" style="margin: 0 auto; padding: 10px;">
      <tr>
        <td>ID:</td>
        <td>' . $id . '</td>
      </tr>
      <tr>
        <td>Nombre:</td>
        <td>' . $first_name . ' ' . $last_name . '</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>' . $email . '</td>
      </tr>
      <tr>
        <td>Género:</td>
        <td>' . $gender . '</td>
      </tr>
      <tr>
        <td>IP Address:</td>
        <td>' . $ip_address . '</td>
      </tr>
      <tr>
        <td>Teléfono:</td>
        <td>' . $telefono . '</td>
      </tr>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('cliente.pdf', 'I');
}
