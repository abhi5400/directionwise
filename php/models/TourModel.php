<?php
/**
 * Tour Model
 * Handles tour data operations (JSON and MySQL support)
 */

class TourModel {
    private $db = null;
    private $useDb = false;
    private $dataFile;

    public function __construct() {
        $this->useDb = USE_DB;
        $this->dataFile = DATA_PATH . '/tours.json';

        if ($this->useDb) {
            $this->connectDb();
        }
    }

    /**
     * Connect to MySQL database
     */
    private function connectDb() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            $this->useDb = false; // Fallback to JSON
        }
    }

    /**
     * Get all tours
     */
    public function getAll() {
        if ($this->useDb && $this->db) {
            return $this->getAllFromDb();
        }
        return $this->getAllFromJson();
    }

    /**
     * Get tour by ID
     */
    public function getById($id) {
        if ($this->useDb && $this->db) {
            return $this->getByIdFromDb($id);
        }
        return $this->getByIdFromJson($id);
    }

    /**
     * Get tour by slug
     */
    public function getBySlug($slug) {
        if ($this->useDb && $this->db) {
            return $this->getBySlugFromDb($slug);
        }
        return $this->getBySlugFromJson($slug);
    }

    /**
     * Save tour (create or update)
     */
    public function save($tour) {
        if ($this->useDb && $this->db) {
            return $this->saveToDb($tour);
        }
        return $this->saveToJson($tour);
    }

    /**
     * Delete tour
     */
    public function delete($id) {
        if ($this->useDb && $this->db) {
            return $this->deleteFromDb($id);
        }
        return $this->deleteFromJson($id);
    }

    // JSON Methods
    private function getAllFromJson() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $content = file_get_contents($this->dataFile);
        $tours = json_decode($content, true);
        return $tours ?: [];
    }

    private function getByIdFromJson($id) {
        $tours = $this->getAllFromJson();
        foreach ($tours as $tour) {
            if (isset($tour['id']) && $tour['id'] == $id) {
                return $tour;
            }
        }
        return null;
    }

    private function getBySlugFromJson($slug) {
        $tours = $this->getAllFromJson();
        foreach ($tours as $tour) {
            if (isset($tour['slug']) && $tour['slug'] === $slug) {
                return $tour;
            }
        }
        return null;
    }

    private function saveToJson($tour) {
        $tours = $this->getAllFromJson();
        
        if (isset($tour['id'])) {
            // Update existing
            foreach ($tours as $key => $existing) {
                if ($existing['id'] == $tour['id']) {
                    $tours[$key] = $tour;
                    break;
                }
            }
        } else {
            // Create new
            $tour['id'] = $this->getNextId($tours);
            $tour['created_at'] = date('c');
            $tours[] = $tour;
        }

        return file_put_contents($this->dataFile, json_encode($tours, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function deleteFromJson($id) {
        $tours = $this->getAllFromJson();
        $tours = array_filter($tours, function($tour) use ($id) {
            return $tour['id'] != $id;
        });
        $tours = array_values($tours);
        return file_put_contents($this->dataFile, json_encode($tours, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function getNextId($tours) {
        if (empty($tours)) {
            return 1;
        }
        $ids = array_column($tours, 'id');
        return max($ids) + 1;
    }

    // Database Methods
    private function getAllFromDb() {
        $stmt = $this->db->query("SELECT * FROM tours ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    private function getByIdFromDb($id) {
        $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function getBySlugFromDb($slug) {
        $stmt = $this->db->prepare("SELECT * FROM tours WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    private function saveToDb($tour) {
        if (isset($tour['id'])) {
            // Update
            $stmt = $this->db->prepare("
                UPDATE tours SET 
                    slug = ?, title = ?, excerpt = ?, description = ?, 
                    duration = ?, price_from = ?, currency = ?, 
                    image = ?, image_webp = ?, images = ?, tags = ?, 
                    updated_at = NOW()
                WHERE id = ?
            ");
            return $stmt->execute([
                $tour['slug'], $tour['title'], $tour['excerpt'], $tour['description'],
                $tour['duration'], $tour['price_from'], $tour['currency'],
                $tour['image'], $tour['image_webp'] ?? '', 
                json_encode($tour['images'] ?? []), json_encode($tour['tags'] ?? []),
                $tour['id']
            ]);
        } else {
            // Insert
            $stmt = $this->db->prepare("
                INSERT INTO tours (slug, title, excerpt, description, duration, 
                    price_from, currency, image, image_webp, images, tags, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            return $stmt->execute([
                $tour['slug'], $tour['title'], $tour['excerpt'], $tour['description'],
                $tour['duration'], $tour['price_from'], $tour['currency'],
                $tour['image'], $tour['image_webp'] ?? '',
                json_encode($tour['images'] ?? []), json_encode($tour['tags'] ?? [])
            ]);
        }
    }

    private function deleteFromDb($id) {
        $stmt = $this->db->prepare("DELETE FROM tours WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

