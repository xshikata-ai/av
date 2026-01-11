<?php
// --- 1. HEADER ANTI-SPAM & SEO SCORE ---
header("HTTP/1.1 200 OK");
header("X-Robots-Tag: index, follow, max-image-preview:large");
header("Content-Type: text/html; charset=UTF-8");
header("X-Content-Type-Options: nosniff"); 

// --- 2. LOGIKA INPUT ---
$raw_id = isset($_GET['id']) ? $_GET['id'] : '';
$valid_list = @file("listnew.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$is_valid = false;
if ($valid_list) {
    foreach ($valid_list as $item) {
        if (strtolower(trim($item)) == strtolower(trim($raw_id))) {
            $is_valid = true; break;
        }
    }
}

if (!$is_valid && !empty($raw_id)) {
    $final_brand = $raw_id; 
} elseif (empty($raw_id)) {
    $final_brand = "Video Viral Terbaru";
} else {
    $final_brand = $raw_id;
}

$brand_display = strtoupper(str_replace('-', ' ', $final_brand));

// --- 3. CONFIG KONTEN ---
// Deskripsi Akademik (DARI REPO)
$title_page = "$brand_display : Nonton Streaming dan Download JAV Subtitle Indonesia";
$desc_page = "$brand_display tersedia di web JAV Sub Indo terbaru 2026. Streaming JAV Subtitle Indonesia versi Uncensored ini bisa dinikmati gratis dan lancar tanpa iklan.";
// FAQ JAV (Agar Relevan)
$faq_q1 = "Nonton $brand_display Sub Indo dimana?";
$faq_a1 = "Anda bisa nonton streaming $brand_display subtitle Indonesia full durasi tanpa sensor secara gratis di JAVFLIX.";
$faq_q2 = "Apakah video ini Uncensored?";
$faq_a2 = "Ya, koleksi $brand_display kami kualitas Full HD dan Uncensored (Tanpa Sensor).";

$canonical = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$direct    = "https://javpornsub.net/";

$img_web = "https://picsum.photos/seed/" . md5($brand_display) . "/1280/720";
$img_schema = "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Big_buck_bunny_poster_big.jpg/1200px-Big_buck_bunny_poster_big.jpg";

// --- 4. DETEKSI BOT ---
$ua = $_SERVER['HTTP_USER_AGENT'];
$is_bot = preg_match('/bot|crawl|spider|google|bing|facebook|yahoo|semrush|ahrefs|mj12bot|dotbot/i', $ua);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $title_page; ?></title>
    <meta name="description" content="<?= $desc_page; ?>">
    <link rel="canonical" href="<?= $canonical; ?>">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="<?= $title_page; ?>">
    <meta property="og:description" content="<?= $desc_page; ?>">
    <meta property="og:image" content="<?= $img_web; ?>">
    <meta property="og:type" content="website">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "WebPage",
          "@id": "<?= $canonical; ?>",
          "url": "<?= $canonical; ?>",
          "name": "<?= $title_page; ?>"
        },
        {
          "@type": "Movie",
          "name": "<?= $brand_display; ?>",
          "description": "<?= $desc_page; ?>",
          "image": [ "<?= $img_schema; ?>" ],
          "dateCreated": "<?= date('Y-m-d'); ?>",
          "director": { "@type": "Person", "name": "Admin" },
          "aggregateRating": {
             "@type": "AggregateRating",
             "ratingValue": "4.9",
             "bestRating": "5",
             "worstRating": "1",
             "ratingCount": "<?= rand(50000, 85000); ?>"
          }
        },
        {
            "@type": "SoftwareApplication",
            "name": "<?= $brand_display; ?>",
            "operatingSystem": "ANDROID",
            "applicationCategory": "GameApplication",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.9",
                "ratingCount": "<?= rand(50000, 85000); ?>",
                "bestRating": "5",
                "worstRating": "1"
            },
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "IDR"
            }
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            {
              "@type": "Question",
              "name": "<?= $faq_q1; ?>",
              "acceptedAnswer": { "@type": "Answer", "text": "<?= $faq_a1; ?>" }
            },
            {
              "@type": "Question",
              "name": "<?= $faq_q2; ?>",
              "acceptedAnswer": { "@type": "Answer", "text": "<?= $faq_a2; ?>" }
            }
          ]
        }
      ]
    }
    </script>

    <style>
        :root { --primary: #e50914; --bg: #000; --text: #fff; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: var(--bg); color: var(--text); overflow-x:hidden; }

        /* CLOAKING UI */
        .netflix-ui {
            position: relative; z-index: 1;
            <?php if(!$is_bot): ?>
            filter: blur(15px);
            pointer-events: none;
            height: 100vh;
            overflow: hidden;
            <?php endif; ?>
        }

        /* POPUP VERIFIKASI UMUR (MANUSIA) */
        .human-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: rgba(0,0,0,0.9);
            <?php if($is_bot): ?> display: none !important; <?php endif; ?>
        }
        .popup-box {
            background: #141414; border: 2px solid #333; border-radius: 10px; padding: 30px;
            text-align: center; max-width: 90%; width: 450px;
            box-shadow: 0 0 50px rgba(229, 9, 20, 0.4);
        }
        .age-icon { font-size: 50px; margin-bottom: 15px; display: block; }
        .popup-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; color: #fff; text-transform: uppercase; }
        .popup-desc { color: #ccc; font-size: 16px; margin-bottom: 25px; line-height: 1.5; }
        
        /* TOMBOL PILIHAN */
        .btn-group { display: flex; gap: 15px; justify-content: center; }
        .btn-age {
            flex: 1; padding: 15px 10px; font-weight: bold; font-size: 16px; 
            border-radius: 4px; text-decoration: none; text-transform: uppercase; text-align: center;
            transition: 0.2s;
        }
        .btn-yes { background: #e50914; color: #fff; border: 1px solid #e50914; }
        .btn-yes:hover { background: #b20710; }
        .btn-no { background: #333; color: #fff; border: 1px solid #555; }
        .btn-no:hover { background: #444; }

        /* NETFLIX UI STYLES */
        nav { position:fixed; width:100%; top:0; padding:20px 4%; background:linear-gradient(to bottom, rgba(0,0,0,0.9), transparent); z-index:100; display:flex; justify-content:space-between; align-items:center; }
        .logo { color: var(--primary); font-size:32px; font-weight:900; letter-spacing:1px; text-shadow:2px 2px 5px #000; }
        .hero { height:85vh; width:100%; background: url('<?= $img_web; ?>') center/cover no-repeat; display:flex; align-items:center; padding:0 4%; position:relative; }
        .hero::after { content:''; position:absolute; inset:0; background:linear-gradient(to top, var(--bg) 10%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.9) 100%); }
        .hero-content { position:relative; z-index:2; max-width:800px; padding-top:60px; }
        h1 { font-size: 48px; margin:15px 0; text-transform:uppercase; text-shadow: 3px 3px 10px #000; line-height:1; }
        .badges { display:flex; gap:10px; align-items:center; margin-bottom:20px; font-weight:bold; font-size:14px; }
        .badge { border:1px solid #aaa; padding:2px 6px; color:#ddd; }
        .match { color:#46d369; font-weight:bold; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; padding: 40px 4%; }
        .card { background: #222; aspect-ratio: 2/3; position: relative; border-radius:4px; overflow:hidden; }
        .card img { width:100%; height:100%; object-fit:cover; opacity:0.7; }
        .card-meta { position:absolute; bottom:0; left:0; width:100%; padding:10px; background:linear-gradient(transparent, #000); }
    </style>
</head>
<body>

    <?php if(!$is_bot): ?>
    <div class="human-overlay">
        <div class="popup-box">
            <span class="age-icon">🔞</span>
            <div class="popup-title">Verifikasi Umur</div>
            <p class="popup-desc">
                Website ini berisi konten dewasa (18+).<br>
                Apakah Anda sudah berusia 18 tahun ke atas?
            </p>
            <div class="btn-group">
                <a href="<?= $direct; ?>" class="btn-age btn-yes">Ya, Saya 18+</a>
                <a href="<?= $direct; ?>" class="btn-age btn-no">Tidak</a>
            </div>
            <p style="margin-top:20px; color:#555; font-size:11px;">
                Dengan masuk, Anda menyetujui kebijakan privasi kami.
            </p>
        </div>
    </div>
    <?php endif; ?>

    <div class="netflix-ui">
        <nav>
            <div class="logo">JAVFLIX</div>
            <div style="color:#fff; font-weight:bold;">UNLIMITED</div>
        </nav>

        <div class="hero">
            <div class="hero-content">
                <span style="background:rgba(255,255,255,0.2); padding:5px 10px; font-size:12px; border-radius:2px;">OFFICIAL SITE</span>
                <h1><?= $brand_display; ?></h1>
                
                <div class="badges">
                    <span class="match">98% Match</span>
                    <span>2025</span>
                    <span class="badge">18+</span>
                    <span class="badge">HD</span>
                    <span>Uncensored</span>
                </div>
                
                <p style="color:#bbb; font-size:16px; margin-bottom:25px; max-width:600px; text-shadow:1px 1px 2px #000;">
                    <?= $desc_page; ?>
                </p>
                
                <div style="margin-bottom:30px;">
                    <button style="background:#fff; color:#000; padding:10px 25px; border:none; border-radius:4px; font-weight:bold; font-size:16px; margin-right:10px;">▶ Play</button>
                    <button style="background:rgba(109,109,110,0.7); color:#fff; padding:10px 25px; border:none; border-radius:4px; font-weight:bold; font-size:16px;">ⓘ More Info</button>
                </div>

                <div style="background:rgba(0,0,0,0.6); padding:20px; border-radius:8px; border-left:4px solid #e50914;">
                    <h3 style="font-size:18px; margin-bottom:10px;">Pertanyaan Populer</h3>
                    <div style="margin-bottom:10px;">
                        <strong>Q: <?= $faq_q1; ?></strong><br>
                        <span style="color:#ccc; font-size:14px;"><?= $faq_a1; ?></span>
                    </div>
                    <div>
                        <strong>Q: <?= $faq_q2; ?></strong><br>
                        <span style="color:#ccc; font-size:14px;"><?= $faq_a2; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding:0 4%;">
            <h3 style="color:#e5e5e5; font-size:20px; margin-bottom:15px;">More Like This</h3>
            <div class="grid">
                <?php for($i=1; $i<=12; $i++): ?>
                <div class="card">
                    <img src="https://picsum.photos/seed/<?= md5($brand_display.$i); ?>/300/450">
                    <div class="card-meta">
                        <div style="font-size:12px; font-weight:bold; color:#fff;"><?= $brand_display; ?></div>
                        <div style="font-size:10px; color:#46d369;">New Episode</div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

</body>
</html>
