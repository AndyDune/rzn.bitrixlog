<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 17.02.2016                                      
 * ----------------------------------------------------
*/

namespace Rzn\BitrixLog\Tests;

use PHPUnit_Framework_TestCase;
use Rzn\Library\Exception;
use Rzn\Library\Registry;
use COption;
use CUser;

class LogTest extends PHPUnit_Framework_TestCase
{
    protected $backupGlobals = false;

    public function testLog()
    {
        $sm = Registry::getServiceManager();
        /** @var \Rzn\Library\Mediator\Mediator $mediator */
        $mediator = $sm->get('mediator');

        $file = __DIR__ . '/log.txt';
        $uniq = uniqid();
        $mediator->publish('log', ['code' => $uniq], ['file' => $file]);
        $content = file_get_contents($file);
        $this->assertTrue((bool)preg_match('|code=' . $uniq . '|', $content));
        unlink($file);
    }


}