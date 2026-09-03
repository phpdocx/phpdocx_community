<?php
namespace Phpdocx\Elements;

use Phpdocx\Utilities\XmlUtilities;

/**
 * Creates a WordML fragment to be inserted elsewhere
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class WordMLFragment extends CreateElement
{
    /**
     *
     * @access private
     * @var string
     */
    private $_wordML;

    /**
     *
     * @access private
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
        return $this->_wordML;
    }

    /**
     * Adds a chunk of raw WordML
     *
     * @access public
     * @param string $data
     */
    public function addRawWordML($data)
    {
        $this->_wordML .= $data;
    }

    /**
     * returns only the runs of content for embedding
     *
     * @access public
     */
    public function inlineWordML()
    {
        $namespaces = 'xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" ';
        $wordML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:root ' . $namespaces . '>' . $this->_wordML;
        $wordML = $wordML . '</w:root>';
        $xmlUtilities = new XmlUtilities();
        $wordMLChunk = $xmlUtilities->generateDomDocument($wordML);
        $wordMLXpath = new \DOMXPath($wordMLChunk);
        $wordMLXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $wordMLXpath->registerNamespace('m', 'http://schemas.openxmlformats.org/wordprocessingml/2006/math');
        $query = '//w:r[not(ancestor::w:hyperlink or ancestor::v:textbox or ancestor::w:fldSimple or ancestor::w:ins or ancestor::w:del or ancestor::w:sdt or ancestor::w:ruby)] | //w:hyperlink | //w:bookmarkStart | //w:bookmarkEnd | //w:commentRangeStart | //w:commentRangeEnd | //m:oMath | //w:fldSimple | //w:ins | //w:del | //w:sdt[not(.//w:sdt)]';
        $wrNodes = $wordMLXpath->query($query);
        $blockCleaned = '';
        foreach ($wrNodes as $node) {
            // check if w:sdt includes w:p tags. Inline contents don't support them, so they must be removed with w:pPr tags
            if ($node->tagName == 'w:sdt') {
                $nodeR = $node->ownerDocument->saveXML($node);
                $nodesSdtContent = $node->getElementsByTagName('sdtContent');
                if ($nodesSdtContent->length > 0) {
                    foreach ($nodesSdtContent as $nodeSdtContent) {
                        $nodesSdtContentP = $nodeSdtContent->getElementsByTagName('p');
                        if ($nodesSdtContentP->length > 0) {
                            $nodeRStdP = '';
                            foreach ($nodesSdtContentP as $nodeSdtContentP) {
                                $contentNodeRStdP = $nodeSdtContentP->ownerDocument->saveXML($nodeSdtContentP);
                                $nodesSdtContentPR = $nodeSdtContentP->getElementsByTagName('r');
                                if ($nodesSdtContentPR->length > 0) {
                                    $contentNodeRStdR = '';
                                    foreach ($nodesSdtContentPR as $nodeSdtContentPR) {
                                        $contentNodeRStdR .= $nodeSdtContentPR->ownerDocument->saveXML($nodeSdtContentPR);
                                    }
                                }
                            }
                            if (isset($contentNodeRStdP) && isset($contentNodeRStdR)) {
                                $nodeR = str_replace($contentNodeRStdP, $contentNodeRStdR, $nodeR);
                            }
                        }
                    }
                }
            } else {
                $nodeR = $node->ownerDocument->saveXML($node);
            }

            $blockCleaned .= $nodeR;
        }

        return $blockCleaned;
    }

}
