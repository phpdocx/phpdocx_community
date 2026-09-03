<?php
namespace Phpdocx\Elements;
/**
 * Create links using text strings
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateLink extends CreateElement
{
    /**
     *
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     *
     * @access private
     * @var string
     */
    private $_link;

    /**
     *
     * @access private
     * @var string
     */
    private $_title;

    /**
     *
     * @access private
     * @var string
     */
    private $_font;

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
     * @return CreateLink
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateLink();
        }
        return self::$_instance;
    }

    /**
     * Getter. Access to link var
     *
     * @access public
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     * Getter. Access to title var
     *
     * @access public
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Getter. Access to font var
     *
     * @access public
     * @return string
     */
    public function getFont()
    {
        return $this->_font;
    }

    /**
     * Create an embedded link to add in others elements like lists, tables...
     *
     * @access public
     */
    public function createEmbeddedLink()
    {
        $this->_xml = '';

        $this->generateR();
        $this->generateFLDCHAR('begin');
        $this->generateR();
        $this->generateINSTRTEXT($this->_title);
        $this->generateR();
        $this->generateFLDCHAR('separate');
        $this->generatePROOFERR('gramStart');
        $this->generateR();
        $this->generateRPR();
        $this->generateRFONTS($this->_font);
        $this->generateRSTYLE('Hipervnculo');
        $this->generateT($this->_link);
        $this->generatePROOFERR('gramEnd');
        $this->generateR();
        $this->generateFLDCHAR('end');
    }

    /**
     * Create a link
     *
     * @access public
     */
    public function createLink()
    {
        $this->_xml = '';
        $args = func_get_args();

        $this->generateP();
        $this->generateR();
        $this->generateFLDCHAR('begin');
        $this->generateR();
        $this->generateINSTRTEXT($args[1]);
        $this->generateR();
        $this->generateFLDCHAR('separate');
        $this->generatePROOFERR('gramStart');
        $this->generateR();
        $this->generateRPR();
        $this->generateRSTYLE('Hipervnculo');
        $this->generateRFONTS($args[2]);
        $this->generateT($args[0]);
        $this->generatePROOFERR('gramEnd');
        $this->generateR();
        $this->generateFLDCHAR('end');
    }

    /**
     * Init a link to assign values to variables
     *
     * @access public
     */
    public function initLink()
    {
        $args = func_get_args();

        if (!isset($args[0]['title'])) {
            $args[0]['title'] = '';
        }
        if (!isset($args[0]['link'])) {
            $args[0]['link'] = '';
        }
        if (!isset($args[0]['font'])) {
            $args[0]['font'] = '';
        }

        $this->_link = $args[0]['title'];
        $this->_title = $args[0]['link'];
        $this->_font = $args[0]['font'];
    }

    /**
     * Generate w:fldChar
     *
     * @access protected
     * @param string $fldCharType
     */
    protected function generateFLDCHAR($fldCharType)
    {
        $strXML = '<' . CreateElement::NAMESPACEWORD . ':fldChar '
                . CreateElement::NAMESPACEWORD . ':fldCharType="'
                . $fldCharType . '"></'
                . CreateElement::NAMESPACEWORD . ':fldChar>';
        $this->_xml = str_replace('__PHX=__GENERATER__', $strXML, $this->_xml);
    }

    /**
     * Generate w:hyperlink
     *
     * @access protected
     * @param string $type
     */
    protected function generateHYPERLINK($type)
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD
                . ':hyperlink r:id="rId5" w:history="1">__PHX=__GENERATEP__</'
                . CreateElement::NAMESPACEWORD . ':hyperlink>';
    }

    /**
     * Generate w:instrText
     *
     * @access protected
     * @param string $link. Optional, use http://localhost as default
     */
    protected function generateINSTRTEXT($link = 'http://localhost')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD
                . ':instrText xml:space="preserve"> HYPERLINK "'
                . $link . '"</' . CreateElement::NAMESPACEWORD
                . ':instrText>';
        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:proofErr
     *
     * @access protected
     * @param string $type
     */
    protected function generatePROOFERR($type)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':proofErr '
                . CreateElement::NAMESPACEWORD . ':type="' . $type
                . '"></' . CreateElement::NAMESPACEWORD
                . ':proofErr>__PHX=__GENERATERSUB__';
        $this->_xml = str_replace('__PHX=__GENERATERSUB__', $xml, $this->_xml);
    }

    /**
     * Generate w:r
     *
     * @access protected
     */
    protected function generateR()
    {
        if (preg_match("/__PHX=__GENERATEP__/", $this->_xml)) {
            $xml = '<' . CreateElement::NAMESPACEWORD
                    . ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD
                    . ':r>__PHX=__GENERATERSUB__';
            $this->_xml = str_replace('__PHX=__GENERATEP__', $xml, $this->_xml);
        } elseif (preg_match("/__PHX=__GENERATERSUB__/", $this->_xml)) {
            $xml = '<' . CreateElement::NAMESPACEWORD . ':r>'
                    . '__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD
                    . ':r>__PHX=__GENERATERSUB__';
            $this->_xml = str_replace('__PHX=__GENERATERSUB__', $xml, $this->_xml);
        } else {
            $this->_xml = '<' . CreateElement::NAMESPACEWORD
                    . ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD
                    . ':r>__PHX=__GENERATERSUB__';
        }
    }

    /**
     * Generate w:rStyle
     *
     * @access protected
     * @param string $val
     */
    protected function generateRSTYLE($val = 'Hipervnculo')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':rStyle '
                . CreateElement::NAMESPACEWORD . ':val="' . $val . '"></'
                . CreateElement::NAMESPACEWORD . ':rStyle>';
        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

}
