<?php
require_once('../tcpdf/tcpdf.php');
require 'conexion.php';

// Consulta para obtener los productos más vendidos
$sql = "SELECT p.nombre, SUM(dv.cantidad) as total_vendido
        FROM detalle_ventas dv
        INNER JOIN productos p ON dv.id_producto = p.id_producto
        GROUP BY dv.id_producto
        ORDER BY total_vendido DESC";

$resultado = $conn->query($sql);

// Crear nuevo PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Reporte de Productos Más Vendidos</h1>';
$html .= '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th><strong>Producto</strong></th>
                    <th><strong>Total Vendido</strong></th>
                </tr>
            </thead>
            <tbody>';

while ($row = $resultado->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $row['nombre'] . '</td>
                <td>' . $row['total_vendido'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('reporte_productos_mas_vendidos.pdf', 'I');
exit();
