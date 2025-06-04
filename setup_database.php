<?php
require_once 'config/database.php';

try {
    // Create tables
    $db->exec("
        CREATE TABLE IF NOT EXISTS cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price TEXT NOT NULL,
            rating REAL NOT NULL,
            category TEXT NOT NULL,
            engine TEXT NOT NULL,
            power TEXT NOT NULL,
            transmission TEXT NOT NULL,
            image TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS car_features (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            car_id INTEGER NOT NULL,
            feature TEXT NOT NULL,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS saved_cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            car_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    // Clear existing data
    $db->exec("DELETE FROM saved_cars");
    $db->exec("DELETE FROM car_features");
    $db->exec("DELETE FROM cars");

    // Insert Performance Cars
    $cars = [
        [
            'name' => 'Toyota Supra MK4',
            'price' => 'Rp 9.890.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.0L 2JZ-GTE Twin-Turbo I6',
            'power' => '320 HP',
            'transmission' => '6-Speed Manual',
            'features' => ['Exhibition Ready', 'Track Ready', 'Iconic Status']
        ],
        [
            'name' => 'Nissan GT-R R35',
            'price' => 'Rp 12.500.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.8L Twin-Turbo V6',
            'power' => '565 HP',
            'transmission' => '6-Speed Dual-Clutch',
            'features' => ['Exhibition Ready', 'Track Ready', 'Modern Classic']
        ],
        [
            'name' => 'Honda NSX Type-R',
            'price' => 'Rp 7.890.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.0L VTEC V6',
            'power' => '290 HP',
            'transmission' => '6-Speed Manual',
            'features' => ['Exhibition Ready', 'Track Ready', 'Rare Find']
        ],
        [
            'name' => 'Mazda RX-7 FD',
            'price' => 'Rp 7.190.000',
            'rating' => 4.8,
            'category' => 'Drift',
            'engine' => '1.3L Twin-Turbo Rotary',
            'power' => '276 HP',
            'transmission' => '5-Speed Manual',
            'features' => ['Drift Ready', 'Track Ready', 'Iconic Status']
        ],
        [
            'name' => 'Toyota AE86 Trueno',
            'price' => 'Rp 8.120.000',
            'rating' => 4.8,
            'category' => 'Drift',
            'engine' => '1.6L 4A-GE',
            'power' => '130 HP',
            'transmission' => '5-Speed Manual',
            'features' => ['Drift Ready', 'Exhibition Ready', 'Iconic Status']
        ]
    ];

    // Insert cars and their features
    foreach ($cars as $car) {
        $features = $car['features'];
        unset($car['features']);
        
        $stmt = $db->prepare("
            INSERT INTO cars (name, price, rating, category, engine, power, transmission, image)
            VALUES (:name, :price, :rating, :category, :engine, :power, :transmission, :image)
        ");

        $car['image'] = 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E' . urlencode($car['name']) . '%3C/text%3E%3C/svg%3E';
        
        foreach ($car as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        $stmt->execute();
        $carId = $db->lastInsertRowID();

        // Insert features
        foreach ($features as $feature) {
            $stmt = $db->prepare("INSERT INTO car_features (car_id, feature) VALUES (:car_id, :feature)");
            $stmt->bindValue(':car_id', $carId);
            $stmt->bindValue(':feature', $feature);
            $stmt->execute();
        }
    }

    echo "Database setup completed successfully!";
} catch(Exception $e) {
    echo "Setup failed: " . $e->getMessage();
}
