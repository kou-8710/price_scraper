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

    //正規表現でカッコの付いた単語を削除する
    $result1 = preg_replace("/\〔.+?\〕/", "", $result1);
    $result1 = preg_replace("/\【.+?\】/", "", $result1);
    
    var_dump($result1);
    var_dump($result2);

    sleep(3);
    $driver->close();

    //csvファイルに表示する
    $ary = array(
        array("タイトル", "値段"),
        array($result1, $result2)
       );

    //    var_dump($ary);

      // ファイルを書き込み用に開きます。
       file_put_contents("test.html", "
       
       <!DOCTYPE html>
       <html lang=\"ja\">
       <head>
         <meta charset=\"UTF-8\">
         <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
         <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
         <title>ポートフォリオ</title>
       </head>
       <body>
        <table>
          <tr>
            <th>{$ary[0][0]}</th>
            <th>{$ary[0][1]}</th>
          </tr>
          <tr>
            <td>{$ary[1][0]}</td>
            <td>{$ary[1][1]}</td>
          </tr>
         </table>
       </body>
       </html>
       ");
}

hello_world();

