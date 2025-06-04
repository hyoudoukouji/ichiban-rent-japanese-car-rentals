<?php
require_once 'config/database.php';
session_start();

$userId = 1; // Default user ID since we don't have authentication yet

// Get saved cars with their details and features
$query = "
    SELECT c.*, GROUP_CONCAT(cf.feature) as features
    FROM saved_cars sc
    JOIN cars c ON sc.car_id = c.id
    LEFT JOIN car_features cf ON c.id = cf.car_id
    WHERE sc.user_id = :user_id
    GROUP BY c.id
";
$stmt = $db->prepare($query);
$stmt->bindValue(':user_id', $userId);
$result = $stmt->execute();
$savedCars = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $row['features'] = $row['features'] ? explode(',', $row['features']) : [];
    $row['specs'] = [
        'engine' => $row['engine'],
        'power' => $row['power'],
        'transmission' => $row['transmission']
    ];
    $savedCars[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Cars - Ichiban Rent</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            margin: 2rem;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .empty-state h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
        }

        .explore-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .explore-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .saved-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .saved-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .saved-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .remove-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            transform: scale(1.1);
            background: #dc3545;
            color: white;
        }

        .car-features {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .feature-tag {
            padding: 0.4rem 0.8rem;
            background: #e9ecef;
            border-radius: 16px;
            font-size: 0.85rem;
            color: #495057;
        }

        .feature-tag i {
            color: #28a745;
            margin-right: 0.3rem;
        }

        .car-specs {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .car-info {
            margin-top: 1rem;
        }

        .car-info h3 {
            margin: 0 0 0.5rem;
            font-size: 1.25rem;
        }

        .car-info .price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 1.1rem;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .rating i {
            color: #ffc107;
        }

        .rent-btn {
            width: 100%;
            padding: 0.8rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rent-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='40' height='40' fill='%231a1a1a'/%3E%3Ctext x='20' y='25' font-family='Arial' font-size='16' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E" alt="Logo" class="logo-img">
                <span>Ichiban Rent</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="explore.php"><i class="fas fa-compass"></i> Explore</a></li>
                    <li class="active"><i class="fas fa-heart"></i> Saved</li>
                    <li><i class="fas fa-car"></i> Rent</li>
                    <li><i class="fas fa-file-contract"></i> Terms & Conditions</li>
                    <li><i class="fas fa-user"></i> Profile</li>
                    <li><i class="fas fa-history"></i> Purchase History</li>
                    <li><i class="fas fa-cog"></i> Settings</li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Saved Cars</h1>
                    <p>Your collection of favorite Japanese cars.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <?php if (empty($savedCars)): ?>
            <div class="empty-state">
                <i class="far fa-heart"></i>
                <h2>No Saved Cars</h2>
                <p>Start exploring our collection and save your favorite cars!</p>
                <a href="explore.php" class="explore-btn">
                    <i class="fas fa-compass"></i>
                    Explore Cars
                </a>
            </div>
            <?php else: ?>
            <div class="saved-grid">
                <?php foreach ($savedCars as $car): ?>
                <div class="saved-card">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="car-image">
                    <button class="remove-btn" onclick="removeCar(this, <?php echo $car['id']; ?>)">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="car-info">
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <span><?php echo htmlspecialchars($car['rating']); ?></span>
                        </div>
                        <div class="car-features">
                            <?php foreach ($car['features'] as $feature): ?>
                            <span class="feature-tag">
                                <i class="fas fa-check-circle"></i>
                                <?php echo htmlspecialchars($feature); ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                        <div class="car-specs">
                            <?php foreach ($car['specs'] as $key => $value): ?>
                            <div class="spec-item">
                                <span><?php echo ucfirst(htmlspecialchars($key)); ?></span>
                                <span><?php echo htmlspecialchars($value); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="price"><?php echo htmlspecialchars($car['price']); ?></div>
                        <button class="rent-btn">Rent now</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function removeCar(btn, carId) {
            // Send AJAX request to remove car
            fetch('save_car.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=remove`
            }).then(() => {
                // Remove the car card from DOM
                const card = btn.closest('.saved-card');
                card.remove();
                
                // Show empty state if no cars left
                if (document.querySelectorAll('.saved-card').length === 0) {
                    const emptyState = `
                        <div class="empty-state">
                            <i class="far fa-heart"></i>
                            <h2>No Saved Cars</h2>
                            <p>Start exploring our collection and save your favorite cars!</p>
                            <a href="explore.php" class="explore-btn">
                                <i class="fas fa-compass"></i>
                                Explore Cars
                            </a>
                        </div>
                    `;
                    document.querySelector('.saved-grid').outerHTML = emptyState;
                }
            });
        }
    </script>
</body>
</html>
