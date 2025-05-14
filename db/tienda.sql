-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tienda_ropa;
USE tienda_ropa;

-- Tabla de Proveedores
CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    correo VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla de Productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    talla_color VARCHAR(100),
    descuento DECIMAL(5,2) DEFAULT 0,
    inicio_oferta DATE,
    fin_oferta DATE,
    id_proveedor INT,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Tabla de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    correo VARCHAR(100),
    telefono VARCHAR(20),
    ciudad VARCHAR(50)
);

-- Tabla de Ventas
CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    metodo_pago ENUM('Efectivo', 'Tarjeta', 'Transferencia') NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabla de Detalles de Ventas
CREATE TABLE detalle_ventas (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Índices adicionales para mejorar consultas
CREATE INDEX idx_producto_categoria ON productos(categoria);
CREATE INDEX idx_cliente_ciudad ON clientes(ciudad);
CREATE INDEX idx_venta_fecha ON ventas(fecha);

-- Datos para probar la db

-- Proveedores
INSERT INTO proveedores (nombre, direccion, correo, telefono) VALUES
('Proveedora Moda SA', 'Av. Central 123', 'contacto@modasa.com', '3312345678'),
('Textiles MX', 'Calle Diseño 456', 'ventas@textilesmx.com', '3322334455'),
('Accesorios Fashion', 'Plaza Ropa Local 9', 'info@accesfashion.com', '3344556677');

-- Productos
INSERT INTO productos (nombre, categoria, descripcion, precio, stock, talla_color, descuento, inicio_oferta, fin_oferta, id_proveedor) VALUES
('Camiseta Blanca', 'Camisetas', 'Camiseta de algodón blanca', 199.99, 50, 'S,M,L', 10.0, '2025-05-01', '2025-05-31', 1),
('Camiseta Negra', 'Camisetas', 'Camiseta casual negra', 219.99, 30, 'M,L,XL', 0, NULL, NULL, 1),
('Pantalón Azul', 'Pantalones', 'Pantalón de mezclilla azul', 399.00, 40, '30,32,34', 5.0, '2025-05-10', '2025-05-25', 2),
('Gorra Estilo', 'Accesorios', 'Gorra con diseño urbano', 150.50, 20, 'Única', 0, NULL, NULL, 3),
('Cinturón Cuero', 'Accesorios', 'Cinturón de cuero genuino', 299.90, 15, 'M,L', 15.0, '2025-05-05', '2025-06-01', 3);

-- Clientes
INSERT INTO clientes (nombre, direccion, correo, telefono, ciudad) VALUES
('Carlos Mendoza', 'Av. Libertad 500', 'carlos.mendoza@gmail.com', '3311112222', 'Guadalajara'),
('Ana López', 'Calle Rosa 89', 'ana.lopez@yahoo.com', '3322223333', 'Zapopan'),
('Laura Torres', 'Calle Lago 22', 'laura.torres@hotmail.com', '3333334444', 'Guadalajara');

-- Ventas y detalles (todo en una sola ejecución)
INSERT INTO ventas (id_cliente, fecha, metodo_pago) VALUES
(1, '2025-05-10 14:30:00', 'Tarjeta'),
(2, '2025-05-11 16:00:00', 'Efectivo'),
(3, '2025-05-12 12:00:00', 'Transferencia');

-- Detalles de ventas
INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario) VALUES
(1, 1, 2, 199.99),
(1, 3, 1, 399.00),
(2, 2, 1, 219.99),
(2, 4, 1, 150.50),
(3, 5, 1, 299.90);