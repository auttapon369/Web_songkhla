<?php
$file_png=$_GET['path'];
$url = '../../../data/img/map/floodmap/'.$file_png;

$picture = imagecreatefrompng($url);

$img_w = imagesx($picture);
$img_h = imagesy($picture);

$newPicture = imagecreatetruecolor( $img_w, $img_h );
imagesavealpha( $newPicture, true );
$rgb = imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 );
imagefill( $newPicture, 0, 0, $rgb );

$color = imagecolorat( $picture, $img_w-1, 1);

for( $x = 0; $x < $img_w; $x++ ) {
    for( $y = 0; $y < $img_h; $y++ ) {
        $c = imagecolorat( $picture, $x, $y );
        if($color!=$c){         
            imagesetpixel( $newPicture, $x, $y,    $c);             
        }           
    }
}
header('Content-type: image/png');
imagepng($newPicture);
imagedestroy($newPicture);
imagedestroy($picture);
exit;

?>