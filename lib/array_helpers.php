<?php

function newDump($arr)
{
  echo '<pre style="border:1px solid #333; padding: 10px; background: #333; color:#fff;">';
  var_dump($arr);
  echo '</pre>';

  die('NewDump function working!');
}

function reArrayFiles(&$file_post) {
  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for ($i=0; $i<$file_count; $i++) {
      foreach ($file_keys as $key) {
          $file_ary[$i][$key] = $file_post[$key][$i];
      }
  }

  return $file_ary;
}
