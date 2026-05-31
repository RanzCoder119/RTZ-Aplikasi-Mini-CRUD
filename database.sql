CREATE DATABASE IF NOT EXISTS db_maintenance;
USE db_maintenance;

CREATE TABLE IF NOT EXISTS equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name   VARCHAR(100) NOT NULL,
    type             VARCHAR(50)  NOT NULL,
    location         VARCHAR(50)  NOT NULL,
    status           ENUM('Operasional','Maintenance','Standby','Rusak')
                     NOT NULL DEFAULT 'Operasional',
    last_maintenance DATE NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO equipment (equipment_name, type, location, status, last_maintenance) VALUES
('Flame Detector FD-101', 'Safety',        'Deck A',      'Operasional', '2025-04-15'),
('Solenoid Valve SV-203', 'Control',       'Engine Room', 'Maintenance', '2025-05-10'),
('Level Transmitter LT-05','Instrumentation','Slop Tank', 'Operasional', '2025-03-20');