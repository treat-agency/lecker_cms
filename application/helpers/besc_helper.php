<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

function rand_string($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    $str = base64_encode(openssl_random_pseudo_bytes($length, $strong));
    $str = substr($str, 0, $length);
    $str = preg_replace("/[^a-zA-Z0-9\s]/", "", $str);
    return $str;
}

function ip_address_to_number($IPaddress)
{
    if ($IPaddress == '')
    {
        return 0;
    }
    else
    {
        $ips = explode('.', $IPaddress);
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 65536 + $ips[0] * 16777216);
    }
}

function check_hash($hash, $stored_hash)
{
    require_once (APPPATH . 'libraries/PasswordHash.php');
    $hasher = new PasswordHash(8, false);
    return $hasher->CheckPassword($hash, $stored_hash);
}

function purify($dirty_html)
{
    require_once (APPPATH . 'libraries/htmlPurifier/HTMLPurifier.standalone.php');
    $config = HTMLPurifier_Config::createDefault();
    $config->set('Core.Encoding', 'UTF-8');
    $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
    $config->set('HTML.TidyLevel', 'light');
    $config->set('HTML.Allowed', 'b,strong,a[href],i,em,ul,ol,li,p,img[alt],img[src],u,h1,h2');
    $purifier = new HTMLPurifier($config);

    $clean_html = $purifier->purify($dirty_html);

    return $clean_html;
}

FUNCTION inverseHex($color)
{
    $color = TRIM($color);
    $prependHash = FALSE;
    IF (STRPOS($color, '#') !== FALSE)
    {
        $prependHash = TRUE;
        $color = STR_REPLACE('#', NULL, $color);
    }
    SWITCH ($len = STRLEN($color))
    {
        CASE 3:
            $color = PREG_REPLACE("/(.)(.)(.)/", "\\1\\1\\2\\2\\3\\3", $color);
        CASE 6:
            BREAK;
        DEFAULT:
            TRIGGER_ERROR("Invalid hex length ($len). Must be (3) or (6)", E_USER_ERROR);
    }

    IF (! PREG_MATCH('/[a-f0-9]{6}/i', $color))
    {
        $color = HTMLENTITIES($color);
        TRIGGER_ERROR("Invalid hex string #$color", E_USER_ERROR);
    }

    $r = DECHEX(255 - HEXDEC(SUBSTR($color, 0, 2)));
    $r = (STRLEN($r) > 1) ? $r : '0' . $r;
    $g = DECHEX(255 - HEXDEC(SUBSTR($color, 2, 2)));
    $g = (STRLEN($g) > 1) ? $g : '0' . $g;
    $b = DECHEX(255 - HEXDEC(SUBSTR($color, 4, 2)));
    $b = (STRLEN($b) > 1) ? $b : '0' . $b;

    RETURN ($prependHash ? '#' : NULL) . $r . $g . $b;
}




/**
 * weighted_random()
 * Randomly select one of the elements based on their weights. Optimized for a large number of elements.
 *
 * @param array $values Array of elements to choose from
 * @param array $weights An array of weights. Weight must be a positive number.
 * @param array $lookup Sorted lookup array
 * @param int $total_weight Sum of all weights
 * @return mixed Selected element
 */
function weighted_random($values, $weights, $lookup = null, $total_weight = null){
    if ($lookup == null) {
        list($lookup, $total_weight) = calc_lookups($weights);
    }

    $r = mt_rand(0, $total_weight);
    return $values[binary_search($r, $lookup)];
}

/**
 * calc_lookups()
 * Build the lookup array to use with binary search
 *
 * @param array $weights
 * @return array The lookup array and the sum of all weights
 */
function calc_lookups($weights){
    $lookup = array();
    $total_weight = 0;

    for ($i=0; $i<count($weights); $i++){
        $total_weight += $weights[$i];
        $lookup[$i] = $total_weight;
    }
    return array($lookup, $total_weight);
}

/**
 * binary_search()
 * Search a sorted array for a number. Returns the item's index if found. Otherwise
 * returns the position where it should be inserted, or count($haystack)-1 if the
 * $needle is higher than every element in the array.
 *
 * @param int $needle
 * @param array $haystack
 * @return int
 */
function binary_search($needle, $haystack)
{
    $high = count($haystack)-1;
    $low = 0;

    while ( $low < $high ){
    $probe = (int)(($high + $low) / 2);
    if ($haystack[$probe] < $needle){
                $low = $probe + 1;
    } else if ($haystack[$probe] > $needle) {
        $high = $probe - 1;
    } else {
        return $probe;
    }
    }

    if ( $low != $high ){
        return $probe;
    } else {
    if ($haystack[$low] >= $needle) {
        return $low;
    } else {
        return $low+1;
    }
    }
}


function besc_trim($text, $length = 100, $options = array())
{
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => true
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) { return $text; }
  $totalLength=mb_strlen(strip_tags($ending)); $openTags=array(); $truncate='' ; preg_match_all('/(<\/?([\w+]+)[^>
  ]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
    foreach ($tags as $tag) {
    if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
      array_unshift($openTags, $tag[2]);
      } else if (preg_match('/<\ /([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
        $pos = array_search($closeTag[1], $openTags);
        if ($pos !== false) {
        array_splice($openTags, $pos, 1);
        }
        }
        }
        $truncate .= $tag[1];

        $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
        if ($contentLength + $totalLength > $length) {
        $left = $length - $totalLength;
        $entitiesLength = 0;
        if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities,
        PREG_OFFSET_CAPTURE)) {
        foreach ($entities[0] as $entity) {
        if ($entity[1] + 1 - $entitiesLength <= $left) { $left--; $entitiesLength +=mb_strlen($entity[0]); } else {
          break; } } } $truncate .=mb_substr($tag[3], 0 , $left + $entitiesLength); break; } else { $truncate .=$tag[3];
          $totalLength +=$contentLength; } if ($totalLength>= $length) {
          break;
          }
          }
          } else {
          if (mb_strlen($text) <= $length) { return $text; } else { $truncate=mb_substr($text, 0, $length -
            mb_strlen($ending)); } } if (!$exact) { $spacepos=mb_strrpos($truncate, ' ' ); if (isset($spacepos)) { if
            ($html) { $bits=mb_substr($truncate, $spacepos); preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags,
            PREG_SET_ORDER);
            if (!empty($droppedTags)) {
            foreach ($droppedTags as $closingTag) {
            if (!in_array($closingTag[1], $openTags)) {
            array_unshift($openTags, $closingTag[1]);
            }
            }
            }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
            }
            }
            $truncate .= $ending;

            if ($html) {
            foreach ($openTags as $tag) {
            $truncate .= '</'.$tag.'>';
            }
            }

            return $truncate;
            }



            function module_cmp($a, $b)
            {
            if($a['top'] < $b['top']) { return -1; } else if($a['top']> $b['top'])
              {
              return 1;
              }
              else
              {
              return 0;
              }
              }


              function resize_max($path, $maxWidth, $maxHeight)
              {
              /*$maxWidth = 500;
              $maxHeight = 1000;

              $path = "C:\\work\\tba21\\items\\uploads\\slider\\1470835701_ilXZkEpEwu2D.png";*/
              $basename = pathinfo($path, PATHINFO_FILENAME);

              list($width_orig, $height_orig, $image_type) = getimagesize($path);

              switch($image_type)
              {
              case 1:
              $img = imagecreatefromgif($path);
              break;
              case 2:
              $img = imagecreatefromjpeg($path);
              break;
              case 3:
              $img = imagecreatefrompng($path);
              break;
              }


              $new_height = 0;
              $new_width = 0;

              if($width_orig > $height_orig) // LANDSCAPE
              {
              if($width_orig > $maxWidth)
              {
              $width_ratio = $maxWidth / $width_orig;
              $new_width = intval($maxWidth);
              $new_height = intval($height_orig * $width_ratio);
              }
              }
              else // PORTRAIT
              {
              if($height_orig > $maxHeight)
              {
              $height_ratio = $maxHeight / $height_orig;
              $new_width = intval($width_orig * $height_ratio);
              $new_height = intval($maxHeight);
              }
              }

              if($new_height != 0 && $new_width != 0)
              {
              $new_img = imagecreatetruecolor($new_width, $new_height);
              imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);

              switch($image_type)
              {
              case 1:
              imagegif($new_img, $path);
              break;
              case 2:
              imagejpeg($new_img, $path, 100);
              break;
              case 3:
              imagepng($new_img, $path);
              break;
              }
              }
              }
              // echo "<img src='" . site_url(' items/uploads/slider/1470835701_ilXZkEpEwu2D.png') . "' />" ; }