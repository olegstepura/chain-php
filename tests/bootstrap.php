<?php
/**
 * @author Oleg Stepura <github@oleg.stepura.com>
 * @copyright Oleg Stepura <github@oleg.stepura.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @version $Id$
 */

spl_autoload_register(function ($className) {
    $path = ltrim(str_replace(array('\\', '_'), '/', $className), '/') . '.php';
    if (file_exists(__DIR__ . '/../lib/' . $path)) {
        require_once __DIR__ . '/../lib/' . $path;
        return true;
    }
    if (file_exists(__DIR__ . '/' . $path)) {
        require_once __DIR__ . '/' . $path;
        return true;
    }
    foreach (explode(PATH_SEPARATOR, get_include_path()) as $dir) {
        if (file_exists($dir . '/' . $path)) {
            require_once $dir . '/' . $path;
            return true;
        }
    }
    return false;
});
