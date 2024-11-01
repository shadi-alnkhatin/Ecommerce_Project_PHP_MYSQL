<?php

class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getProducts($page = 1, $league_id = null, $team_id = null, $minPrice = null, $maxPrice = null, $perPage = 9) {
        $query = "SELECT * FROM products WHERE 1=1";
        
        if ($league_id !== null) {
            $query .= " AND league_id = :league_id";
        }
        if ($team_id !== null) {
            $query .= " AND team_id = :team_id";
        }
        if ($minPrice !== null) {
            $query .= " AND price >= :minPrice";
        }
        if ($maxPrice !== null) {
            $query .= " AND price <= :maxPrice";
        }
    
        // Calculate offset for pagination
        $offset = max(0, ($page - 1) * $perPage);
        $query .= " LIMIT :offset, :limit";
        
        $stmt = $this->db->prepare($query);
    
        // Bind parameters if they are set
        if ($league_id !== null) $stmt->bindParam(':league_id', $league_id, PDO::PARAM_INT);
        if ($team_id !== null) $stmt->bindParam(':team_id', $team_id, PDO::PARAM_INT);
        if ($minPrice !== null) $stmt->bindParam(':minPrice', $minPrice, PDO::PARAM_STR);
        if ($maxPrice !== null) $stmt->bindParam(':maxPrice', $maxPrice, PDO::PARAM_STR);
        
        // Bind offset and limit with integer parameters
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductsDetails($product_id){
        $stmt = $this->db->prepare("SELECT * FROM products  WHERE id = :product_id ");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getProductImages($product_id){
        $stmt = $this->db->prepare('SELECT image_url FROM product_images WHERE product_id = :id');
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchProducts($query) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE :query");
        $searchQuery = '%' . $query . '%';
        $stmt->bindParam(':query', $searchQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts($league_id = null, $team_id = null, $minPrice = null, $maxPrice = null) {
        // Start with the base query to count products
        $query = "SELECT COUNT(*) FROM products WHERE 1=1";
        
        // Add conditions based on filters provided
        if ($league_id !== null) {
            $query .= " AND league_id = :league_id";
        }
        if ($team_id !== null) {
            $query .= " AND team_id = :team_id";
        }
        if ($minPrice !== null) {
            $query .= " AND price >= :minPrice";
        }
        if ($maxPrice !== null) {
            $query .= " AND price <= :maxPrice";
        }
        
        // Prepare and bind parameters
        $stmt = $this->db->prepare($query);
        if ($league_id !== null) $stmt->bindParam(':league_id', $league_id);
        if ($team_id !== null) $stmt->bindParam(':team_id', $team_id);
        if ($minPrice !== null) $stmt->bindParam(':minPrice', $minPrice);
        if ($maxPrice !== null) $stmt->bindParam(':maxPrice', $maxPrice);
        
        // Execute and return total count
        $stmt->execute();
        return $stmt->fetchColumn(); // Returns the total number of matching products
    }
    
    

}

