<?php
require_once 'config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = isset($_POST['car_id']) ? (int)$_POST['car_id'] : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $userId = 1; // For now, we'll use a default user ID since we don't have authentication yet

    if ($carId !== null && $action) {
        try {
            if ($action === 'add') {
                // Check if already saved
                $stmt = $db->prepare("SELECT id FROM saved_cars WHERE user_id = :user_id AND car_id = :car_id");
                $stmt->bindValue(':user_id', $userId);
                $stmt->bindValue(':car_id', $carId);
                $result = $stmt->execute();
                
                if (!$result->fetchArray()) {
                    // Insert new saved car
                    $stmt = $db->prepare("INSERT INTO saved_cars (user_id, car_id) VALUES (:user_id, :car_id)");
                    $stmt->bindValue(':user_id', $userId);
                    $stmt->bindValue(':car_id', $carId);
                    $stmt->execute();
                    
                    // Update session
                    if (!isset($_SESSION['saved_cars'])) {
                        $_SESSION['saved_cars'] = [];
                    }
                    $_SESSION['saved_cars'][] = $carId;
                }
            } elseif ($action === 'remove') {
                // Remove from database
                $stmt = $db->prepare("DELETE FROM saved_cars WHERE user_id = :user_id AND car_id = :car_id");
                $stmt->bindValue(':user_id', $userId);
                $stmt->bindValue(':car_id', $carId);
                $stmt->execute();
                
                // Update session
                if (isset($_SESSION['saved_cars'])) {
                    $_SESSION['saved_cars'] = array_diff($_SESSION['saved_cars'], [$carId]);
                }
            }
            
            $response = ['success' => true];
        } catch(Exception $e) {
            $response = ['success' => false, 'error' => 'Database error'];
        }
    } else {
        $response = ['success' => false, 'error' => 'Invalid parameters'];
    }
} else {
    $response = ['success' => false, 'error' => 'Invalid request method'];
}

header('Content-Type: application/json');
echo json_encode($response);
