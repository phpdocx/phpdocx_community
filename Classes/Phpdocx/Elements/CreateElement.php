<?php
namespace Phpdocx\Elements;

use Phpdocx\Utilities\XmlUtilities;

/**
 * Create tag elements
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateElement
{
    const MATHNAMESPACEWORD = 'm';
    const NAMESPACEWORD = 'w';

    /**
     *
     * @var string
     * @access protected
     */
    protected $_xml;

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
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     * Parse and clean a text string to be added
     *
     * @access public
     * @param string $content
     * @return string
     */
    public function parseAndCleanTextString($content) {
        $xmlUtilities = new XmlUtilities();
        $content = $xmlUtilities->parseAndCleanTextString($content);

        return $content;
    }

    /**
     * Delete pending tags
     *
     * @access protected
     */
    protected function cleanTemplate()
    {
        $this->_xml = preg_replace('/__PHX=__[A-Z]+__/', '', $this->_xml);
    }

    /**
     * Delete first w:rpr
     *
     * @access protected
     */
    protected function cleanTemplateFirstRPR()
    {
        $this->_xml = preg_replace('/__PHX=__GENERATERPR__/', '', $this->_xml, 1);
    }

    /**
     * Getter. Name
     *
     * @access public
     */
    public function getName() {}

    /**
     * Getter. Rid
     *
     * @access public
     */
    public function getRId() {}

    /**
     * Generate w:align
     *
     * @param string $align
     * @access protected
     */
    protected function generateALIGN($align)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':align>' . $align . '</' . CreateImage::NAMESPACEWORD .
                ':align>';

        $this->_xml = str_replace('__PHX=__GENERATEPOSITION__', $xml, $this->_xml);
    }

    /**
     * Generate w:anchor
     *
     * @access protected
     * @param mixed $behindDoc
     * @param string $distT
     * @param string $distB
     * @param string $distL
     * @param string $distR
     * @param int $simplePos
     * @param mixed $relativeHeight
     * @param mixed $locked
     * @param mixed $layoutInCell
     * @param mixed $allowOverlap
     */
    protected function generateANCHOR($behindDoc = 0, $distT = '0', $distB = '0', $distL = '0', $distR = '0', $simplePos = 0, $relativeHeight = '0', $locked = 0, $layoutInCell = 1, $allowOverlap = 1)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':anchor distT="' . $distT .
                '" distB="' . $distB . '" distL="' . $distL .
                '" distR="' . $distR . '" simplePos="' . $simplePos .
                '" relativeHeight="' . $relativeHeight .
                '" behindDoc="' . $behindDoc .
                '" locked="' . $locked .
                '" layoutInCell="' . $layoutInCell .
                '" allowOverlap="' . $allowOverlap .
                '">__PHX=__GENERATEINLINE__</' . CreateImage::NAMESPACEWORD .
                ':anchor>';

        $this->_xml = str_replace('__PHX=__GENERATEDRAWING__', $xml, $this->_xml);
    }

    /**
     * Generate w:avlst
     *
     * @access protected
     */
    protected function generateAVLST()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':avLst></' . CreateImage::NAMESPACEWORD1 .
                ':avLst>__PHX=__GENERATEPRSTGEOM__';

        $this->_xml = str_replace('__PHX=__GENERATEPRSTGEOM__', $xml, $this->_xml);
    }

    /**
     * Generate w:b and w:bCs
     *
     * @param string $val
     * @access protected
     */
    protected function generateB($val = 'off')
    {
        if ($val == 'single') {
            $val = 'on';
        }
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':b ' . CreateElement::NAMESPACEWORD .
                ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
                ':b><' . CreateElement::NAMESPACEWORD .
                ':bCs ' . CreateElement::NAMESPACEWORD .
                ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
                ':bCs>' .
                '__PHX=__GENERATERPR__';

        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:bcs
     *
     * @access protected
     */
    protected function generateBCS()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':bCs></' . CreateElement::NAMESPACEWORD .
                ':bCs>__PHX=__GENERATERPR__';

        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:blip
     *
     * @param string $cstate
     * @access protected
     */
    protected function generateBLIP($cstate = 'print')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':blip r:embed="rId' . $this->getRId() .
                '" cstate="' . $cstate .
                '"></' . CreateImage::NAMESPACEWORD1 .
                ':blip>__PHX=__GENERATEBLIPFILL__';

        $this->_xml = str_replace('__PHX=__GENERATEBLIPFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:blipfill
     *
     * @access protected
     */
    protected function generateBLIPFILL()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':blipFill>__PHX=__GENERATEBLIPFILL__</' .
                CreateImage::NAMESPACEWORD2 . ':blipFill>__PHX=__GENERATEPIC__';

        $this->_xml = str_replace('__PHX=__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:br
     *
     * @access protected
     * @param string $type
     */
    protected function generateBR($type = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':br ' .
                CreateElement::NAMESPACEWORD . ':type="' . $type . '"></' .
                CreateElement::NAMESPACEWORD . ':br>';
        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvgraphicframepr
     *
     * @access protected
     */
    protected function generateCNVGRAPHICFRAMEPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':cNvGraphicFramePr>__PHX=__GENERATECNVGRAPHICFRAMEPR__</' .
                CreateImage::NAMESPACEWORD .
                ':cNvGraphicFramePr>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvpicpr
     *
     * @access protected
     */
    protected function generateCNVPICPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':cNvPicPr></' . CreateImage::NAMESPACEWORD2 .
                ':cNvPicPr>__PHX=__GENERATENVPICPR__';

        $this->_xml = str_replace('__PHX=__GENERATENVPICPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:cnvpr
     *
     * @param string $id
     * @access protected
     */
    protected function generateCNVPR($id = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':cNvPr id="' . $id . '" name="' . $this->parseAndCleanTextString($this->getName()) .
                '"></' . CreateImage::NAMESPACEWORD2 .
                ':cNvPr>__PHX=__GENERATENVPICPR__';

        $this->_xml = str_replace('__PHX=__GENERATENVPICPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:docpr
     *
     * @param string $id
     * @param string $name
     * @access protected
     */
    protected function generateDOCPR($id = "1", $name = "0 Imagen")
    {
        $id = rand(999999, 999999999);
        $xml = '<' . CreateImage::NAMESPACEWORD . ':docPr id="' . $id .
                '" name="' . $name . '" descr="' . $this->getName() .
                '"></' . CreateImage::NAMESPACEWORD .
                ':docPr>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:drawing
     *
     * @access protected
     */
    protected function generateDRAWING()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':drawing xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">__PHX=__GENERATEDRAWING__</' .
                CreateElement::NAMESPACEWORD .
                ':drawing>';

        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:effectextent
     *
     * @param string $l
     * @param string $t
     * @param string $r
     * @param string $b
     * @access protected
     */
    protected function generateEFFECTEXTENT($l = "19050", $t = "0", $r = "4307", $b = "0")
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':effectExtent l="' . $l .
                '" t="' . $t . '" r="' . $r . '" b="' . $b .
                '"></' . CreateImage::NAMESPACEWORD .
                ':effectExtent>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:ext
     *
     * @param mixed $cx
     * @param mixed $cy
     * @access protected
     */
    protected function generateEXT($cx = '2997226', $cy = '2247918')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':ext cx="' . $cx . '" cy="' . $cy .
                '"></' . CreateImage::NAMESPACEWORD1 .
                ':ext>__PHX=__GENERATEXFRM__';

        $this->_xml = str_replace('__PHX=__GENERATEXFRM__', $xml, $this->_xml);
    }

    /**
     * Generate w:extent
     *
     * @param mixed $cx
     * @param mixed $cy
     * @access protected
     */
    protected function generateEXTENT($cx = '2986543', $cy = '2239906')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':extent cx="' . $cx .
                '" cy="' . $cy . '"></' . CreateImage::NAMESPACEWORD .
                ':extent>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:fillrect
     *
     * @access protected
     */
    protected function generateFILLRECT()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':fillRect></' . CreateImage::NAMESPACEWORD1 .
                ':fillRect>';

        $this->_xml = str_replace('__PHX=__GENERATESTRETCH__', $xml, $this->_xml);
    }

    /**
     * Generate w:graphic
     *
     * @param string $xmlns
     * @access protected
     */
    protected function generateGRAPHIC(
    $xmlns = 'http://schemas.openxmlformats.org/drawingml/2006/main')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':graphic xmlns:a="' . $xmlns .
                '">__PHX=__GENERATEGRAPHIC__</' . CreateImage::NAMESPACEWORD1 .
                ':graphic>';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:graphicpframelocks
     *
     * @param mixed $noChangeAspect
     * @access protected
     */
    protected function generateGRAPHICPRAMELOCKS($noChangeAspect = '')
    {
        $xmlAux = '<' . CreateImage::NAMESPACEWORD1 .
                ':graphicFrameLocks xmlns:a="' .
                'http://schemas.openxmlformats.org/drawingml/2006/main"';

        if ($noChangeAspect != '') {
            $xmlAux .= ' noChangeAspect="' . $noChangeAspect . '"';
        }
        $xmlAux .= '></' . CreateImage::NAMESPACEWORD1 . ':graphicFrameLocks>';

        $this->_xml = str_replace(
                '__PHX=__GENERATECNVGRAPHICFRAMEPR__', $xmlAux, $this->_xml
        );
    }

    /**
     * Generate w:graphicdata
     *
     * @param string $uri
     * @access protected
     */
    protected function generateGRAPHICDATA(
    $uri = 'http://schemas.openxmlformats.org/drawingml/2006/picture')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':graphicData uri="' . $uri .
                '">__PHX=__GENERATEGRAPHICDATA__</' . CreateImage::NAMESPACEWORD1 .
                ':graphicData>';

        $this->_xml = str_replace('__PHX=__GENERATEGRAPHIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:inline
     *
     * @param string $distT
     * @param string $distB
     * @param string $distL
     * @param string $distR
     * @access protected
     */
    protected function generateINLINE($distT = '0', $distB = '0', $distL = '0', $distR = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':inline distT="' . $distT . '" distB="' . $distB .
                '" distL="' . $distL . '" distR="' . $distR .
                '">__PHX=__GENERATEINLINE__</' . CreateImage::NAMESPACEWORD .
                ':inline>';

        $this->_xml = str_replace('__PHX=__GENERATEDRAWING__', $xml, $this->_xml);
    }

    /**
     * Generate w:jc
     *
     * @param string $val
     * @access protected
     */
    protected function generateJC($val = '')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':jc ' . CreateElement::NAMESPACEWORD . ':val="' . $val .
                '"></' . CreateElement::NAMESPACEWORD . ':jc>';

        $this->_xml = str_replace('__PHX=__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:lineto
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateLINETO($x = '-198', $y = '21342')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':lineTo x="' . $x . '" y="' . $y .
                '"></' . CreateImage::NAMESPACEWORD .
                ':lineTo>__PHX=__GENERATEWRAPPOLYGON__';

        $this->_xml = str_replace('__PHX=__GENERATEWRAPPOLYGON__', $xml, $this->_xml);
    }

    /**
     * Generate w:ln
     *
     * @param mixed $w
     * @param string $cap
     * @param string $cmpd
     * @param string $algn
     * @access protected
     */
    protected function generateLN($w = '12700', $cap = null, $cmpd = null, $algn = null)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':ln w="' . $w . '">__PHX=__GENERATELN__</' .
                CreateImage::NAMESPACEWORD1 .
                ':ln>__PHX=__GENERATESPPR__';

        $this->_xml = str_replace('__PHX=__GENERATESPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:noproof
     *
     * @access protected
     */
    protected function generateNOPROOF()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':noProof></' . CreateElement::NAMESPACEWORD .
                ':noProof>__PHX=__GENERATEPPR__';

        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:nvpicpr
     *
     * @access protected
     */
    protected function generateNVPICPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':nvPicPr>__PHX=__GENERATENVPICPR__</' . CreateImage::NAMESPACEWORD2 .
                ':nvPicPr>__PHX=__GENERATEPIC__';

        $this->_xml = str_replace('__PHX=__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:off
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateOFF($x = '0', $y = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':off x="' . $x . '" y="' . $y .
                '"></' . CreateImage::NAMESPACEWORD1 .
                ':off>__PHX=__GENERATEXFRM__';

        $this->_xml = str_replace('__PHX=__GENERATEXFRM__', $xml, $this->_xml);
    }

    /**
     * Generate w:p
     *
     * @access protected
     */
    protected function generateP()
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
                ':p>__PHX=__GENERATEP__</' . CreateElement::NAMESPACEWORD .
                ':p>';
    }

    /**
     * Generate w:pic
     *
     * @param string $pic
     * @access protected
     */
    protected function generatePIC(
    $pic = 'http://schemas.openxmlformats.org/drawingml/2006/picture')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':pic xmlns:pic="' . $pic .
                '">__PHX=__GENERATEPIC__</' . CreateImage::NAMESPACEWORD2 .
                ':pic>';

        $this->_xml = str_replace('__PHX=__GENERATEGRAPHICDATA__', $xml, $this->_xml);
    }

    /**
     * Generate w:pict
     *
     * @access protected
     */
    protected function generatePICT()
    {
        $this->_xml = str_replace(
                '__PHX=__GENERATER__', '<' . CreateElement::NAMESPACEWORD .
                ':pict>__PHX=__GENERATEPICT__</' . CreateElement::NAMESPACEWORD .
                ':pict>', $this->_xml
        );
    }

    /**
     * Generate w:positionh
     *
     * @param string $relativeFrom
     * @access protected
     */
    protected function generatePOSITIONH($relativeFrom = 'margin')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':positionH relativeFrom="' . $relativeFrom .
                '">__PHX=__GENERATEPOSITION__</' . CreateImage::NAMESPACEWORD .
                ':positionH>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:positionv
     *
     * @param string $relativeFrom
     * @access protected
     */
    protected function generatePOSITIONV($relativeFrom = 'line')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':positionV relativeFrom="' . $relativeFrom .
                '">__PHX=__GENERATEPOSITION__</' . CreateImage::NAMESPACEWORD .
                ':positionV>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:posoffset
     *
     * @param int $num
     * @access protected
     */
    protected function generatePOSOFFSET($num)
    {
        $xml = '<' . CreateImage::NAMESPACEWORD . ':posOffset>' . $num .
                '</' . CreateImage::NAMESPACEWORD . ':posOffset>';

        $this->_xml = str_replace('__PHX=__GENERATEPOSITION__', $xml, $this->_xml);
    }

    /**
     * Generate w:ppr
     *
     * @access protected
     */
    protected function generatePPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':pPr>__PHX=__GENERATEPPR__</' .
                CreateElement::NAMESPACEWORD . ':pPr>__PHX=__GENERATER__';

        $this->_xml = str_replace('__PHX=__GENERATEP__', $xml, $this->_xml);
    }

    /**
     * Generate w:prstdash
     *
     * @param string $val
     * @access protected
     */
    protected function generatePRSTDASH($val = 'sysDash')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':prstDash val="' . $val .
                '"></' . CreateImage::NAMESPACEWORD1 .
                ':prstDash>__PHX=__GENERATELN__';

        $this->_xml = str_replace('__PHX=__GENERATELN__', $xml, $this->_xml);
    }

    /**
     * Generate w:prstgeom
     *
     * @param string $prst
     * @access protected
     */
    protected function generatePRSTGEOM($prst = 'rect')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':prstGeom prst="' . $prst .
                '">__PHX=__GENERATEPRSTGEOM__</' . CreateImage::NAMESPACEWORD1 .
                ':prstGeom>__PHX=__GENERATESPPR__';

        $this->_xml = str_replace('__PHX=__GENERATESPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:pstyle
     *
     * @param string $val
     * @access protected
     */
    protected function generatePSTYLE($val = 'Textonotaalfinal')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':pStyle ' . CreateElement::NAMESPACEWORD .
                ':val="' . $val . '"></' . CreateElement::NAMESPACEWORD .
                ':pStyle>';

        $this->_xml = str_replace('__PHX=__GENERATEPPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:r
     *
     * @access protected
     */
    protected function generateQUITAR()
    {
        $this->_xml = '<' . CreateElement::NAMESPACEWORD .
                ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                ':r>';
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
                        ':r>__PHX=__GENERATESUBR__';

                $this->_xml = str_replace('__PHX=__GENERATEP__', $xml, $this->_xml);
            } elseif (preg_match("/__PHX=__GENERATER__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATESUBR__';

                $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
            } elseif (preg_match("/__PHX=__GENERATESUBR__/", $this->_xml)) {
                $xml = '<' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                        ':r>__PHX=__GENERATESUBR__';

                $this->_xml = str_replace(
                        '__PHX=__GENERATESUBR__', $xml, $this->_xml
                );
            }
        } else {
            $this->_xml = '<' . CreateElement::NAMESPACEWORD .
                    ':r>__PHX=__GENERATER__</' . CreateElement::NAMESPACEWORD .
                    ':r>__PHX=__GENERATESUBR__';
        }
    }

    /**
     * Generate w:rfonts
     *
     * @access protected
     * @param mixed $font
     */
    protected function generateRFONTS($font)
    {
        $fontAscii = '';
        $fontHAnsi = '';
        $fontEastAsia = '';
        $fontCs = '';

        if (is_array($font)) {
            if (isset($font['ascii'])) {
                $fontAscii = $font['ascii'];
            }
            if (isset($font['hAnsi'])) {
                $fontHAnsi = $font['hAnsi'];
            } else if (isset($font['ascii'])) {
                $fontHAnsi = $font['ascii'];
            }
            if (isset($font['eastAsia'])) {
                $fontEastAsia = $font['eastAsia'];
            } else if (isset($font['ascii'])) {
                $fontEastAsia = $font['ascii'];
            }
            if (isset($font['cs'])) {
                $fontCs = $font['cs'];
            } else if (isset($font['ascii'])) {
                $fontCs = $font['ascii'];
            }
        } else {
            $fontAscii = $font;
            $fontHAnsi = $font;
            $fontEastAsia = $font;
            $fontCs = $font;
        }

        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':rFonts ' . CreateElement::NAMESPACEWORD .
                ':ascii="' . $fontAscii . '" ' . CreateElement::NAMESPACEWORD .
                ':hAnsi="' . $fontHAnsi . '" ' . CreateElement::NAMESPACEWORD .
                ':eastAsia="' . $fontEastAsia . '" ' . CreateElement::NAMESPACEWORD .
                ':cs="' . $fontCs . '"></' . CreateElement::NAMESPACEWORD .
                ':rFonts>__PHX=__GENERATERPR__';

        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:rpr
     *
     * @access protected
     */
    protected function generateRPR()
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':rPr>__PHX=__GENERATERPR__</' . CreateElement::NAMESPACEWORD .
                ':rPr>__PHX=__GENERATER__';

        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:rstyle
     *
     * @param string $val
     * @access protected
     */
    protected function generateRSTYLE($val = 'PHPDOCXFootnoteReference')
    {
        $xml = '<' . CreateElement::NAMESPACEWORD .
                ':rStyle ' . CreateElement::NAMESPACEWORD .
                ':val="' . $val .
                '"></' . CreateElement::NAMESPACEWORD .
                ':rStyle>__PHX=__GENERATERPR__';

        $this->_xml = str_replace('__PHX=__GENERATERPR__', $xml, $this->_xml);
    }

    /**
     * Generate w:schemeclr
     *
     * @param string $val
     * @access protected
     */
    protected function generateSCHEMECLR($val = 'tx1')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 . ':schemeClr val="' . $val .
                '"></' . CreateImage::NAMESPACEWORD1 . ':schemeClr>';

        $this->_xml = str_replace('__PHX=__GENERATESOLIDFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:simplepos
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateSIMPLEPOS($x = '0', $y = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':simplePos x="' . $x . '" y="' . $y .
                '"></' . CreateImage::NAMESPACEWORD .
                ':simplePos>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:solidfill
     * @param string $color
     * @access protected
     */
    protected function generateSOLIDFILL($color = '000000')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':solidFill><a:srgbClr val="' . $color . '" /></' .
                CreateImage::NAMESPACEWORD1 .
                ':solidFill>__PHX=__GENERATELN__';
        $this->_xml = str_replace('__PHX=__GENERATELN__', $xml, $this->_xml);
    }

    /**
     * Generate w:sppr
     *
     * @access protected
     */
    protected function generateSPPR()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD2 .
                ':spPr>__PHX=__GENERATESPPR__</' . CreateImage::NAMESPACEWORD2 .
                ':spPr>';

        $this->_xml = str_replace('__PHX=__GENERATEPIC__', $xml, $this->_xml);
    }

    /**
     * Generate w:start
     *
     * @param string $x
     * @param string $y
     * @access protected
     */
    protected function generateSTART($x = '-198', $y = '0')
    {

        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':start x="' . $x . '" y="' . $y .
                '"></' . CreateImage::NAMESPACEWORD .
                ':start>__PHX=__GENERATEWRAPPOLYGON__';

        $this->_xml = str_replace('__PHX=__GENERATEWRAPPOLYGON__', $xml, $this->_xml);
    }

    /**
     * Generate w:stretch
     *
     * @access protected
     */
    protected function generateSTRETCH()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':stretch>__PHX=__GENERATESTRETCH__</' . CreateImage::NAMESPACEWORD1 .
                ':stretch>__PHX=__GENERATEBLIPFILL__';

        $this->_xml = str_replace('__PHX=__GENERATEBLIPFILL__', $xml, $this->_xml);
    }

    /**
     * Generate w:t
     *
     * @param string $dat
     * @access protected
     */
    protected function generateT($dat)
    {
        $xml = '<' . CreateElement::NAMESPACEWORD . ':t xml:space="preserve">' . $this->parseAndCleanTextString($dat) . '</' . CreateElement::NAMESPACEWORD . ':t>';

        $this->_xml = str_replace('__PHX=__GENERATER__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapnone
     *
     * @access protected
     */
    protected function generateWRAPNONE()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':wrapNone></' . CreateImage::NAMESPACEWORD .
                ':wrapNone>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrappolygon
     *
     * @param string $edited
     * @access protected
     */
    protected function generateWRAPPOLYGON($edited = '0')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':wrapPolygon edited="' . $edited .
                '">__PHX=__GENERATEWRAPPOLYGON__</' . CreateImage::NAMESPACEWORD .
                ':wrapPolygon>';

        $this->_xml = str_replace('__PHX=__GENERATEWRAPTHROUGH__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapsquare
     *
     * @param string $wrapText
     * @access protected
     */
    protected function generateWRAPSQUARE($wrapText = "bothSides")
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':wrapSquare wrapText="' . $wrapText .
                '"></' . CreateImage::NAMESPACEWORD .
                ':wrapSquare>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wrapthrough
     *
     * @param string $wrapText
     * @access protected
     */
    protected function generateWRAPTHROUGH($wrapText = 'bothSides')
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':wrapThrough wrapText="' . $wrapText .
                '">__PHX=__GENERATEWRAPTHROUGH__</' . CreateImage::NAMESPACEWORD .
                ':wrapThrough>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:wraptopandbottom
     *
     * @access protected
     */
    protected function generateWRAPTOPANDBOTTOM()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD .
                ':wrapTopAndBottom></' . CreateImage::NAMESPACEWORD .
                ':wrapTopAndBottom>__PHX=__GENERATEINLINE__';

        $this->_xml = str_replace('__PHX=__GENERATEINLINE__', $xml, $this->_xml);
    }

    /**
     * Generate w:xfrm
     *
     * @access protected
     */
    protected function generateXFRM()
    {
        $xml = '<' . CreateImage::NAMESPACEWORD1 .
                ':xfrm>__PHX=__GENERATEXFRM__</' . CreateImage::NAMESPACEWORD1 .
                ':xfrm>__PHX=__GENERATESPPR__';

        $this->_xml = str_replace('__PHX=__GENERATESPPR__', $xml, $this->_xml);
    }

}
