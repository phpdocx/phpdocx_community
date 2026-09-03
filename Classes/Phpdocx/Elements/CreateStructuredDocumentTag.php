<?php
namespace Phpdocx\Elements;

use Phpdocx\Utilities\XmlUtilities;

/**
 * Create structured document tag
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateStructuredDocumentTag
{
    /**
     *
     * @access private
     * @var mixed
     */
    private static $_instance = NULL;

    /**
     *
     * @access private
     * @var string
     */
    private $_xml;

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
     * @return CreateStructuredDocumentTag
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateStructuredDocumentTag();
        }
        return self::$_instance;
    }

    /**
     * Create Structured Document Tag
     *
     * @access public
     */
    public function createStructuredDocumentTag()
    {
        $args = func_get_args();
        $this->_xml = '';
        $lockValues = array('sdtLocked', 'contentLocked', 'unlocked', 'sdtContentLocked');
        $id = rand(100000000, 999999999);
        $xmlUtilities = new XmlUtilities();

        //1. First construct the sdtPr element(structured document tag properties)
        $sdtPr = '<w:sdtPr>';
        $sdtPr .= $this->generateRPr($args[1]);
        if (!empty($args[1]['alias'])) {
            $sdtPr .= '<w:alias w:val="' . $xmlUtilities->parseAndCleanTextString($args[1]['alias']) . '" />';
        }
        if (!empty($args[1]['lock']) && in_array($args[1]['lock'], $lockValues)) {
            $sdtPr .= '<w:lock w:val="' . $args[1]['lock'] . '" />';
        }
        $sdtPr .= '<w:id w:val="' . $id . '" />';
        if (!empty($args[1]['tag'])) {
            $sdtPr .= '<w:tag w:val="' . $args[1]['tag'] . '" />';
        }
        if (isset($args[1]['temporary']) && $args[1]['temporary']) {
            $sdtPr .= '<w:temporary />';
        }
        // now we have to add the elements associated to each particular type
        // combo box
        if (isset($args[0]) && ($args[0] == 'comboBox' || $args[0] == 'dropDownList')) {
            $sdtPr .= '<w:' . $args[0] . '>';
            if (!empty($args[1]['listItems']) && is_array($args[1]['listItems'])) {
                foreach ($args[1]['listItems'] as $key => $value) {
                    $sdtPr .= '<w:listItem w:displayText="' . $xmlUtilities->parseAndCleanTextString($value[0]) . '" w:value="' . $xmlUtilities->parseAndCleanTextString($value[1]) . '" />';
                }
            }
            $sdtPr .= '</w:' . $args[0] . '>';
        }
        // date format
        if (isset($args[0]) && $args[0] == 'date') {
            $sdtPr .= '<w:date>';
            if (!empty($args[1]['dateFormat'])) {
                $sdtPr .= '<w:dateFormat w:val="' . $args[1]['dateFormat'] . '" />';
            } else {
                $sdtPr .= '<w:dateFormat w:val="M/d/yyyy" />';
            }
            if (!empty($args[1]['local'])) {
                $sdtPr .= '<w:lid w:val="' . $args[1]['local'] . '" />';
            } else {
                $sdtPr .= '<w:lid w:val="en-US" />';
            }
            if (!empty($args[1]['calendar'])) {
                $sdtPr .= '<w:calendar w:val="' . $args[1]['calendar'] . '" />';
            } else {
                $sdtPr .= '<w:calendar w:val="gregorian" />';
            }
            $sdtPr .= '</w:date>';
        }
        // rich text
        if (isset($args[0]) && $args[0] == 'richText') {
            if (isset($args[1]['placeholderText']) && !empty(isset($args[1]['placeholderText']))) {
                $sdtPr .= '<w:showingPlcHdr/>';
            }
            $sdtPr .= '<w:richText />';
        }
        // text type
        if (isset($args[0]) && $args[0] == 'text') {
            if (isset($args[1]['placeholderText']) && !empty(isset($args[1]['placeholderText']))) {
                $sdtPr .= '<w:showingPlcHdr/>';
            }
            $sdtPr .= '<w:text />';
        }
        // checkbox
        if (isset($args[0]) && $args[0] == 'checkbox') {
            $sdtPr .= '<w14:checkbox xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml">';
            if (isset($args[1]['checked'])) {
                if ($args[1]['checked'] === true) {
                    $sdtPr .= '<w14:checked w14:val="1"/>';
                } else {
                    $sdtPr .= '<w14:checked w14:val="0"/>';
                }
            } else {
                $sdtPr .= '<w14:checked w14:val="0"/>';
            }
            // default values
            $fontCheckedState = 'MS Gothic';
            $fontUncheckedState = 'MS Gothic';
            $valueCheckedState = '2612';
            $valueUncheckedState = '2610';
            // custom values
            if (isset($args[1]['checkedState'])) {
                if (isset($args[1]['checkedState']['font'])) {
                    $fontCheckedState = $args[1]['checkedState']['font'];
                }
                if (isset($args[1]['checkedState']['value'])) {
                    $valueCheckedState = $args[1]['checkedState']['value'];
                }
            }
            if (isset($args[1]['uncheckedState'])) {
                if (isset($args[1]['uncheckedState']['font'])) {
                    $fontUncheckedState = $args[1]['uncheckedState']['font'];
                }
                if (isset($args[1]['uncheckedState']['value'])) {
                    $valueUncheckedState = $args[1]['uncheckedState']['value'];
                }
            }

            $sdtPr .= '<w14:checkedState w14:font="'.$fontCheckedState.'" w14:val="'.$valueCheckedState.'"/><w14:uncheckedState w14:font="'.$fontUncheckedState.'" w14:val="'.$valueUncheckedState.'"/>';
            $sdtPr .= '</w14:checkbox>';

            // custom symbol
            if (isset($args[1]['sym']) && isset($args[1]['sym']['font']) && isset($args[1]['sym']['char'])) {
                $args[2] = str_replace('</w:rPr><w:t ', '<w:sym w:char="'.$args[1]['sym']['char'].'" w:font="'.$args[1]['sym']['font'].'"/></w:rPr><w:t ', $args[2]);

                // remove default text
                $args[2] = str_replace('<w:t xml:space="preserve">☒</w:t>', '', $args[2]);
                $args[2] = str_replace('<w:t xml:space="preserve">☐</w:t>', '', $args[2]);
            }
        }
        if (isset($args[1]['repeatingSection']) && $args[1]['repeatingSection']) {
            $sdtPr .= '<w15:repeatingSection xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" />';
        }
        if (isset($args[1]['repeatingSectionItem']) && $args[1]['repeatingSectionItem']) {
            $sdtPr .= '<w15:repeatingSectionItem xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" />';
        }

        $sdtPr .= '</w:sdtPr>';

        //2. Construct the sdtContent element (structured document tag content)
        $sdtContent = '<w:sdtContent>' . $args[2] . '</w:sdtContent>';

        //3. Now we build the whole sdt tag
        $this->_xml = '<w:sdt>' . $sdtPr . $sdtContent . '</w:sdt>';
    }

    /**
     * Generates a rPr node
     *
     * @access private
     * @param array $options
     */
    private function generateRPr($options)
    {
        $rPr = '<w:rPr>';
        if (isset($options['rStyle'])) {
            $rPr .= '<w:rStyle w:val="' . $options['rStyle'] . '" />';
        }
        if (isset($options['fontSize'])) {
            $options['sz'] = $options['fontSize'];
            $options['szCs'] = $options['fontSize'];
        }
        if (isset($options['font'])) {
            $rPr .= '<w:rFonts w:ascii="' . $options['font'] . '" w:hAnsi="' . $options['font'] . '" w:eastAsia="' . $options['font'] . '" w:cs="' . $options['font'] . '" />';
        }
        if (isset($options['b'])) {
            $rPr .= '<w:b w:val="' . $options['b'] . '" />';
        }
        if (isset($options['characterBorder'])) {
            if (!isset($options['characterBorder']['color'])) {
                $options['characterBorder']['color'] = 'auto';
            }
            if (!isset($options['characterBorder']['spacing'])) {
                $options['characterBorder']['spacing'] = 0;
            }
            if (!isset($options['characterBorder']['type'])) {
                $options['characterBorder']['type'] = 'single';
            }
            if (!isset($options['characterBorder']['width'])) {
                $options['characterBorder']['width'] = 4;
            }
            $rPr .= '<w:bdr w:color="'.$options['characterBorder']['color'].'" w:space="'.$options['characterBorder']['spacing'].'" w:sz="'.$options['characterBorder']['width'].'" w:val="'.$options['characterBorder']['type'].'"/>';
        }
        if (isset($options['i'])) {
            $rPr .= '<w:i w:val="' . $options['i'] . '" />';
        }
        $rPr .= '<w:noProof/>';
        if (isset($options['color'])) {
            $rPr .= '<w:color w:val="' . $options['color'] . '" />';
        }
        if (isset($options['sz'])) {
            $rPr .= '<w:sz w:val="' . (2 * $options['sz']) . '" />';
        }
        if (isset($options['szCs'])) {
            $rPr .= '<w:szCs w:val="' . (2 * $options['szCs']) . '" />';
        }
        if (isset($options['u'])) {
            $rPr .= '<w:u w:val="' . $options['u'] . '" />';
        }
        $rPr .= '</w:rPr>';

        return $rPr;
    }
}