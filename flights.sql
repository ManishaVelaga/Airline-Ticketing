
USE flight_database;
CREATE TABLE IF NOT EXISTS flights (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flight_number VARCHAR(50) NOT NULL,
  departure_city VARCHAR(100) NOT NULL,
  arrival_city VARCHAR(100) NOT NULL,
  departure_time DATETIME NOT NULL,
  arrival_time DATETIME NOT NULL
);
INSERT INTO flights (flight_number, departure_city, arrival_city, departure_time, arrival_time)
VALUES
  ('ABC123', 'New York', 'Los Angeles', '2023-06-18 10:00:00', '2023-06-18 12:30:00'),
  ('DEF456', 'London', 'Paris', '2023-06-19 14:30:00', '2023-06-19 16:00:00'),
  ('GHI789', 'Tokyo', 'Sydney', '2023-06-20 09:00:00', '2023-06-20 22:30:00'),
  ('JKL012', 'Dubai', 'Mumbai', '2023-06-21 18:45:00', '2023-06-21 22:15:00'),
  ('MNO345', 'Paris', 'Barcelona', '2023-06-22 11:30:00', '2023-06-22 14:00:00'),
  ('PQR678', 'Singapore', 'Bangkok', '2023-06-23 15:20:00', '2023-06-23 17:00:00'),
  ('STU901', 'New York', 'Chicago', '2023-06-24 08:15:00', '2023-06-24 09:45:00'),
  ('VWX234', 'London', 'Berlin', '2023-06-25 16:30:00', '2023-06-25 18:00:00'),
  ('YZA567', 'Sydney', 'Melbourne', '2023-06-26 13:45:00', '2023-06-26 15:15:00'),
  ('BCD890', 'Los Angeles', 'San Francisco', '2023-06-27 11:00:00', '2023-06-27 12:30:00'),
  ('EFG123', 'Paris', 'Rome', '2023-06-28 17:30:00', '2023-06-28 19:00:00'),
  ('HIJ456', 'Barcelona', 'Madrid', '2023-06-29 10:45:00', '2023-06-29 12:15:00'),
  ('KLM789', 'Bangkok', 'Phuket', '2023-06-30 08:00:00', '2023-06-30 09:30:00'),
  ('NOP012', 'Chicago', 'Miami', '2023-07-01 14:20:00', '2023-07-01 17:00:00'),
  ('QRS345', 'Berlin', 'Vienna', '2023-07-02 11:15:00', '2023-07-02 12:45:00'),
  ('TUV678', 'Melbourne', 'Brisbane', '2023-07-03 15:45:00', '2023-07-03 17:15:00'),
  ('WXY901', 'San Francisco', 'Seattle', '2023-07-04 09:30:00', '2023-07-04 11:00:00'),
  ('ZAB234', 'Rome', 'Athens', '2023-07-05 13:00:00', '2023-07-05 15:00:00'),
  ('CDE567', 'Madrid', 'Lisbon', '2023-07-06 16:45:00', '2023-07-06 18:30:00'),
  ('FGH890', 'Phuket', 'Kuala Lumpur', '2023-07-07 12:00:00', '2023-07-07 13:30:00');
CREATE TABLE IF NOT EXISTS bookings (
    id INT(11) NOT NULL AUTO_INCREMENT,
    flight_number VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);
