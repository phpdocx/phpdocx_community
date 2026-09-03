<?php
namespace Phpdocx\Logger;
/**
 * Logger
 *
 * @category   Phpdocx
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class PhpdocxLogger
{
    /**
     * Error reporting config
     *
     * @var int
     */
    public static $errorReporting = E_ALL;

    /**
     *
     * @access private
     * @static
     * @var bool
     */
    private static $_disableLogger = true;

    /**
     *
     * @access private
     * @static
     * @var mixed
     */
    private static $_log = NULL;

    /**
     * Logger messages
     *
     * @access public
     * @param $message Message to send to logging framework
     * @param $level Allowed values: trace, debug, info, warn, error, fatal
     * @static
     * @throws \Exception fatal level
     */
    public static function logger($message, $level)
    {
        $levels = array(
            'debug',
            'info',
            'notice',
            'warning',
            'error',
        );

        // Exception if fatal level
        if ($level == 'fatal') {
            throw new \Exception($message);
        }

        if (self::$_disableLogger === false) {
            // only some levels are valid
            if (in_array($level, $levels)) {
                $stringLevel = strtolower($level);
                if (self::$_log) {
                    self::$_log->$stringLevel($message);
                }
            }
        }
    }

    /**
     * Disable the logger
     *
     * @access public
     * @static
     */
    public static function disableLogger()
    {
        self::$_disableLogger = true;
    }

    /**
     * Enable the logger
     *
     * @access public
     * @static
     */
    public static function enableLogger()
    {
        self::$_disableLogger = false;
    }

    /**
     * Init default error level
     *
     * @access public
     * @static
     */
    public static function initErrorLevel()
    {
        if (PHP_VERSION_ID < 80000) {
            self::$errorReporting = E_ALL;
        } else {
            self::$errorReporting = E_ALL;
        }
    }

    /**
     * Set a custom logger. It must follow PSR-3
     *
     * @access public
     * @param mixed $logger Custom logger
     * @static
     */
    public static function setLogger($logger)
    {
        self::$_log = $logger;
    }
}
