<?php
require_once 'config/database.php';

// Get all cars with their features
$query = "
    SELECT c.*, GROUP_CONCAT(cf.feature) as features
    FROM cars c
    LEFT JOIN car_features cf ON c.id = cf.car_id
    GROUP BY c.id
";
$result = $db->query($query);
$cars = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $row['features'] = $row['features'] ? explode(',', $row['features']) : [];
    $row['specs'] = [
        'engine' => $row['engine'],
        'power' => $row['power'],
        'transmission' => $row['transmission']
    ];
    $cars[] = $row;
}

// Get the saved cars from session if any
session_start();
$savedCars = isset($_SESSION['saved_cars']) ? $_SESSION['saved_cars'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Ichiban Rent</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .car-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .car-card:hover {
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

        .car-category {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
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

        .filters {
            padding: 1rem 2rem;
            background: white;
            border-radius: 12px;
            margin: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #1a1a1a;
            color: white;
            border-color: #1a1a1a;
        }

        .save-btn {
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

        .save-btn:hover {
            transform: scale(1.1);
        }

        .save-btn i {
            font-size: 1.2rem;
            color: #666;
        }

        .save-btn.saved i {
            color: #dc3545;
        }

        .price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 1.1rem;
            margin: 1rem 0;
        }

        .rent-btn {
            width: 100%;
            padding: 0.8rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rent-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
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
                    <li class="active"><i class="fas fa-compass"></i> Explore</li>
                    <li><a href="saved.php"><i class="fas fa-heart"></i> Saved</a></li>
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
                    <h1>Explore Cars</h1>
                    <p>Discover our extensive collection of Japanese performance cars.</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Car ....">
                    <button class="filter-btn"><i class="fas fa-sliders-h"></i></button>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="filters">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Performance</button>
                <button class="filter-btn">Drift</button>
                <button class="filter-btn">Classic</button>
                <button class="filter-btn">Modern</button>
                <button class="filter-btn">JDM</button>
            </div>

            <div class="car-grid">
                <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <div style="position: relative;">
                        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="car-image">
                        <button class="save-btn <?php echo in_array($car['id'], $savedCars) ? 'saved' : ''; ?>" 
                                onclick="toggleSave(this, <?php echo $car['id']; ?>)">
                            <i class="<?php echo in_array($car['id'], $savedCars) ? 'fas' : 'far'; ?> fa-heart"></i>
                        </button>
                    </div>
                    <span class="car-category"><?php echo htmlspecialchars($car['category']); ?></span>
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
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSave(btn, carId) {
            const icon = btn.querySelector('i');
            const isSaved = icon.classList.contains('fas');
            
            // Toggle icon
            icon.classList.toggle('fas');
            icon.classList.toggle('far');
            btn.classList.toggle('saved');

            // Send AJAX request to update saved cars
            fetch('save_car.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=${isSaved ? 'remove' : 'add'}`
            });
        }

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const category = btn.textContent.trim();
                document.querySelectorAll('.car-card').forEach(card => {
                    const cardCategory = card.querySelector('.car-category').textContent;
                    if (category === 'All' || category === cardCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
