 <?php
header("Content-Type: text/xml");

// Ubah brand_list.txt sesuai dengan file list anda
$brandList = file("listnew.txt", FILE_IGNORE_NEW_LINES);

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

foreach ($brandList as $brand) {
    $url = "https://iptapsel.ac.id/dosen/?jurusan=$brand";
    $sitemap .= '<url>' . PHP_EOL;
    $sitemap .= '<loc>' . $url . '</loc>' . PHP_EOL;
    $sitemap .= '<lastmod>' . date('c', time()) . '</lastmod>' . PHP_EOL;
    $sitemap .= '<priority>0.8</priority>' . PHP_EOL;
    $sitemap .= '</url>' . PHP_EOL;
}

$sitemap .= '</urlset>' . PHP_EOL;

// Simpan sitemap sebagai file sitemap.xml
file_put_contents('sitemap.xml', $sitemap);

echo $sitemap;
?>
