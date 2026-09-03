<?php
namespace Phpdocx\Elements;
/**
 * Create footer
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateFooter extends CreateElement
{
    /**
     *
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
     * @return CreateFooter
     * @access public
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateFooter();
        }
        return self::$_instance;
    }

    /**
     * Create footer
     *
     * @access public
     */
    public function createFooter()
    {
        $this->_xml = '';
        $args = func_get_args();
        $this->generateFTR();
        if (isset($args[1]['pager']) && $args[1]['pager'] == 'true') {
            $this->generateP();
            $this->generateR();
            $this->generatePTAB('margin', $args[1]['pagerAlignment']);
            $this->generateFLDSIMPLE();
        }
        $text = CreateText::getInstance();
        $text->createText($args[0], $args[1]);
        $obj = preg_replace('/__PHX=__[A-Z]+__/', '', (string) $text);
        $xml = $obj . '__PHX=__GENERATEFTR__';
        $this->_xml = str_replace('__PHX=__GENERATEFTR__', $xml, $this->_xml);
    }

    /**
     * Generate w:fldsimple
     *
     * @access protected
     */
    protected function generateFLDSIMPLE()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':fldSimple ' . CreateElement::NAMESPACEWORD .
                ':instr=" PAGE   \* MERGEFORMAT "></'
                . CreateElement::NAMESPACEWORD . ':fldSimple>';

        $this->_xml = str_replace('__PHX=__GENERATERSUB__', $xml, $this->_xml);
    }

    /**
     * Generate ftr token
     *
     * @access protected
     */
    protected function generateFTR()
    {
        $this->_xml = '__PHX=__GENERATEFTR____PHX=__GENERATEIMGFTR__';
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
                ':p>__PHX=__GENERATEFTR__';
        $this->_xml = str_replace('__PHX=__GENERATEFTR__', $xml, $this->_xml);
    }

    /**
     * Generate w:ptab
     *
     * @param string $relativeTo
     * @param string $alignment
     * @param string $leader
     * @access protected
     */
    protected function generatePTAB($relativeTo = 'margin', $alignment = 'right', $leader = 'none')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':ptab ' . CreateElement::NAMESPACEWORD .
                ':relativeTo="' . $relativeTo .
                '" ' . CreateElement::NAMESPACEWORD .
                ':alignment="' . $alignment .
                '" ' . CreateElement::NAMESPACEWORD .
                ':leader="' . $leader .
                '"></' . CreateElement::NAMESPACEWORD . ':ptab>';

        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:r
     *
     * @access protected
     */
    protected function generateR()
    {
        if (!empty($this->_xml)) {
            if (preg_match("/__PHX=__GENERATEP__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATERSUB__';

                $this->_xml = str_replace('__PHX=__GENERATEP__', $xml, $this->_xml);
            } elseif (preg_match("/__PHX=__GENERATER__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATERSUB__';

                $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
            } elseif (preg_match("/__PHX=__GENERATERSUB__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATERSUB__';

                $this->_xml = str_replace(
                        '__PHX=__GENERATERSUB__', $xml, $this->_xml
                );
            }
        } else {
            $this->_xml = '<' . CreateElement::NAMESPACEWORD .
                    ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                    ':r>__PHX=__GENERATERSUB__';
        }
    }
}