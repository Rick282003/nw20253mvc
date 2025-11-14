<?php

/**
 * Generador de WorkWith automático para SimplePHPMvcOOP
 * Uso:
 *   php generarWW.php roles_usuarios
 */

if ($argc < 2) {
    exit("Uso: php generarWW.php roles_usuarios\n");
}

$table = $argv[1];
$Table = ucfirst($table);

// -----------------------------------------------
// DB CONNECTION
// -----------------------------------------------
$cfg = parse_ini_file(__DIR__ . "/parameters.env");
$pdo = new PDO(
    "mysql:host={$cfg['DB_SERVER']};dbname={$cfg['DB_DATABASE']};port={$cfg['DB_PORT']};charset=utf8",
    $cfg['DB_USER'],
    $cfg['DB_PSWD']
);

// Obtener columnas
$stmt = $pdo->prepare("DESC $table;");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// PK
$pk = null;
foreach ($columns as $col) {
    if ($col['Key'] === 'PRI') {
        $pk = $col['Field'];
        break;
    }
}

// -----------------------------------------------
// UTILS
// -----------------------------------------------
function ensureDir($path)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

function writeFile($file, $content)
{
    file_put_contents($file, $content);
    echo "✔ Creado: $file\n";
}

// -----------------------------------------------
// Crear carpetas
// -----------------------------------------------
ensureDir("../src/Dao/$Table");
ensureDir("../src/Controllers/$Table");
ensureDir("../src/views/$table");

// -----------------------------------------------
// Generar DAO
// -----------------------------------------------
$daoFile = "../src/Dao/$Table/$Table.php";

$daoContent = "<?php
namespace Dao\\$Table;

use Dao\\Dao;

class $Table extends Dao {

    public static function obtenerTodos() {
        return self::obtenerRegistros(\"SELECT * FROM $table;\");
    }

    public static function obtenerPorId(\$id) {
        \$sql = \"SELECT * FROM $table WHERE $pk = :id;\";
        \$params = ['id'=>\$id];
        return self::obtenerUnRegistro(\$sql, \$params);
    }

    public static function insertar(\$data) {
        \$sql = \"INSERT INTO $table ("
    . implode(",", array_column($columns, 'Field')) .
    ") VALUES (" .
    implode(",", array_map(fn($c) => ':' . $c['Field'], $columns)) .
    ");\";

        return self::ejecutarNonQuery(\$sql, \$data);
    }

    public static function actualizar(\$data, \$id) {
        \$set = \"" . implode(",", array_map(fn($c) => $c['Field'] . ' = :' . $c['Field'], $columns)) . "\";
        \$sql = \"UPDATE $table SET \$set WHERE $pk = :id;\";
        \$data['id'] = \$id;
        return self::ejecutarNonQuery(\$sql, \$data);
    }

    public static function eliminar(\$id) {
        \$sql = \"DELETE FROM $table WHERE $pk = :id;\";
        return self::ejecutarNonQuery(\$sql, ['id'=>\$id]);
    }
}
?>";

writeFile($daoFile, $daoContent);

// -----------------------------------------------
// Controller List
// -----------------------------------------------
$listCtrlFile = "../src/Controllers/$Table/{$Table}List.php";

$listCtrl = "<?php
namespace Controllers\\$Table;

use Controllers\\PublicController;
use Dao\\$Table\\$Table;

class {$Table}List extends PublicController {

    public function run():void {
        \$viewData['items'] = $Table::obtenerTodos();
        \$$ = 'items';
        \$this->renderView('$table/list', \$viewData);
    }
}
?>";

writeFile($listCtrlFile, $listCtrl);

// -----------------------------------------------
// Controller Form
// -----------------------------------------------
$formCtrlFile = "../src/Controllers/$Table/{$Table}Form.php";

$inputs = "";
$assignData = "";
foreach ($columns as $c) {
    $field = $c['Field'];
    $inputs .= "      '$field' => '',\n";
    $assignData .= "        \$data['$field'] = \$_POST['$field'];\n";
}

$formCtrl = "<?php
namespace Controllers\\$Table;

use Controllers\\PublicController;
use Dao\\$Table\\$Table;

class {$Table}Form extends PublicController {

    private \$mode = 'INS';
    private \$id = 0;
    private \$viewData = [
$inputs    ];

    public function run():void {

        if (isset(\$_GET['mode'])) \$this->mode = \$_GET['mode'];
        if (isset(\$_GET['id'])) \$this->id = intval(\$_GET['id']);

        if (\$_POST) {
$assignData
            if (\$this->mode == 'INS') {
                $Table::insertar(\$this->viewData);
            } else {
                $Table::actualizar(\$this->viewData, \$this->id);
            }
            header(\"Location: index.php?page=$Table\\_List\");
        }

        if (\$this->mode != 'INS') {
            \$tmp = $Table::obtenerPorId(\$this->id);
            foreach (\$tmp as \$k=>\$v) {
                \$this->viewData[\$k] = \$v;
            }
        }

        \$this->viewData['mode'] = \$this->mode;

        \$this->renderView('$table/form', \$this->viewData);
    }
}
?>";

writeFile($formCtrlFile, $formCtrl);

// -----------------------------------------------
// View: LIST
// -----------------------------------------------
$listTplFile = "../src/views/$table/list.tpl";

$headers = "";
$rows = "";
foreach ($columns as $c) {
    $field = $c['Field'];
    $headers .= "      <th>$field</th>\n";
    $rows .= "      <td>{{{$field}}}</td>\n";
}

$listTpl = <<<TPL
<h2>$Table - Lista</h2>

<a href="index.php?page={$Table}_Form&mode=INS" class="btn btn-primary">Nuevo</a>

<table class="table">
  <thead>
    <tr>
$headers      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    {{foreach items}}
    <tr>
$rows
      <td>
        <a href="index.php?page={$Table}_Form&mode=UPD&id={{{$pk}}}" class="btn btn-warning">Editar</a>
        <a href="index.php?page={$Table}_Form&mode=DEL&id={{{\$pk}}}" class="btn btn-danger">Eliminar</a>
        <a href="index.php?page={$Table}_Form&mode=DSP&id={{{\$pk}}}" class="btn btn-info">Ver</a>
      </td>
    </tr>
    {{endfor items}}
  </tbody>
</table>
TPL;

writeFile($listTplFile, $listTpl);

// -----------------------------------------------
// View: FORM
// -----------------------------------------------
$formTplFile = "../src/views/$table/form.tpl";

$inputsHtml = "";
foreach ($columns as $c) {
    $field = $c['Field'];
    $inputsHtml .= <<<HTML
<div class="mb-3">
  <label>$field</label>
  <input name="$field" value="{{{$field}}}" class="form-control"/>
</div>

HTML;
}

$formTpl = <<<TPL
<h2>$Table - Formulario ({{mode}})</h2>

<form method="post">

$inputsHtml

<button class="btn btn-success">Guardar</button>
<a href="index.php?page={$Table}_List" class="btn btn-secondary">Volver</a>

</form>
TPL;

writeFile($formTplFile, $formTpl);

echo "\n✔ Finalizado correctamente.\n";
