<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 21.10.2015                                      
 * ----------------------------------------------------
*/

namespace Rzn\BitrixLog;


class Log 
{
    protected $file = '/log.txt';

    protected $maxSize = 1048576;

    protected $active  = false;

    /**
     * Для лога - флаг записей, произошедших в одном запросе.
     * @var string
     */
    protected $session  = '';

    public function __construct()
    {
        $this->session = uniqid();
    }

    /**
     * @param string|array $params<p>
     * Данные для помещения в лог. Строка вставялется как есть.
     * Массив имплодится. Дл ассоциативных массивов сохраняются ключи
     * </p>
     * @param array $options<p>
     * Дополнительные опции для запуска:
     * file - полный путь к лог-файлу
     * local_file - путь к файлу от рут папки сайта
     * max_size - максимальный размер файлы в байтах
     * </p>
     * @return bool
     */
    public function __invoke($params, $options = [])
    {
        if (!$this->active) {
            return false;
        }

        if (is_array($params)) {
            // При ассоциативном массиве сохраняем в логе ключи
            foreach($params as $key => $value) {
                if (preg_match('|[^0-9]|', $key)) {
                    $value = $key . '=' . $value;
                    $params[$key] = $value;
                }
            }
            $string = implode(' | ', $params);
        } else {
            $string = $params;
        }
        $string = date('Y-m-d H:i:s') . ' |  ' . $this->session . ' | ' . $string . "\r\n";

        if (isset($options['file'])) {
            $file = $options['file'];
        } else if (isset($options['local_file'])) {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($options['local_file'], '/');
        } else {
            $file = $_SERVER['DOCUMENT_ROOT'] . $this->file;
        }

        if (isset($options['max_size'])) {
            $maxSize = $options['max_size'];
        } else {
            $maxSize = $this->maxSize;
        }


        if (file_exists($file)) {
            if (filesize ($file) > $maxSize) {
                unlink($file);
            }
        }
        $handle = fopen($file, "a");
        if (!$handle) {
            // Еще одна попытка
            $handle = fopen($file, "a");
        }
        if (!$handle) {
            return false;
        }
        fwrite($handle, $string);
        fclose($handle);
        return true;
    }

    /**
     * Внедрение базового пути к лог-файлу.
     * От корня сайта.
     *
     * @param $file
     */
    public function setFile($file)
    {
        $this->file = '/' . ltrim($file, '/');
    }

    /**
     * Включение/отключение логирования.
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    public function setMaxSize($size)
    {
        $this->maxSize = $size;
    }

}