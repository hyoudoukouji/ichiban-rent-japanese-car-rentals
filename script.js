// Sample data for cars
const carsData = [
    {
        id: 1,
        name: 'Toyota Sprinter Trueno AE86',
        price: 'Rp 8.120.000',
        reviews: '2000+ Reviews',
        rating: 4.9,
        description: 'Powered by the legendary 1.6-liter 4A-GE DOHC engine, this lightweight machine delivers sharp throttle response and high-revving excitement.',
        image: 'data:image/svg+xml,%3Csvg width=\'400\' height=\'250\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'400\' height=\'250\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'200\' y=\'125\' font-family=\'Arial\' font-size=\'24\' fill=\'white\' text-anchor=\'middle\'%3EToyota AE86%3C/text%3E%3C/svg%3E'
    },
    {
        id: 2,
        name: 'Honda Civic Sir-II',
        price: 'Rp 3.020.000',
        reviews: '2200 Reviews',
        rating: 4.7,
        rents: '150 Rent',
        image: 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EHonda Civic%3C/text%3E%3C/svg%3E'
    },
    {
        id: 3,
        name: 'Mazda RX-7 Type R',
        price: 'Rp 5.027.000',
        reviews: '1800 Reviews',
        rating: 4.8,
        rents: '120 Rent',
        image: 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EMazda RX-7%3C/text%3E%3C/svg%3E'
    }
];

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    try {
        initializeNavigation();
        initializeHeaderActions();
        
        // Initialize page-specific content
        const currentPage = getCurrentPage();
        switch (currentPage) {
            case 'index':
            case '':
                initializeTopRentSection();
                initializeColorSelection();
                initializeDurationControls();
                initializeFavoriteButton();
                initializeRentButton();
                break;
            case 'explore':
                initializeExploreSection();
                break;
            case 'saved':
                initializeSavedSection();
                break;
            case 'cart':
                initializeCartSection();
                break;
            case 'history':
                initializeHistorySection();
                break;
            case 'profile':
                initializeProfileSection();
                break;
        }

        // Initialize common elements
        initializeSearch();
        initializeImageHandling();
    } catch (error) {
        console.error('Error during initialization:', error);
    }
});

// Get current page name from URL
function getCurrentPage() {
    const path = window.location.pathname;
    const page = path.split('/').pop().split('.')[0];
    return page || 'index';
}

// Initialize navigation
function initializeNavigation() {
    try {
        const navItems = document.querySelectorAll('nav ul li');
        if (!navItems.length) {
            throw new Error('Navigation items not found');
        }
        
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                navItems.forEach(navItem => navItem.classList.remove('active'));
                item.classList.add('active');
            });
        });
    } catch (error) {
        console.error('Error in navigation:', error);
    }
}

// Initialize header actions
function initializeHeaderActions() {
    try {
        const messageBtn = document.querySelector('.icon-btn i.fa-envelope')?.parentElement;
        const notificationBtn = document.querySelector('.icon-btn i.fa-bell')?.parentElement;
        const profileBtn = document.querySelector('.profile-btn');

        if (messageBtn) {
            messageBtn.addEventListener('click', () => {
                try {
                    console.log('Messages clicked');
                    messageBtn.style.transform = 'scale(0.95)';
                    setTimeout(() => messageBtn.style.transform = 'scale(1)', 200);
                } catch (error) {
                    console.error('Error handling message button click:', error);
                }
            });
        }

        if (notificationBtn) {
            notificationBtn.addEventListener('click', () => {
                try {
                    console.log('Notifications clicked');
                    notificationBtn.style.transform = 'scale(0.95)';
                    setTimeout(() => notificationBtn.style.transform = 'scale(1)', 200);
                } catch (error) {
                    console.error('Error handling notification button click:', error);
                }
            });
        }

        if (profileBtn) {
            profileBtn.addEventListener('click', () => {
                try {
                    console.log('Profile clicked');
                    profileBtn.style.transform = 'scale(0.95)';
                    setTimeout(() => profileBtn.style.transform = 'scale(1)', 200);
                } catch (error) {
                    console.error('Error handling profile button click:', error);
                }
            });
        }
    } catch (error) {
        console.error('Error initializing header actions:', error);
    }
}

// Initialize search functionality
function initializeSearch() {
    try {
        const searchInput = document.querySelector('.search-bar input');
        const filterBtn = document.querySelector('.filter-btn');

        if (searchInput && filterBtn) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = e.target.value.toLowerCase().trim();
                    handleSearch(searchTerm);
                }, 300);
            });

            filterBtn.addEventListener('click', () => {
                console.log('Filter clicked');
            });
        }
    } catch (error) {
        console.error('Error in search initialization:', error);
    }
}

// Handle search functionality
function handleSearch(searchTerm) {
    try {
        const filteredCars = carsData.filter(car => 
            car.name.toLowerCase().includes(searchTerm)
        );
        console.log('Search results:', filteredCars);
        // Update UI based on search results
        updateSearchResults(filteredCars);
    } catch (error) {
        console.error('Error handling search:', error);
    }
}

// Update search results in UI
function updateSearchResults(results) {
    try {
        const carGrid = document.querySelector('.car-grid');
        if (!carGrid) return;

        carGrid.innerHTML = '';
        results.forEach(car => {
            const carCard = createCarCard(car);
            carGrid.appendChild(carCard);
        });
    } catch (error) {
        console.error('Error updating search results:', error);
    }
}

// Create car card element
function createCarCard(car) {
    try {
        const card = document.createElement('div');
        card.className = 'car-card';
        card.innerHTML = `
            <img src="${car.image}" alt="${car.name}" onerror="this.src='https://via.placeholder.com/300x200?text=Car+Image'">
            <h3>${car.name}</h3>
            <div class="price">${car.price}</div>
            <div class="rating">
                <i class="fas fa-star"></i>
                <span>${car.rating}</span>
            </div>
            <button class="add-btn" data-car-id="${car.id}">+</button>
        `;

        // Add event listener to the add button
        const addBtn = card.querySelector('.add-btn');
        if (addBtn) {
            addBtn.addEventListener('click', () => addToCart(car));
        }

        return card;
    } catch (error) {
        console.error('Error creating car card:', error);
        return document.createElement('div');
    }
}

// Add to cart functionality
function addToCart(car) {
    try {
        // Check if cart is empty
        const currentCart = JSON.parse(localStorage.getItem('cart') || '[]');
        if (currentCart.length > 0) {
            alert('You can only rent one car at a time. Please complete or remove the current rental first.');
            return;
        }

        // Add car to cart
        localStorage.setItem('cart', JSON.stringify([car]));
        alert('Car added to cart successfully!');
        updateCartUI();
    } catch (error) {
        console.error('Error adding to cart:', error);
        alert('Failed to add car to cart. Please try again.');
    }
}

// Update cart UI
function updateCartUI() {
    try {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const emptyCart = document.getElementById('emptyCart');
        const cartContent = document.getElementById('cartContent');
        
        if (!emptyCart || !cartContent) return;

        if (cart.length === 0) {
            emptyCart.style.display = 'flex';
            cartContent.style.display = 'none';
        } else {
            emptyCart.style.display = 'none';
            cartContent.style.display = 'block';
            
            // Update cart item details
            const cartItem = cart[0];
            const cartItemElement = document.querySelector('.cart-item');
            if (cartItemElement) {
                cartItemElement.innerHTML = `
                    <img src="${cartItem.image}" alt="${cartItem.name}">
                    <div class="item-details">
                        <h3>${cartItem.name}</h3>
                        <div class="price">${cartItem.price}</div>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart()">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            }
        }
    } catch (error) {
        console.error('Error updating cart UI:', error);
    }
}

// Remove from cart
function removeFromCart() {
    try {
        localStorage.removeItem('cart');
        updateCartUI();
        alert('Car removed from cart successfully!');
    } catch (error) {
        console.error('Error removing from cart:', error);
        alert('Failed to remove car from cart. Please try again.');
    }
}

// Initialize image handling
function initializeImageHandling() {
    try {
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', () => {
                img.style.opacity = '1';
            });
            img.addEventListener('error', () => {
                img.src = 'https://via.placeholder.com/300x200?text=Image+Not+Found';
            });
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.3s ease';
        });
    } catch (error) {
        console.error('Error initializing image handling:', error);
    }
}

// Initialize profile section
function initializeProfileSection() {
    try {
        const saveChangesBtn = document.querySelector('.save-changes-btn');
        if (saveChangesBtn) {
            saveChangesBtn.addEventListener('click', () => {
                try {
                    // Collect form data
                    const formData = new FormData(document.querySelector('.profile-form'));
                    console.log('Saving profile changes:', Object.fromEntries(formData));
                    alert('Profile changes saved successfully!');
                } catch (error) {
                    console.error('Error saving profile changes:', error);
                    alert('Failed to save changes. Please try again.');
                }
            });
        }
    } catch (error) {
        console.error('Error initializing profile section:', error);
    }
}

// Initialize history section
function initializeHistorySection() {
    try {
        const sortFilter = document.getElementById('sortFilter');
        const statusFilter = document.getElementById('statusFilter');

        if (sortFilter) {
            sortFilter.addEventListener('change', () => {
                console.log('Sort by:', sortFilter.value);
                // Implement sorting logic
            });
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', () => {
                console.log('Filter by status:', statusFilter.value);
                // Implement status filtering logic
            });
        }
    } catch (error) {
        console.error('Error initializing history section:', error);
    }
}

// Initialize saved section
function initializeSavedSection() {
    try {
        const savedCars = JSON.parse(localStorage.getItem('savedCars') || '[]');
        const savedCarsContainer = document.querySelector('.saved-cars');
        const emptyState = savedCarsContainer?.querySelector('.empty-state');

        if (savedCarsContainer && emptyState) {
            if (savedCars.length === 0) {
                emptyState.style.display = 'flex';
            } else {
                emptyState.style.display = 'none';
                // Add saved cars to the container
                savedCars.forEach(car => {
                    const carCard = createCarCard(car);
                    savedCarsContainer.appendChild(carCard);
                });
            }
        }
    } catch (error) {
        console.error('Error initializing saved section:', error);
    }
}

// Initialize explore section
function initializeExploreSection() {
    try {
        const carGrid = document.querySelector('.car-grid');
        if (!carGrid) return;

        // Add all cars to the grid
        carsData.forEach(car => {
            const carCard = createCarCard(car);
            carGrid.appendChild(carCard);
        });
    } catch (error) {
        console.error('Error initializing explore section:', error);
    }
}
