<?php
header("Content-Type: text/xml; charset=utf-8");

// --- 1. LOGIKA AUTO-DETECT LOKASI FILE ---
// Cek protokol (HTTP atau HTTPS)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";

// Ambil path folder tempat file ini berada sekarang
// Contoh: jika file di /public_html/folder1/sitemap.php, maka hasilnya: /folder1/
$current_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

// Gabungkan menjadi URL Utuh ke folder ini
// Hasil: https://domainanda.com/folder1/
$root_url = $protocol . $_SERVER['HTTP_HOST'] . $current_dir;

// URL Target untuk index.php di folder yang sama
$target_url = $root_url . "index.php?id=";
$file_list  = "listnew.txt";

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= $root_url; ?>index.php</loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <?php
    // Baca file listnew.txt di folder yang sama
    if (file_exists($file_list)) {
        $lines = file($file_list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $slug = trim($line);
            if (!empty($slug)) {
    ?>
    <url>
        <loc><?= $target_url . htmlspecialchars($slug); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php
            }
        }
    }
    ?>
</urlset>
