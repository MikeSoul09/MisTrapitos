<?php
// Botón flotante "Volver a Inicio"
?>

<style>
  .btn-volver {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #1538fd;
    color: white;
    padding: 12px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: background-color 0.3s ease;
    z-index: 999;
  }

  .btn-volver:hover {
    background-color: #5972ff;
  }
</style>

<a href="../index.php" class="btn-volver">← Volver a Inicio</a>
