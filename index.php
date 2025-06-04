<?php
// Sample car data array
$cars = [
    [
        'name' => 'Honda NSX Type-R',
        'price' => 'Rp 7.890.000',
        'rating' => '4.9',
        'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EHonda NSX%3C/text%3E%3C/svg%3E'
    ],
    [
        'name' => 'Mazda RX-7 Type R (FD3S)',
        'price' => 'Rp 5.027.000',
        'rating' => '4.7',
        'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EMazda RX-7%3C/text%3E%3C/svg%3E'
    ],
    [
        'name' => 'Nissan Skyline GT-R R34',
        'price' => 'Rp 6.150.000',
        'rating' => '4.9',
        'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESkyline R34%3C/text%3E%3C/svg%3E'
    ],
    [
        'name' => 'Subaru Impreza WRX STI',
        'price' => 'Rp 4.890.000',
        'rating' => '4.6',
        'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EImpreza STI%3C/text%3E%3C/svg%3E'
    ],
    [
        'name' => 'Mitsubishi Lancer Evolution IX',
        'price' => 'Rp 5.230.000',
        'rating' => '4.8',
        'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ELancer Evo IX%3C/text%3E%3C/svg%3E'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ichiban Rent - Japanese Car Rentals</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <li class="active"><i class="fas fa-home"></i> Home</li>
                    <li><i class="fas fa-compass"></i> Explore</li>
                    <li><i class="fas fa-heart"></i> Saved</li>
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
                    <h1>Japan Cars</h1>
                    <p>Experience the Heart of Japan in Every Drive.</p>
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

            <!-- Featured Car -->
            <section class="featured-car">
                <div class="car-details">
                    <h2>Toyota Sprinter Trueno AE86</h2>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span>(2000+ Reviews)</span>
                    </div>
                    <p class="description">
                        Powered by the legendary 1.6-liter 4A-GE DOHC engine, this 
                        lightweight machine delivers sharp throttle response and 
                        high-revving excitement.
                    </p>
                    <div class="price">Rp. 8.120.000</div>
                    <div class="actions">
                        <div class="color-select">
                            <span>Color</span>
                            <div class="color-options">
                                <button class="color-btn white active"></button>
                                <button class="color-btn black"></button>
                            </div>
                        </div>
                        <div class="duration">
                            <button class="minus">-</button>
                            <span>1 Day</span>
                            <button class="plus">+</button>
                        </div>
                    </div>
                    <div class="rent-actions">
                        <button class="favorite-btn"><i class="far fa-heart"></i></button>
                        <button class="rent-btn">Rent now</button>
                    </div>
                </div>
                <div class="car-image">
                    <img src="data:image/svg+xml,%3Csvg width='400' height='250' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='400' height='250' fill='%231a1a1a'/%3E%3Ctext x='200' y='125' font-family='Arial' font-size='24' fill='white' text-anchor='middle'%3EToyota AE86%3C/text%3E%3C/svg%3E" alt="Toyota AE86">
                </div>
            </section>

            <!-- Car List -->
            <section class="car-list">
                <?php foreach ($cars as $car): ?>
                <div class="car-card" style="margin: 0 10px 20px 10px;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                    <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                    <div class="price"><?php echo htmlspecialchars($car['price']); ?></div>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span><?php echo htmlspecialchars($car['rating']); ?></span>
                    </div>
                    <button class="add-btn">+</button>
                </div>
                <?php endforeach; ?>
            </section>

            <!-- Top Rent Section -->
            <section class="top-rent">
                <div class="section-header">
                    <h2>Top Rent</h2>
                    <a href="#" class="view-all">View all <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="top-rent-list">
                    <?php
                    $topRentCars = [
                        [
                            'name' => 'Honda Integra Type R',
                            'price' => 'Rp 4.120.000',
                            'reviews' => '3200 Reviews',
                            'rents' => '180 Rent',
                            'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EIntegra Type R%3C/text%3E%3C/svg%3E'
                        ],
                        [
                            'name' => 'Toyota Chaser JZX100',
                            'price' => 'Rp 4.899.000',
                            'reviews' => '4502 Reviews',
                            'rents' => '290 orders',
                            'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EChaser JZX100%3C/text%3E%3C/svg%3E'
                        ],
                        [
                            'name' => 'Nissan 180SX',
                            'price' => 'Rp 4.290.000',
                            'reviews' => '3890 Reviews',
                            'rents' => '220 orders',
                            'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E180SX%3C/text%3E%3C/svg%3E'
                        ],
                        [
                            'name' => 'Mitsubishi GTO',
                            'price' => 'Rp 5.190.000',
                            'reviews' => '3500 Reviews',
                            'rents' => '180 orders',
                            'image' => 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGTO%3C/text%3E%3C/svg%3E'
                        ]
                    ];

                    foreach ($topRentCars as $car): ?>
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #f8f9fa; padding: 1.5rem; border-radius: 12px; transition: all 0.3s ease; margin-bottom: 1rem;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" style="width: 100px; height: 80px; object-fit: contain; border-radius: 8px;">
                        <div style="flex: 1;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem; font-weight: 600;"><?php echo htmlspecialchars($car['name']); ?></h3>
                            <div style="color: #666; font-size: 0.9rem;"><?php echo htmlspecialchars($car['reviews']); ?> • <?php echo htmlspecialchars($car['rents']); ?></div>
                            <div style="font-weight: 600; margin-top: 0.5rem; color: #1a1a1a;"><?php echo htmlspecialchars($car['price']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>
