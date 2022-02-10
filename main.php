<?php

require __DIR__ .'/vendor/autoload.php';

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\WebDriverBy;


function expand_shadow_element($element, $driver)
{
    $shadow_root = $driver->execute_script('return arguments[0].shadowRoot', $element);
    return $shadow_root;
}

function hello_world()
{
    // 環境変数にドライバパスを設定
    putenv('webdriver.chrome.driver=' . __DIR__ . '\chromedriver.exe');
    
    // Chrome を起動してページ遷移する
    $driver = ChromeDriver::start();
    $driver->get('https://shopping.yahoo.co.jp/category/10002/list?X=4&view=grid&sc_i=shp_pc_cate-rcmd-10002_more&b=1');
    sleep(3);

    // write 'PHP' in the search box
    $element1 = $driver->findElements(WebDriverBy::className('_2EW-04-9Eayr')); 
    $element2 = $driver->findElements(WebDriverBy::className('_3Z3ly613XmPi')); 
    // var_dump($element);

    // $element = $driver->executeScript('return document.getElementsByTagName("ntp-app")[0]');
    $result1 = $element1[0]->getText(); // fill the search box
    $result2 = $element2[0]->getText(); // fill the search box
    
    var_dump($result1);
    var_dump($result2);

    sleep(3);
    $driver->close();

    $ary = array(
        array("タイトル", "値段"),
        array($result1, $result2)
       );

    //    var_dump($ary);

      // ファイルを書き込み用に開きます。
      $f = fopen("test.csv", "w");
      // 正常にファイルを開くことができていれば、書き込みます。
      if ( $f ) {
        // $ary から順番に配列を呼び出して書き込みます。
        foreach($ary as $line){
          // fputcsv関数でファイルに書き込みます。
          fputcsv($f, $line);
        } 
      }
      // ファイルを閉じます。
      fclose($f);
}

hello_world();

