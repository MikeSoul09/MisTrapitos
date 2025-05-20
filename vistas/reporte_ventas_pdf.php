<?php
require_once('../tcpdf/tcpdf.php');
require_once('../php/conexion.php');

$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

// Configuración básica
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mis Trapitos');
$pdf->SetTitle('Mis Trapitos');
$pdf->SetHeaderData('', 0, 'Reporte de Inventario', '', array(0,64,255), array(0,64,128));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 12));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 9);

// Agregar página
$pdf->AddPage();

// Consulta de productos
$sql = "SELECT p.*, pr.nombre AS proveedor 
        FROM productos p 
        LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor";
$res = $conn->query($sql);

// HTML para el contenido
$html = '<h2 style="text-align:center;">Reporte de Inventario</h2>';
$html .= '<table border="1" cellpadding="4">
    <thead>
        <tr style="background-color:#007BFF; color:#fff;">
            <th><b>Nombre</b></th>
            <th><b>Descripción</b></th>
            <th><b>Categoría</b></th>
            <th><b>Precio</b></th>
            <th><b>Stock</b></th>
            <th><b>Talla/Color</b></th>
            <th><b>Descuento</b></th>
            <th><b>Proveedor</b></th>
        </tr>
    </thead>
    <tbody>';

while ($row = $res->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['nombre'] . '</td>
        <td>' . $row['descripcion'] . '</td>
        <td>' . $row['categoria'] . '</td>
        <td>$' . number_format($row['precio'], 2) . '</td>
        <td>' . $row['stock'] . '</td>
        <td>' . $row['talla_color'] . '</td>
        <td>' . $row['descuento'] . '%</td>
        <td>' . ($row['proveedor'] ?? '—') . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('reporte_inventario.pdf', 'I'); // 'I' para mostrar en el navegador
