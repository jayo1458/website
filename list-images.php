<?php
header('Content-Type: application/json');

$portfolio_dir = 'imgs/portfolio/';
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
$images = [];

// 讀取圖片目錄
if (is_dir($portfolio_dir)) {
    $files = scandir($portfolio_dir);
    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed_types)) {
            // 嘗試讀取對應的 JSON 檔案獲取標題和描述
            $json_file = $portfolio_dir . pathinfo($file, PATHINFO_FILENAME) . '.json';
            $metadata = [];
            
            if (file_exists($json_file)) {
                $metadata = json_decode(file_get_contents($json_file), true);
            }
            
            $images[] = [
                'path' => $portfolio_dir . $file,
                'title' => $metadata['title'] ?? null,
                'description' => $metadata['description'] ?? null
            ];
        }
    }
}

echo json_encode($images); 