<?php
$dir = dirname(__DIR__) . '/assets/img';
if (!is_dir($dir)) {
    mkdir($dir, 0775, true);
}

$palette = [
    [179, 18, 44],
    [13, 21, 32],
    [42, 42, 42],
    [90, 24, 36],
    [28, 40, 56],
    [120, 40, 48],
];

$files = [
    'hero-accueil.jpg' => [1400, 900, 'Atelier', 0],
    'hero-actions.jpg' => [1400, 900, 'Terrain', 1],
    'hero-soutenir.jpg' => [1400, 900, 'Soutien', 4],
    'hero-about.jpg' => [1400, 900, 'Association', 1],
    'hero-ressources.jpg' => [1400, 900, 'Ressources', 2],
    'hero-contact.jpg' => [1400, 900, 'Contact', 4],
    'histoire.jpg' => [1200, 800, 'Histoire', 5],
    'article-1.jpg' => [1200, 760, 'Guide', 0],
    'article-2.jpg' => [1200, 760, 'Ecole', 1],
    'article-3.jpg' => [1200, 760, 'Sante', 3],
    'article-4.jpg' => [1200, 760, 'Droits', 4],
    'campagne-1.jpg' => [1200, 700, 'Silence', 0],
    'campagne-2.jpg' => [1200, 700, 'Dignite', 5],
    'campagne-3.jpg' => [1200, 700, 'Sang Peur', 1],
    'programme-1.jpg' => [800, 600, 'Club Rouge', 0],
    'programme-2.jpg' => [800, 600, 'Garantie', 4],
    'programme-3.jpg' => [800, 600, 'Camp Rouge', 1],
    'programme-4.jpg' => [800, 600, 'Menstrues', 3],
    'programme-5.jpg' => [800, 600, 'Rever', 5],
    'team-1.jpg' => [700, 860, 'A. Kone', 1],
    'team-2.jpg' => [700, 860, 'Y. Kouassi', 2],
    'team-3.jpg' => [700, 860, 'M-L. Adjoua', 0],
    'team-4.jpg' => [700, 860, 'F. Diallo', 4],
    'avatar-amelie.jpg' => [240, 240, 'A', 0],
    'avatar-thomas.jpg' => [240, 240, 'T', 1],
];

foreach ($files as $name => [$w, $h, $label, $pi]) {
    $im = imagecreatetruecolor($w, $h);
    $c1 = $palette[$pi % count($palette)];
    $c2 = $palette[($pi + 1) % count($palette)];
    for ($y = 0; $y < $h; $y++) {
        $t = $y / max(1, $h - 1);
        $col = imagecolorallocate(
            $im,
            (int) ($c1[0] + ($c2[0] - $c1[0]) * $t),
            (int) ($c1[1] + ($c2[1] - $c1[1]) * $t),
            (int) ($c1[2] + ($c2[2] - $c1[2]) * $t)
        );
        imageline($im, 0, $y, $w, $y, $col);
    }
    $white = imagecolorallocatealpha($im, 255, 255, 255, 90);
    imagefilledellipse($im, (int) ($w * 0.78), (int) ($h * 0.28), (int) ($w * 0.4), (int) ($h * 0.5), $white);
    $fg = imagecolorallocate($im, 255, 255, 255);
    $font = 5;
    imagestring($im, $font, 28, $h - 48, $label, $fg);
    imagejpeg($im, $dir . '/' . $name, 88);
    imagedestroy($im);
}

echo "Images générées dans $dir\n";
