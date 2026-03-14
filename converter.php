<?php

// Caminhos
$origem = __DIR__ . "/public/assets/img/logo1.jpg"; 
$pastaDestino = __DIR__ . "/public/assets/img/";

if (!file_exists($origem)) {
    die("ERRO: Arquivo não encontrado em: $origem\n");
}

// Detecta o tipo real do arquivo (independente da extensão)
$info = getimagesize($origem);
$mime = $info['mime'];

echo "Tipo de arquivo detectado: $mime\n";

// Carrega a imagem de acordo com o tipo real
if ($mime == 'image/png') {
    $img = imagecreatefrompng($origem);
} elseif ($mime == 'image/jpeg') {
    $img = imagecreatefromjpeg($origem);
} else {
    die("ERRO: O arquivo precisa ser PNG ou JPG.\n");
}

$largura = imagesx($img);
$altura = imagesy($img);

echo "Processando...\n";

// --- 1. VERSÃO PRETO E BRANCO ---
$imgPB = imagecreatetruecolor($largura, $altura);
imagecopy($imgPB, $img, 0, 0, 0, 0, $largura, $altura);
imagefilter($imgPB, IMG_FILTER_GRAYSCALE);
imagepng($imgPB, $pastaDestino . "logo-pb.png");
echo "- logo-pb.png criada!\n";

// --- 2. FAVICON ---
$tamanhoFavicon = 32;
$favicon = imagecreatetruecolor($tamanhoFavicon, $tamanhoFavicon);

// Tratar transparência se for PNG
imagealphablending($favicon, false);
imagesavealpha($favicon, true);
$transparente = imagecolorallocatealpha($favicon, 255, 255, 255, 127);
imagefill($favicon, 0, 0, $transparente);

imagecopyresampled($favicon, $img, 0, 0, 0, 0, $tamanhoFavicon, $tamanhoFavicon, $largura, $altura);
imagepng($favicon, $pastaDestino . "favicon.png");
echo "- favicon.png criado!\n";

imagedestroy($img);
imagedestroy($imgPB);
imagedestroy($favicon);

echo "\nConcluído com sucesso!\n";
