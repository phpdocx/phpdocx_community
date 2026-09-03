<?php
namespace Phpdocx\Elements;

use Phpdocx\Create\CreateDocx;

/**
 * Create image caption using text strings
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateImageCaption extends CreateElement
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
     * @var bool
     */
    private $_keepNext;

    /**
     *
     * @access private
     * @var string
     */
    private $_label;

    /**
     *
     * @access private
     * @var string
     */
    private $_pStyle;

    /**
     *
     * @access private
     * @var bool
     */
    private $_showLabel;

    /**
     *
     * @access private
     * @var string
     */
    private $_styleName;

    /**
     *
     * @access private
     * @var string
     */
    private $_text;

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
     * @static
     * @return CreateImageCaption
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateImageCaption();
        }
        return self::$_instance;
    }

    /**
     * Getter. Access to keepNext value var
     *
     * @access public
     * @return bool
     */
    public function getKeepNext()
    {
        return $this->_keepNext;
    }

    /**
     * Getter. Access to label value var
     *
     * @access public
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Getter. Access to pStyle value var
     *
     * @access public
     * @return string
     */
    public function getPStyle()
    {
        return $this->_pStyle;
    }

    /**
     * Getter. Access to show label var
     *
     * @access public
     * @return bool
     */
    public function getShowLabel()
    {
        return $this->_showLabel;
    }

    /**
     * Getter. Access to text value var
     *
     * @access public
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * Create Caption
     *
     * @access public
     */
    public function createCaption()
    {
        $this->_xml = '';
        $args = func_get_args();

        $this->generateP();
        $this->generatePPR();
        if ($this->_keepNext) {
            $this->generateKEEPNEXT();
        }
        if (!empty($this->_pStyle)) {
            $this->generatePSTYLE($this->_pStyle);
        } else {
            $this->generatePSTYLE($this->_styleName);
        }
        $this->generateR();

        if ($this->_showLabel) {
            $this->generateT($this->_label . ' ');
        } else {
            $this->generateT('');
        }

        $this->generateFldSimple();
        if ($this->_text != '') {
            $this->generateR();
            $this->generateT($this->_text);
        }
    }

    /**
     * Init a link to assign values to variables
     *
     * @access public
     */
    public function initCaption()
    {
        $args = func_get_args();

        if (!isset($args[0]['keepNext'])) {
            $args[0]['keepNext'] = false;
        }
        if (!isset($args[0]['pStyle'])) {
            $args[0]['pStyle'] = '';
        }
        if (!isset($args[0]['showLabel'])) {
            $args[0]['showLabel'] = true;
        }
        if (!isset($args[0]['text'])) {
            $args[0]['text'] = '';
        }

        $this->_keepNext = $args[0]['keepNext'];
        $this->_showLabel = $args[0]['showLabel'];
        $this->_text = $args[0]['text'];
        $this->_label = $args[0]['label'];
        $this->_pStyle = $args[0]['pStyle'];
        $this->_styleName = $args[0]['styleName'];
    }

    /**
     * Generate w:keepNext
     *
     * @access protected
     * @param string $val
     */
    protected function generateKEEPNEXT($val = 'on')
    {
        $this->_xml = str_replace(
                '__PHX=__GENERATEPPR__', '<' . CreateElement::NAMESPACEWORD .
                ':keepNext w:val="' . $val . '"></' .
                CreateElement::NAMESPACEWORD . ':keepNext>__PHX=__GENERATEPPR__', $this->_xml
        );
    }

    /**
     * Create fldSimple
     *
     * @access private
     */
    private function generateFldSimple()
    {
        $begin = '<'. CreateElement::NAMESPACEWORD .':fldSimple '. CreateElement::NAMESPACEWORD  .':instr=" SEQ '.$this->_styleName.' \* ARABIC "><'. CreateElement::NAMESPACEWORD .':r><'. CreateElement::NAMESPACEWORD .':rPr><'. CreateElement::NAMESPACEWORD .':noProof/></'. CreateElement::NAMESPACEWORD .':rPr><'. CreateElement::NAMESPACEWORD .':t>';
        $end = '</'. CreateElement::NAMESPACEWORD .':t></'. CreateElement::NAMESPACEWORD .':r></'. CreateElement::NAMESPACEWORD  .':fldSimple>__PHX=__GENERATESUBR__';

        if (isset(CreateDocx::$captionsIds[$this->_styleName])) {
            $captionIdValue = CreateDocx::$captionsIds[$this->_styleName];
        } else {
            $captionIdValue = 1;
        }

        $simpleField = $begin . $captionIdValue . $end;
        $this->_xml = str_replace('__PHX=__GENERATESUBR__', $simpleField, $this->_xml);
    }
}
