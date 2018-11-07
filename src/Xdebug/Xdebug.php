<?php

/**
 * @author wrx <it2bt.com>
 * @description Do it yourself.
 * @date 2018-7-26 18:31:18
 * @version 1.0.0
 */

namespace Xdebug;

class Xdebug
{
    //debug是否开启
    public $debug = true;
    
    public $start_time;
    
    public $last_time;


    public function __construct() {
        $this->start_time = microtime(true);
        $dir = 'xdebug/log/';
        if(!file_exists($dir))
            self::mk_dir ($dir);       
        $this->start();
    }
    
    public function enable($debug=true)
    {
        $this->debug = $debug;
    }


    public function start()
    {
        if(!$this->debug)
            return;        
        $content = PHP_EOL . '[' . date('Y-m-d H:i:s',time()) .'] [--- XDEBUG START ---]'.PHP_EOL;
        $filename = 'xdebug/log/app.log';
        self::write($filename, $content);        
    }


    public function debug($msg,$type='DEBUG')
    {
        if(!$this->debug)
            return;
        $this->last_time = microtime(true);
        $dur = $this->last_time - $this->start_time;
        $dur = sprintf('%.6f',$dur);
        $content = '[' . date('Y-m-d H:i:s',time()) .'] ['. $type .'] [DURATION: '. $dur . 'ms] '. $msg .PHP_EOL;
        $filename = 'xdebug/log/app.log';
        self::write($filename, $content);
        $this->start_time = $this->last_time;
    }
    
    public function end()
    {
        if(!$this->debug)
            return;        
        $content = '[' . date('Y-m-d H:i:s',time()) .'] [--- XDEBUG END ---]'.PHP_EOL;
        $filename = 'xdebug/log/app.log';
        self::write($filename, $content);        
    }    
    
    //目录创建（递归创建）
    public static function mk_dir($dir, $mode = 0777)
    {
        return is_dir($dir) or self::mk_dir(dirname($dir), $mode) and mkdir($dir, $mode);
    }   

    public static function write($filename,$content)
    {
        file_put_contents($filename, $content, FILE_APPEND);
    }
}