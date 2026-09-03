<?php
namespace Phpdocx\Elements;
/**
 * Create ruby
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateRuby extends CreateElement
{
    /**
     *
     * @access private
     * @var mixed
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
     * Magic method, returns current XML
     *
     * @access public
     * @return string Return current XML
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Singleton, return instance of class
     *
     * @access public
     * @return CreateRuby
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateRuby();
        }
        return self::$_instance;
    }

    /**
     * Create ruby
     *
     * @access public
     * @param WordFragment $rt
     * @param WordFragment $rubyBase
     * @param array $options
     */
    public function createRuby($rt, $rubyBase, $options)
    {
        $this->_xml = '<w:r><w:ruby><w:rubyPr>';
        $this->_xml .= '<w:rubyAlign w:val="'.$options['rubyAlign'].'"/>';
        $this->_xml .= '<w:hps w:val="'.$options['hps'].'"/>';
        $this->_xml .= '<w:hpsRaise w:val="'.$options['hpsRaise'].'"/>';
        $this->_xml .= '<w:hpsBaseText w:val="'.$options['hpsBaseText'].'"/>';
        $this->_xml .= '<w:lid w:val="'.$options['lid'].'"/>';
        $this->_xml .= '</w:rubyPr>';

        $this->_xml .= '<w:rt>' . $rt->inlineWordML() . '</w:rt>';
        $this->_xml .= '<w:rubyBase>' . $rubyBase->inlineWordML() . '</w:rubyBase>';
        $this->_xml .= '</w:ruby></w:r>';
    }
}