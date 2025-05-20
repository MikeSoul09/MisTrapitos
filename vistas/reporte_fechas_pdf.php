<?php
require_once('../tcpdf/tcpdf.php');
require_once('../php/conexion.php');

$ventas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];

    $stmt = $conn->prepare("
    SELECT v.id_venta, v.fecha, c.nombre AS cliente, p.nombre AS producto, dv.cantidad, p.precio AS precio_unitario 
    FROM ventas v
    INNER JOIN clientes c ON v.id_cliente = c.id_cliente
    INNER JOIN detalle_ventas dv ON v.id_venta = dv.id_venta
    INNER JOIN productos p ON dv.id_producto = p.id_producto
    WHERE v.fecha BETWEEN ? AND ?
    ORDER BY v.fecha ASC
");


    $stmt->bind_param("ss", $desde, $hasta);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }
} else {
    die("Acceso no permitido.");
}

// Crear PDF
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tienda');
$pdf->SetTitle('Reporte de Ventas');
$pdf->SetHeaderData('', 0, 'Reporte de Ventas', "Desde $desde hasta $hasta", [0,64,255], [0,64,128]);
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$html = "<h2 style='text-align:center;'>🧾 Reporte de Ventas</h2>";
$html .= "<p><strong>Período:</strong> $desde a $hasta</p>";

$html .= '<table border="1" cellpadding="4">
    <thead>
        <tr style="background-color:#007BFF; color:#fff;">
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>';

$total_general = 0;
foreach ($ventas as $venta) {
    $total = $venta['cantidad'] * $venta['precio_unitario']; // Usar precio_unitario de la consulta
    $total_general += $total;

    $html .= "<tr>
        <td>{$venta['id_venta']}</td>
        <td>{$venta['fecha']}</td>
        <td>{$venta['cliente']}</td>
        <td>{$venta['producto']}</td>
        <td>{$venta['cantidad']}</td>
        <td>$" . number_format($venta['precio_unitario'], 2) . "</td>
        <td>$" . number_format($total, 2) . "</td>
    </tr>";
}


$html .= "<tr>
    <td colspan='6' style='text-align:right;'><strong>Total General</strong></td>
    <td><strong>$" . number_format($total_general, 2) . "</strong></td>
</tr>";

$html .= "</tbody></table>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("reporte_ventas_{$desde}_{$hasta}.pdf", 'I');