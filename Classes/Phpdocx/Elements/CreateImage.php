<?php
namespace Phpdocx\Elements;

use Phpdocx\Logger\PhpdocxLogger;

/**
 * Create images
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateImage extends CreateElement
{
    const NAMESPACEWORD = 'wp';
    const NAMESPACEWORD1 = 'a';
    const NAMESPACEWORD2 = 'pic';
    const CONSTWORD = 360000;
    const TAMBORDER = 12700;
    const PNG_SCALE_FACTOR = 29.5;

    /**
     * @access private
     * @var mixed
     * @static
     */
    private static $_instance = NULL;

    /**
     *
     * @access private
     * @var string
     */
    private $_name;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_rId;

    /**
     *
     * @access private
     * @var string
     */
    private $_textWrap;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_sizeX;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_sizeY;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_dpi;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_dpiCustom;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_spacingTop;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_spacingBottom;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_spacingLeft;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_spacingRight;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_jc;

    /**
     *
     * @access private
     * @var string
     */
    private $_border;

    /**
     *
     * @access private
     * @var string
     */
    private $_borderDiscontinuous;

    /**
     *
     * @access private
     * @var mixed
     */
    private $_scaling;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        $this->_name = '';
        $this->_rId = '';
        $this->_textWrap = '';
        $this->_sizeX = '';
        $this->_sizeY = '';
        $this->_spacingTop = '';
        $this->_spacingBottom = '';
        $this->_spacingLeft = '';
        $this->_spacingRight = '';
        $this->_jc = '';
        $this->_border = '';
        $this->_borderDiscontinuous = '';
        $this->_scaling = '';
        $this->_dpiCustom = 0;
        $this->_dpi = 96;
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
        return $this->_xml;
    }

    /**
     *
     * @return CreateImage
     * @access public
     * @static
     */
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new CreateImage();
        }
        return self::$_instance;
    }

    /**
     * Setter. Name
     *
     * @access public
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Getter. Name
     *
     * @access public
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Setter. Rid
     *
     * @access public
     * @param string $rId
     */
    public function setRId($rId)
    {
        $this->_rId = $rId;
    }

    /**
     * Getter. Rid
     *
     * @access public
     */
    public function getRId()
    {
        return $this->_rId;
    }

    /**
     * Create image
     *
     * @access public
     */
    public function createImage()
    {
        $this->_xml = '';
        $this->_name = '';
        $this->_rId = '';
        $this->_textWrap = '';
        $this->_sizeX = '';
        $this->_sizeY = '';
        $this->_spacingTop = '';
        $this->_spacingBottom = '';
        $this->_spacingLeft = '';
        $this->_spacingRight = '';
        $this->_jc = '';
        $this->_border = '';
        $this->_borderDiscontinuous = '';
        $this->_scaling = '';
        $this->_dpiCustom = 0;
        $this->_dpi = 96;
        $args = func_get_args();

        if (isset($args[0]['rId']) && (isset($args[0]['src']))) {
            if (isset($args[0]['resourceModeContent'])) {
                if (function_exists('getimagesizefromstring')) {
                    $attributes = getimagesizefromstring($args[0]['resourceModeContent']);
                } else {
                    $attributes = array();
                    $attributes[] = $args[0]['sizeX'];
                    $attributes[] = $args[0]['sizeY'];
                    $attributes['mime'] = 'image/png';
                }
            } else {
                if (strstr($args[0]['src'], 'base64,')) {
                    // check if base64
                    $descrArray = explode(';base64,', $args[0]['src']);
                    $arrayExtension = explode('/', $descrArray[0]);
                    $arrayMime = explode(':', $descrArray[0]);
                    $mimeType = $arrayMime[1];
                    $imageContent = base64_decode($descrArray[1]);
                    if (function_exists('getimagesizefromstring')) {
                        $attributes = getimagesizefromstring($imageContent);
                    } else {
                        $attributes = array();
                        $attributes[] = $args[0]['sizeX'];
                        $attributes[] = $args[0]['sizeY'];
                        $attributes['mime'] = $mimeType;
                    }
                } else {
                    $attributes = getimagesize($args[0]['src']);
                }
            }

            if (!isset($args[0]['textWrap']) || $args[0]['textWrap'] < 0 ||
                    $args[0]['textWrap'] > 5
            ) {
                $textWrap = 0;
            } else {
                $textWrap = $args[0]['textWrap'];
            }

            if (isset($args[0]['sizeX'])) {
                $tamPxX = $args[0]['sizeX'];
            } elseif (isset($args[0]['scaling'])) {
                $tamPxX = $attributes[0] * $args[0]['scaling'] / 100;
            } else {
                $tamPxX = $attributes[0];
            }

            if (isset($args[0]['scaling'])) {
                $tamPxY = $attributes[1] * $args[0]['scaling'] / 100;
            } elseif (isset($args[0]['sizeY'])) {
                $tamPxY = $args[0]['sizeY'];
            } else {
                $tamPxY = $attributes[1];
            }
            if (isset($args[0]['dpi'])) {
                $this->_dpiCustom = $args[0]['dpi'];
            }
            if (isset($args[0]['resourceModeContent'])) {
                $this->setName('Image');
            } else {
                $this->setName($args[0]['src']);
            }
            if (isset($args[0]['descr'])) {
                // override descr value by the new one
                $this->setName($args[0]['descr']);
            }
            $this->setRId($args[0]['rId']);
            $top = '0';
            $bottom = '0';
            $left = '0';
            $right = '0';

            if (isset($args[0]['mime']) && empty($attributes['mime'])) {
                $attributes['mime'] = $args[0]['mime'];
            }

            switch ($attributes['mime']) {
                case 'image/png':
                    if (isset($args[0]['resourceModeContent'])) {
                        $dpiX = $this->_dpi;
                        $dpiY = $this->_dpi;
                        if ($this->_dpiCustom > 0) {
                            $dpiX = $this->_dpiCustom;
                            $dpiY = $this->_dpiCustom;
                        }
                    } else {
                        list($dpiX, $dpiY) = $this->getDpiPng($args[0]['src']);
                    }
                    if ($dpiX == 0) {
                        $dpiX = $this->_dpi;
                    }
                    if ($dpiY == 0) {
                        $dpiY = $this->_dpi;
                    }
                    $tamWordX = round($tamPxX * 2.54 / $dpiX * CreateImage::CONSTWORD);
                    $tamWordY = round($tamPxY * 2.54 / $dpiY * CreateImage::CONSTWORD);

                    if (isset($args[0]['spacingTop'])) {
                        $top = round(
                                $args[0]['spacingTop'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingBottom'])) {
                        $bottom = round(
                                $args[0]['spacingBottom'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingLeft'])) {
                        $left = round(
                                $args[0]['spacingLeft'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingRight'])) {
                        $right = round(
                                $args[0]['spacingRight'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    break;
                case 'image/jpg':
                case 'image/jpeg':
                    list($dpiX, $dpiY) = $this->getDpiJpg($args[0]['src']);
                    if ($dpiX == 0) {
                        $dpiX = $this->_dpi;
                    }
                    if ($dpiY == 0) {
                        $dpiY = $this->_dpi;
                    }
                    $tamWordX = round(
                            $tamPxX * 2.54 /
                            $dpiX * CreateImage::CONSTWORD
                    );
                    $tamWordY = round(
                            $tamPxY * 2.54 /
                            $dpiY * CreateImage::CONSTWORD
                    );
                    if (isset($args[0]['spacingTop'])) {
                        $top = round(
                                $args[0]['spacingTop'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingBottom'])) {
                        $bottom = round(
                                $args[0]['spacingBottom'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingLeft'])) {
                        $left = round(
                                $args[0]['spacingLeft'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingRight'])) {
                        $right = round(
                                $args[0]['spacingRight'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    break;
                case 'image/gif':
                    if ($this->_dpiCustom > 0) {
                        $this->_dpi = $this->_dpiCustom;
                    }
                    $tamWordX = round(
                            $tamPxX * 2.54 /
                            $this->_dpi * CreateImage::CONSTWORD
                    );
                    $tamWordY = round(
                            $tamPxY * 2.54 /
                            $this->_dpi * CreateImage::CONSTWORD
                    );
                    if (isset($args[0]['spacingTop'])) {
                        $top = round(
                                $args[0]['spacingTop'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingBottom'])) {
                        $bottom = round(
                                $args[0]['spacingBottom'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingLeft'])) {
                        $left = round(
                                $args[0]['spacingLeft'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingRight'])) {
                        $right = round(
                                $args[0]['spacingRight'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    break;
                case 'image/bmp':
                    if ($this->_dpiCustom > 0) {
                        $this->_dpi = $this->_dpiCustom;
                    }
                    $tamWordX = round(
                            $tamPxX * 2.54 /
                            $this->_dpi * CreateImage::CONSTWORD
                    );
                    $tamWordY = round(
                            $tamPxY * 2.54 /
                            $this->_dpi * CreateImage::CONSTWORD
                    );
                    if (isset($args[0]['spacingTop'])) {
                        $top = round(
                                $args[0]['spacingTop'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingBottom'])) {
                        $bottom = round(
                                $args[0]['spacingBottom'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingLeft'])) {
                        $left = round(
                                $args[0]['spacingLeft'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingRight'])) {
                        $right = round(
                                $args[0]['spacingRight'] * 2.54 /
                                $this->_dpi * CreateImage::CONSTWORD
                        );
                    }
                    break;
                case 'image/webp':
                    if (isset($args[0]['resourceModeContent'])) {
                        $dpiX = $this->_dpi;
                        $dpiY = $this->_dpi;
                        if ($this->_dpiCustom > 0) {
                            $dpiX = $this->_dpiCustom;
                            $dpiY = $this->_dpiCustom;
                        }
                    } else {
                        list($dpiX, $dpiY) = $this->getDpiWebp($args[0]['src']);
                    }
                    if ($dpiX == 0) {
                        $dpiX = $this->_dpi;
                    }
                    if ($dpiY == 0) {
                        $dpiY = $this->_dpi;
                    }
                    $tamWordX = round($tamPxX * 2.54 / $dpiX * CreateImage::CONSTWORD);
                    $tamWordY = round($tamPxY * 2.54 / $dpiY * CreateImage::CONSTWORD);

                    if (isset($args[0]['spacingTop'])) {
                        $top = round(
                                $args[0]['spacingTop'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingBottom'])) {
                        $bottom = round(
                                $args[0]['spacingBottom'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingLeft'])) {
                        $left = round(
                                $args[0]['spacingLeft'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    if (isset($args[0]['spacingRight'])) {
                        $right = round(
                                $args[0]['spacingRight'] * 2.54 /
                                $dpiX * CreateImage::CONSTWORD
                        );
                    }
                    break;
            }

            $this->generateP();
            if (isset($args[0]['imageAlign'])) {
                $this->generatePPR();
                $this->generateJC($args[0]['imageAlign']);
            }
            $this->generateR();
            $this->generateRPR();
            $this->generateNOPROOF();
            $this->generateDRAWING();

            $distanceT = 0;
            $distanceB = 0;
            $distanceL = 0;
            $distanceR = 0;
            if (isset($args[0]['distance'])) {
                if (isset($args[0]['distance']['top'])) {
                    $distanceT = $args[0]['distance']['top'];
                }
                if (isset($args[0]['distance']['bottom'])) {
                    $distanceB = $args[0]['distance']['bottom'];
                }
                if (isset($args[0]['distance']['left'])) {
                    $distanceL = $args[0]['distance']['left'];
                }
                if (isset($args[0]['distance']['right'])) {
                    $distanceR = $args[0]['distance']['right'];
                }
            }

            if ($textWrap == 0) {
                $this->generateINLINE($distanceT, $distanceB, $distanceL, $distanceR);
            } else {
                if ($textWrap == 3) {
                    $this->generateANCHOR(1, $distanceT, $distanceB, $distanceL, $distanceR);
                } else {
                    $this->generateANCHOR(0, $distanceT, $distanceB, $distanceL, $distanceR);
                }
                $this->generateSIMPLEPOS();
                if (isset($args[0]['relativeToHorizontal'])) {
                    $this->generatePOSITIONH($args[0]['relativeToHorizontal']);
                } else {
                    $this->generatePOSITIONH();
                }
                if (isset($args[0]['float']) && ($args[0]['float'] == 'left' || $args[0]['float'] == 'right' || $args[0]['float'] == 'center')) {
                    $this->generateALIGN($args[0]['float']);
                }
                if (isset($args[0]['horizontalOffset']) && is_numeric($args[0]['horizontalOffset'])) {
                    $this->generatePOSOFFSET($args[0]['horizontalOffset']);
                } else {
                    $this->generatePOSOFFSET(0);
                }
                if (isset($args[0]['relativeToVertical'])) {
                    $this->generatePOSITIONV($args[0]['relativeToVertical']);
                } else {
                    $this->generatePOSITIONV();
                }
                if (isset($args[0]['verticalAlign'])) {
                    $this->generateALIGN($args[0]['verticalAlign']);
                }
                if (isset($args[0]['verticalOffset']) && is_numeric($args[0]['verticalOffset'])) {
                    $this->generatePOSOFFSET($args[0]['verticalOffset']);
                } else {
                    $this->generatePOSOFFSET(0);
                }
            }

            $this->generateEXTENT($tamWordX, $tamWordY);
            $this->generateEFFECTEXTENT($left, $top, $right, $bottom);

            switch ($textWrap) {
                case 1:
                    $this->generateWRAPSQUARE();
                    break;
                case 2:
                case 3:
                    $this->generateWRAPNONE();
                    break;
                case 4:
                    $this->generateWRAPTOPANDBOTTOM();
                    break;
                case 5:
                    $this->generateWRAPTHROUGH();
                    $this->generateWRAPPOLYGON();
                    $this->generateSTART();
                    $this->generateLINETO();
                    break;
                default:
                    break;
            }
            $this->generateDOCPR();
            if (isset($args[0]['rIdHyperlink'])) {
                $this->generateHYPERLINK($args[0]['rIdHyperlink']);
            }
            $this->generateCNVGRAPHICFRAMEPR();
            $this->generateGRAPHICPRAMELOCKS(1);
            $this->generateGRAPHIC();
            $this->generateGRAPHICDATA();
            $this->generatePIC();
            $this->generateNVPICPR();
            $this->generateCNVPR();
            $this->generateCNVPICPR();
            $this->generateBLIPFILL();
            $this->generateBLIP();
            $this->generateSTRETCH();
            $this->generateFILLRECT();
            $this->generateSPPR();
            $this->generateXFRM();
            $this->generateOFF();
            $this->generateEXT($tamWordX, $tamWordY);
            $this->generatePRSTGEOM();
            $this->generateAVLST();
            if (isset($args[0]['borderStyle']) ||
                    isset($args[0]['borderWidth']) ||
                    isset($args[0]['borderColor'])) {
                //width
                if (isset($args[0]['borderWidth'])) {
                    $this->generateLN($args[0]['borderWidth'] * CreateImage::TAMBORDER);
                } else {
                    $this->generateLN(CreateImage::TAMBORDER);
                }
                //color
                if (isset($args[0]['borderColor'])) {
                    $this->generateSOLIDFILL($args[0]['borderColor']);
                } else {
                    $this->generateSOLIDFILL('000000');
                }
                //style
                if (isset($args[0]['borderStyle'])) {
                    $this->generatePRSTDASH($args[0]['borderStyle']);
                } else {
                    $this->generatePRSTDASH('solid');
                }
            }

            $this->cleanTemplate();
        } else {
            PhpdocxLogger::logger('There was an error adding the image', 'fatal');
        }
    }

    /**
     * Init image
     *
     * @access public
     */
    public function initImage()
    {
        $args = func_get_args();

        if (!isset($args[0]['src'])) {
            $args[0]['src'] = '';
        }
        if (!isset($args[0]['textWrap'])) {
            $args[0]['textWrap'] = '';
        }
        if (!isset($args[0]['sizeX'])) {
            $args[0]['sizeX'] = '';
        }
        if (!isset($args[0]['sizeY'])) {
            $args[0]['sizeY'] = '';
        }
        if (!isset($args[0]['spacingTop'])) {
            $args[0]['spacingTop'] = '';
        }
        if (!isset($args[0]['spacingBottom'])) {
            $args[0]['spacingBottom'] = '';
        }
        if (!isset($args[0]['spacingLeft'])) {
            $args[0]['spacingLeft'] = '';
        }
        if (!isset($args[0]['spacingRight'])) {
            $args[0]['spacingRight'] = '';
        }
        if (!isset($args[0]['imageAlign'])) {
            $args[0]['imageAlign'] = '';
        }
        if (!isset($args[0]['border'])) {
            $args[0]['border'] = '';
        }
        if (!isset($args[0]['borderDiscontinuous'])) {
            $args[0]['borderDiscontinuous'] = '';
        }
        if (!isset($args[0]['scaling'])) {
            $args[0]['scaling'] = '';
        }
        if (!isset($args[0]['dpi'])) {
            $args[0]['dpi'] = '';
        }



        $this->_name = $args[0]['src'];
        $this->_textWrap = $args[0]['textWrap'];
        $this->_sizeX = $args[0]['sizeX'];
        $this->_sizeY = $args[0]['sizeY'];
        $this->_spacingTop = $args[0]['spacingTop'];
        $this->_spacingBottom = $args[0]['spacingBottom'];
        $this->_spacingLeft = $args[0]['spacingLeft'];
        $this->_spacingRight = $args[0]['spacingRight'];
        $this->_jc = $args[0]['imageAlign'];
        $this->_border = $args[0]['border'];
        $this->_borderDiscontinuous = $args[0]['borderDiscontinuous'];
        $this->_scaling = $args[0]['scaling'];
        $this->_dpiCustom = $args[0]['dpi'];
    }

    /**
     * Generate w:docpr
     *
     * @param string $id
     * @param string $name
     * @access protected
     */
    protected function generateDOCPR($id = "1", $name = "Picture 1")
    {
        $id = rand(999999, 999999999);
        $xml = '<' . CreateImage::NAMESPACEWORD . ':docPr id="' . $id .
                '" name="' . $name . '" descr="' . $this->parseAndCleanTextString($this->getName()) .
                '">__PHX=__GENERATEDOCPR__</' . CreateImage::NAMESPACEWORD .
                ':docPr>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:hlinkClick
     *
     * @param string $rIdHyperlink
     * @access protected
     */
    protected function generateHYPERLINK($rIdHyperlink)
    {
        $id = rand(999999, 999999999);
        $xml = '<a:hlinkClick r:id="rId' . $rIdHyperlink .
                '" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';

        $this->_xml = str_replace('__PHX=__GENERATEDOCPR__', $xml, $this->_xml);
    }

    /**
     * Get image jpg dpi
     *
     * @access private
     * @param string $filename
     * @return array
     */
    private function getDpiJpg($filename)
    {
        if ($this->_dpiCustom > 0) {
            return array($this->_dpiCustom, $this->_dpiCustom);
        }
        $a = fopen($filename, 'r');
        $string = fread($a, 20);
        fclose($a);
        $type = hexdec(bin2hex(substr($string, 13, 1)));
        $data = bin2hex(substr($string, 14, 4));
        if ($type == 1) {
            $x = substr($data, 0, 4);
            $y = substr($data, 4, 4);
            return array(hexdec($x), hexdec($y));
        } else if ($type == 2) {
            $x = floor(hexdec(substr($data, 0, 4)) / 2.54);
            $y = floor(hexdec(substr($data, 4, 4)) / 2.54);
            return array($x, $y);
        } else {
            return array($this->_dpi, $this->_dpi);
        }
    }

    /**
     * Get image png dpi
     *
     * @access private
     * @param string $filename
     * @return array
     */
    private function getDpiPng($filename)
    {
        if ($this->_dpiCustom > 0) {
            return array($this->_dpiCustom, $this->_dpiCustom);
        }
        $a = fopen($filename, 'r');

        $dpi = false;

        $buf = array();

        $x = 0;
        $y = 0;
        $units = 0;

        while (!feof($a)) {
            $contentFread = fread($a, 1);
            if (empty($contentFread)) {
                continue;
            }
            array_push($buf, ord($contentFread));
            if (count($buf) > 13) {
                array_shift($buf);
            }
            if (count($buf) < 13) {
                continue;
            }
            if ($buf[0] == ord('p') && $buf[1] == ord('H') && $buf[2] == ord('Y') && $buf[3] == ord('s')) {
                $x = ($buf[4] << 24) + ($buf[5] << 16) + ($buf[6] << 8) + $buf[7];
                $y = ($buf[8] << 24) + ($buf[9] << 16) + ($buf[10] << 8) + $buf[11];
                $units = $buf[12];
                break;
            }
        }

        fclose($a);

        if ($x == $y) {
            $dpi = $x;
        }

        if ($dpi != false && $units == 1) {
            // meters
            $dpi = round($dpi * 0.0254);
        }

        if ($dpi) {
            return array($dpi, $dpi);
        } else {
            return array($this->_dpi, $this->_dpi);
        }
    }

    /**
     * Get image webp dpi
     *
     * @access private
     * @param string $filename
     * @return array
     */
    private function getDpiWebp($filename)
    {
        if ($this->_dpiCustom > 0) {
            return array($this->_dpiCustom, $this->_dpiCustom);
        }

        return array($this->_dpi, $this->_dpi);
    }
}
