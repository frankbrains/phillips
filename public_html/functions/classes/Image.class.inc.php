<?php
class bfImage {
  var $src = "";

  function bfImage($src) {
    $this->src = $src;
  }

  function Process($filename, $width, $height) {
    return $this->_resize($filename, $width, $height);
  }
  
  function _resize($new_img,$max_width,$max_height,$thumb=0) {
    $file = $this->src;
    $file_stats = getimagesize($this->src['tmp_name']);

    //Set ratio, determine width/height    
    if($file_stats[0] > $max_width || $file_stats[1] > $max_height) {
      if( ($file_stats[0]-$max_width) > ($file_stats[1] - $max_height)) {
        $ratio =  ( $file_stats[0] > $max_width ) ? (real)($max_width / $file_stats[0]) : 1 ;
        $new_width = $max_width;
        $new_height = ((int)($file_stats[1] * $ratio));
      } else {
        $ratio =  ( $file_stats[1] > $max_height ) ? (real)($max_height / $file_stats[1]) : 1 ;
        $new_width = ((int)($file_stats[0] * $ratio));
        $new_height = $max_height;
      }
    } else { $new_width = $file_stats[0]; $new_height = $file_stats[1]; }
  
    //Switch depending upon file type and process
    switch($file_stats[2]) {

    //File is a JPG
    case 2:
      $src_img = ImageCreateFromJpeg($file['tmp_name']);
      if(function_exists("ImageCreateTrueColor")) {
        if(!@$full_id = ImageCreateTrueColor( $new_width, $new_height )) { $full_id = ImageCreate( $new_width, $new_height ); }
      }
      else { $full_id = ImageCreate( $new_width, $new_height ); }
      if(function_exists("imageCopyResampled")) {
        if(!@ImageCopyResampled( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] )) {
          ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] );
        }
      } else { ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] ); }
      $bool = ImageJPEG( $full_id, $new_img, 100 );
      break;

      //File is a PNG
      case 3:
        $src_img = ImageCreateFromPng($file['tmp_name']);
        if(function_exists("ImageCreateTrueColor")) {
          if(!@$full_id = ImageCreateTrueColor( $new_width, $new_height )) { $full_id = ImageCreate( $new_width, $new_height ); }
       } else { $full_id = ImageCreate( $new_width, $new_height ); }
         if(function_exists("imageCopyResampled")) {
          if(!@ImageCopyResampled( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] )) {
            ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] );
          }
        }  else { ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] ); }
        if($thumb == 0) { ImagePNG( $full_id, $new_img ); }
        else { ImageJPEG( $full_id, $new_img, 100 ); }
        break;

      //File is a GIF
      case 1:
        $src_img = ImageCreateFromGif($file['tmp_name']);
        if(function_exists("ImageCreateTrueColor")) {
          if(!@$full_id = ImageCreateTrueColor( $new_width, $new_height )) { $full_id = ImageCreate( $new_width, $new_height ); }
        } else { $full_id = ImageCreate( $new_width, $new_height ); }
        if(function_exists("imageCopyResampled")) {
          if(!@ImageCopyResampled( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] )) {
            ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] );
          }
        } else { ImageCopyResized( $full_id, $src_img, 0,0, 0,0, $new_width, $new_height, $file_stats[0], $file_stats[1] ); }
        if($thumb == 0) { $bool = ImagePNG( $full_id, $new_img ); }
        else { $bool = ImageJPEG( $full_id, $new_img, 100 ); }
        break;
    }
    return true;
  }

}
?>