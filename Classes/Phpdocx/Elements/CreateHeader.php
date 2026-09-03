<?php
namespace Phpdocx\Elements;
/**
 * Create header
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateHeader extends CreateElement
{
    /**
     *
     * @var mixed
     * @access private
     * @static
     */
    private static $_instance = NULL;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {

    }

    /**
     *
     * @return string
     * @access public
     */
    public function __toString()
    {
        $this->_xml = preg_replace('/__PHX=__[A-Z]+__/', '', $this->_xml);
        return $this->_xml;
    }

    /**
     *
     * @return CreateHeader
     * @access public
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateHeader();
        }
        return self::$_instance;
    }

    /**
     * Create header
     *
     * @access public
     */
    public function createHeader()
    {
        $this->_xml = '';
        $args = func_get_args();

        $text = CreateText::getInstance();
        $text->createText($args[0], $args[1]);
        $this->generateHDR();
        $this->_xml = str_replace(
                '__PHX=__GENERATEHDR__', (string) $text . '__PHX=__GENERATEHDR__', $this->_xml
        );
    }

    /**
     * Generate hdr token
     *
     * @access protected
     */
    protected function generateHDR()
    {
        $this->_xml = '__PHX=__GENERATEHDR____PHX=__GENERATEHDRIMG__';
    }

    /**
     * Generate w:p
     *
     * @access protected
     */
    protected function generateP()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':p>__PHX=__GENERATEP__</' . CreateElement::NAMESPACEWORD .
                ':p>__PHX=__GENERATEHDR__';

        $this->_xml = str_replace('__PHX=__GENERATEHDR__', $xml, $this->_xml);
    }
}