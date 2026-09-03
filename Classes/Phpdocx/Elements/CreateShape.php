<?php
namespace Phpdocx\Elements;
/**
 * Create shape
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class CreateShape extends CreateElement
{
    /**
     * Destruct
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
     * Create shape
     *
     * @access public
     * @param string $type
     * @param array $options
     */
    public function createShape($type = 'line', $options = array())
    {
        $VMLdata = '';
        switch ($type) {
            case 'arc':
                $VMLdata .= $this->generateArc($options);
                break;
            case 'curve':
                $VMLdata .= $this->generateCurve($options);
                break;
            case 'line':
                $VMLdata .= $this->generateLine($options);
                break;
            case 'polyline':
                $VMLdata .= $this->generatePolyline($options);
                break;
            case 'rect':
                $VMLdata .= $this->generateRect($options);
                break;
            case 'roundrect':
                $VMLdata .= $this->generateRoundrect($options);
                break;
            case 'shape':
                $VMLdata .= $this->generateShape($options);
                break;
            case 'oval':
                $VMLdata .= $this->generateOval($options);
                break;
            case 'straightArrow':
            case 'arrowLeft':
            case 'arrowRight':
            case 'customShape':
                $VMLdata .= $this->generateCustomShapeType($type, $options);
                break;
        }

        $VMLdata = '<w:pict>' . $VMLdata . '</w:pict>';
        return $VMLdata;
    }

    /**
     * Generates an arc shape
     *
     * @access protected
     * @param array $options
     */
    protected function generateArc($options)
    {
        $VML = '<v:arc style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['startAngle'])) {
            $VML .= 'startangle="' . $options['startAngle'] . '" ';
        }
        if (isset($options['endAngle'])) {
            $VML .= 'endangle="' . $options['endAngle'] . '" ';
        }
        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:arc>';

        return $VML;
    }

    /**
     * Generates a curve with two control points
     *
     * @access protected
     * @param array $options
     */
    protected function generateCurve($options)
    {
        $VML = '<v:curve style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['from'])) {
            $VML .= 'from="' . $options['from'] . '" ';
        }
        if (isset($options['control1'])) {
            $VML .= 'control1="' . $options['control1'] . '" ';
        }
        if (isset($options['control2'])) {
            $VML .= 'control2="' . $options['control2'] . '" ';
        }
        if (isset($options['to'])) {
            $VML .= 'to="' . $options['to'] . '" ';
        }
        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:curve>';

        return $VML;
    }

    /**
     * Generates a line between two points
     *
     * @access protected
     * @param array $options
     */
    protected function generateLine($options)
    {
        $VML = '<v:line style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['from'])) {
            $VML .= 'from="' . $options['from'] . '" ';
        }
        if (isset($options['to'])) {
            $VML .= 'to="' . $options['to'] . '" ';
        }

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:line>';

        return $VML;
    }

    /**
     * Generates a polyline
     *
     * @access protected
     * @param array $options
     */
    protected function generatePolyline($options)
    {
        $VML = '<v:polyline style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['points'])) {
            $VML .= 'points="' . $options['points'] . '" ';
        }

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:polyline>';

        return $VML;
    }

    /**
     * Generates a rectangle
     *
     * @access protected
     * @param array $options
     */
    protected function generateRect($options)
    {
        $VML = '<v:rect style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:rect>';

        return $VML;
    }

    /**
     * Generates a rectangle with rounded corners
     *
     * @access protected
     * @param array $options
     */
    protected function generateRoundrect($options)
    {
        $VML = '<v:roundrect style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['arcsize'])) {
            $VML .= 'arcsize="' . $options['arcsize'] . '" ';
        }

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:roundrect>';

        return $VML;
    }

    /**
     * Generates an arbitrary shape
     *
     * @access protected
     * @param array $options
     */
    protected function generateShape($options)
    {
        $VML = '<v:shape style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        if (isset($options['path'])) {
            $VML .= 'path="' . $options['path'] . '" ';
        }

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        if (isset($options['extraShapeStyles'])) {
            $VML .= $options['extraShapeStyles'];
        }
        if (isset($options['opacity'])) {
            $VML .= '<v:fill opacity="'.$options['opacity'].'%"/>';
        }

        $VML .= '</v:shape>';

        return $VML;
    }

    /**
     * Generates a custom shape type
     *
     * @access protected
     * @param string $type
     * @param array $options
     */
    protected function generateCustomShapeType($type, $options)
    {
        $VML = '';
        switch ($type) {
            case 'straightArrow':
                $VML .= '<v:shapetype coordsize="21600,21600" filled="f" id="_x0000_t32" o:oned="t" o:spt="32" path="m,l21600,21600e"><v:path arrowok="t" fillok="f" o:connecttype="none"/><o:lock shapetype="t" v:ext="edit"/></v:shapetype>';
                if (!isset($options['type'])) {
                    $options['type'] = '#_x0000_t32';
                }
                if (!isset($options['extraShapeStyles'])) {
                    $options['extraShapeStyles'] = '<v:stroke endarrow="block" joinstyle="miter"/>';
                }
                break;
            case 'arrowLeft':
                $VML .= '<v:shapetype adj="5400,5400" coordsize="21600,21600" id="_x0000_t66" o:spt="66" path="m@0,l@0@1,21600@1,21600@2@0@2@0,21600,,10800xe"><v:stroke joinstyle="miter"/><v:formulas><v:f eqn="val #0"/><v:f eqn="val #1"/><v:f eqn="sum 21600 0 #1"/><v:f eqn="prod #0 #1 10800"/><v:f eqn="sum #0 0 @3"/></v:formulas><v:path o:connectangles="270,180,90,0" o:connectlocs="@0,0;0,10800;@0,21600;21600,10800" o:connecttype="custom" textboxrect="@4,@1,21600,@2"/><v:handles><v:h position="#0,#1" xrange="0,21600" yrange="0,10800"/></v:handles></v:shapetype>';
                if (!isset($options['type'])) {
                    $options['type'] = '#_x0000_t66';
                }
                break;
            case 'arrowRight':
                $VML .= '<v:shapetype adj="16200,5400" coordsize="21600,21600" id="_x0000_t13" o:spt="13" path="m@0,l@0@1,0@1,0@2@0@2@0,21600,21600,10800xe"><v:stroke joinstyle="miter"/><v:formulas><v:f eqn="val #0"/><v:f eqn="val #1"/><v:f eqn="sum height 0 #1"/><v:f eqn="sum 10800 0 #1"/><v:f eqn="sum width 0 #0"/><v:f eqn="prod @4 @3 10800"/><v:f eqn="sum width 0 @5"/></v:formulas><v:path o:connectangles="270,180,90,0" o:connectlocs="@0,0;0,10800;@0,21600;21600,10800" o:connecttype="custom" textboxrect="0,@1,@6,@2"/><v:handles><v:h position="#0,#1" xrange="0,21600" yrange="0,10800"/></v:handles></v:shapetype>';
                if (!isset($options['type'])) {
                    $options['type'] = '#_x0000_t13';
                }
                break;
            case 'customShape':
                $VML .= $options['customShape'];
                break;
        }

        $VML .= $this->generateShape($options);

        return $VML;
    }

    /**
     * Generates an oval
     *
     * @access protected
     * @param array $options
     */
    protected function generateOval($options)
    {
        $VML = '<v:oval style="';
        $VML .= $this->generateVMLStyle($options) . '" ';

        $VML .= $this->generateGeneralVMLOptions($options) . ' ';

        $VML .= '>';

        $VML .= $this->generateTextImageContent($options) . ' ';

        $VML .= '</v:oval>';

        return $VML;
    }

    /**
     * Generates the VML styles
     *
     * @access private
     * @param array $options
     */
    private function generateVMLStyle($options)
    {
        $VMLstyle = '';

        if (isset($options['position'])) {
            $VMLstyle .= 'position:' . $options['position'] . ';';
        }
        if (isset($options['margin-top'])) {
            $VMLstyle .= 'margin-top:' . $options['margin-top'] . 'pt;';
        }
        /*
          if (isset($options['margin-right'])) {
          $VMLstyle .= 'margin-right:' . $options['margin-right'] . 'pt;';
          }
          if (isset($options['margin-bottom'])) {
          $VMLstyle .= 'margin-bottom:' . $options['margin-bottom'] . 'pt;';
          }
         */
        if (isset($options['margin-left'])) {
            $VMLstyle .= 'margin-left:' . $options['margin-left'] . 'pt;';
        }
        if (isset($options['width'])) {
            $VMLstyle .= 'width:' . $options['width'] . 'pt;';
        }
        if (isset($options['height'])) {
            $VMLstyle .= 'height:' . $options['height'] . 'pt;';
        }
        if (isset($options['z-index'])) {
            $VMLstyle .= 'z-index:' . $options['z-index'] . ';';
        } else {
            $VMLstyle .= 'z-index:' . rand(999, 99999) . ';';
        }
        if (isset($options['relativeToHorizontal'])) {
            $VMLstyle .= 'mso-position-horizontal-relative:' . $options['relativeToHorizontal'] . ';';
        }
        if (isset($options['relativeToVertical'])) {
            $VMLstyle .= 'mso-position-vertical-relative:' . $options['relativeToVertical'] . ';';
        }
        if (isset($options['rotation'])) {
            $VMLstyle .= 'rotation:' . $options['rotation'] . ';';
        }

        return $VMLstyle;
    }

    /**
     * Generates general VML options
     *
     * @access private
     * @param array $options
     */
    private function generateGeneralVMLOptions($options)
    {
        $VML = '';
        if (isset($options['coordsize'])) {
            $VML .= 'coordsize="' . $options['coordsize'] . '" ';
        }
        if (isset($options['fillcolor'])) {
            $VML .= 'fillcolor="' . $options['fillcolor'] . '" ';
        }
        if (isset($options['strokecolor'])) {
            $VML .= 'strokecolor="' . $options['strokecolor'] . '" ';
        }
        if (isset($options['strokeweight'])) {
            $VML .= 'strokeweight="' . $options['strokeweight'] . 'pt" ';
        }
        if (isset($options['type'])) {
            $VML .= 'type="' . $options['type'] . '" ';
        }

        return $VML;
    }

    /**
     * Generates text and image VML options
     *
     * @access private
     * @param array $options
     */
    private function generateTextImageContent($options)
    {
        $VML = '';

        if (isset($options['textContent'])) {
            if (!isset($options['height'])) {
                $options['height'] = 'auto';
            }
            $VML .= '<v:textbox';
            if ($options['height'] == 'auto') {
                $VML .= ' style="mso-fit-shape-to-text:t"';
            }
            $VML .= ' >';
            $VML .= '<w:txbxContent>';
            $VML .= $options['textContent'];
            $VML .= '</w:txbxContent></v:textbox>';
        }

        if (isset($options['imageContentrId'])) {
            $VML .= '<v:fill o:title="" r:id="rId'.$options['imageContentrId'].'" recolor="t" rotate="t" type="frame"/>';
        }

        return $VML;
    }
}