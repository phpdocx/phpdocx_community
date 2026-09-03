<?php
namespace Phpdocx\Create;

use Phpdocx;
use Phpdocx\AutoLoader;
use Phpdocx\BatchProcessing;
use Phpdocx\Charts\CreateChartFactory;
use Phpdocx\Clean;
use Phpdocx\Config;
use Phpdocx\Converters\MSWordInterface;
use Phpdocx\Crypto;
use Phpdocx\Elements\CreateFormElement;
use Phpdocx\Elements\CreateImage;
use Phpdocx\Elements\CreateImageCaption;
use Phpdocx\Elements\CreateList;
use Phpdocx\Elements\CreateListStyle;
use Phpdocx\Elements\CreatePage;
use Phpdocx\Elements\CreateParagraphStyle;
use Phpdocx\Elements\CreateProperties;
use Phpdocx\Elements\CreateRuby;
use Phpdocx\Elements\CreateShape;
use Phpdocx\Elements\CreateSource;
use Phpdocx\Elements\CreateStructuredDocumentTag;
use Phpdocx\Elements\CreateTable;
use Phpdocx\Elements\CreateTableContents;
use Phpdocx\Elements\CreateTableFigures;
use Phpdocx\Elements\CreateTableStyle;
use Phpdocx\Elements\CreateText;
use Phpdocx\Elements\CreateTextBox;
use Phpdocx\Elements\WordFragment;
use Phpdocx\Logger\PhpdocxLogger;
use Phpdocx\Parse\Repair;
use Phpdocx\Processing;
use Phpdocx\Resources\OOXMLResources;
use Phpdocx\Utilities\DOCXStructure;
use Phpdocx\Utilities\DOCXStructureTemplate;
use Phpdocx\Utilities\PhpdocxUtilities;
use Phpdocx\Utilities\XmlUtilities;

/**
 * Create a DOCX file
 *
 * @category   Phpdocx
 * @package    create
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
require_once __DIR__.'/../AutoLoader.php';
AutoLoader::load();
PhpdocxLogger::initErrorLevel();

class CreateDocx
{
    const VERSION = '1.0';
    const NAMESPACEWORD = 'w';
    const SCHEMA_IMAGEDOCUMENT = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image';
    const SCHEMA_OFFICEDOCUMENT = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument';

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $bookmarksIds;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $captionsIds;

    /**
     *
     * @access public
     * @static
     * @var bool
     */
    public static $cleanUTF8 = true;

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $elementsId = array();

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $elementsNotesId = array();

    /**
     *
     * @access public
     * @static
     * @var mixed
     */
    public static $_encodeUTF;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterExternalImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterLink;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsHeaderFooterObject;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesExternalImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesImage;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesLink;

    /**
     *
     * @access public
     * @var array
     * @static
     */
    public static $_relsNotesObject;

    /**
     *
     * @access public
     * @var mixed
     * @static
     */
    public static $bidi;

    /**
     *
     * @access public
     * @var bool
     * @static
     */
    public static $rtl;

    /**
     *
     * @access public
     * @var bool
     * @static
     */
    public static $returnDocxStructure = false;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $customLists;

    /**
     *
     * @var mixed
     * @access public
     */
    public $generateCustomRels;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $insertNameSpaces;

    /**
     *
     * @var array
     * @access public
     * @static
     */
    public static $nameSpaces;

    /**
     *
     * @var \DOMDocument
     * @access public
     */
    public $propsCore;

    /**
     *
     * @var \DOMDocument
     * @access public
     */
    public $propsApp;

    /**
     *
     * @var \DOMDocument
     * @access public
     */
    public $propsCustom;

    /**
     *
     * @var \DOMDocument
     * @access public
     */
    public $relsRels;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $numUL;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $numOL;

    /**
     *
     * @access public
     * @static
     * @var int
     */
    public static $intIdWord;

    /**
     *
     * @access public
     * @var string
     */
    public $wordML;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_background;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_backgroundColor;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_baseTemplateZip;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_contentTypeC;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_contentTypeT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_defaultFont;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_documentXMLElement;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_extension;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_idWords;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_language;
    /**
     *
     * @access protected
     * @var mixed
     */
    protected $_modifiedDocxProperties;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_modifiedHeadersFooters;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_modifiedRels;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_parsedStyles;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_parsedStylesChart;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_relsHeader;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_relsFooter;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_relsRelsC;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_relsRelsT;

    /**
     *
     * @access protected
     * @var mixed
     */
    protected $_sectPr;

    /**
     * Directory path used for temporary files
     *
     * @access protected
     * @var string
     */
    protected $_tempDir;

    /**
     * Temporary document DOM
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_tempDocumentDOM;

    /**
     * Unique id for the insertion of new elements
     *
     * @access protected
     * @var string
     */
    protected $_uniqid;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordCommentsT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordCommentsExtendedT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordCommentsRelsT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentC;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentT;

    /**
     *
     * @access protected
     * @var mixed
     */
    protected $_wordDocumentPeople;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordDocumentStyles;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordEndnotesT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordEndnotesRelsT;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordFooterC;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordFooterT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordFootnotesT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordFootnotesRelsT;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordHeaderC;

    /**
     *
     * @access protected
     * @var array
     */
    protected $_wordHeaderT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordNumberingT;

    /**
     *
     * @access protected
     * @var string
     */
    protected $_wordRelsDocumentRelsC;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordRelsDocumentRelsT;

    /**
     *
     * @access protected
     * @var mixed
     */
    protected $_wordSettingsT;

    /**
     *
     * @access protected
     * @var \DOMDocument
     */
    protected $_wordStylesT;

    /**
     *
     * @access protected
     * @var XmlUtilities XML Utilities classes
     */
    protected $xmlUtilities;

    /**
     *
     * @access protected
     * @var DOCXStructure
     */
    protected $_zipDocx;

    /**
     *
     * @access public
     * @var string
     */
    public $target = 'document';

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $templateStructure = new DOCXStructureTemplate();
        $this->_zipDocx = $templateStructure->getStructure();

        // initialize some required variables
        $this->_background = ''; // w:background OOXML element
        $this->_backgroundColor = 'FFFFFF'; // docx background color
        self::$bookmarksIds = array();
        self::$captionsIds = array();
        self::$elementsId = array();
        self::$elementsNotesId = array('comments' => 1, 'endnotes' => 1, 'footnotes' => 1);
        $this->_idWords = array();
        self::$intIdWord = rand(9999999, 99999999);
        self::$_encodeUTF = 0;
        $this->_language = 'en-US';
        $this->_relsRelsC = '';
        $this->_relsRelsT = '';
        $this->_contentTypeC = '';
        $this->_contentTypeT = null;
        $this->_defaultFont = '';
        $this->_modifiedDocxProperties = false;
        $this->_modifiedHeadersFooters= array();
        $this->_relsHeader = array();
        $this->_relsFooter = array();
        $this->_parsedStyles = array();
        $this->_parsedStylesChart = array();
        self::$_relsHeaderFooterImage = array();
        self::$_relsHeaderFooterExternalImage = array();
        self::$_relsHeaderFooterLink = array();
        self::$_relsNotesExternalImage = array();
        self::$_relsNotesImage = array();
        self::$_relsNotesLink = array();
        $this->_sectPr = null;
        $this->_tempDocumentDOM = null;
        $this->_uniqid = 'phpdocx_' . uniqid((string)mt_rand(999, 9999));
        $this->_wordCommentsT = new \DOMDocument();
        $this->_wordCommentsExtendedT = new \DOMDocument();
        $this->_wordCommentsRelsT = new \DOMDocument();
        $this->_wordDocumentPeople = new \DOMDocument();
        $this->_wordDocumentT = '';
        $this->_wordDocumentC = '';
        $this->_wordDocumentStyles = '';
        $this->_wordEndnotesT = new \DOMDocument();
        $this->_wordEndnotesRelsT = new \DOMDocument();
        $this->_wordFooterC = array();
        $this->_wordFooterT = array();
        $this->_wordFootnotesT = new \DOMDocument();
        $this->_wordFootnotesRelsT = new \DOMDocument();
        $this->_wordHeaderC = array();
        $this->_wordHeaderT = array();
        $this->_wordNumberingT = '';
        $this->_wordRelsDocumentRelsT = null;
        $this->_wordSettingsT = '';
        $this->_wordStylesT = null;
        $this->propsCore = null;
        $this->propsApp = null;
        $this->propsCustom = null;
        $this->generateCustomRels = null;
        $this->relsRels = null;
        $this->xmlUtilities = new XmlUtilities();
        self::$customLists = array();
        self::$insertNameSpaces = array();
        self::$nameSpaces = array();

        $baseTemplateDocumentT = $this->getFromZip('word/document.xml');

        // extract the w:document tag with its namespaces and attributes and the
        // w:background element if it exists
        $bodySplit = explode('<w:body>', $baseTemplateDocumentT);
        $tempDocumentXMLElement = $bodySplit[0];
        $backgroundSplit = explode('<w:background', $tempDocumentXMLElement);
        $this->_documentXMLElement = $backgroundSplit[0];
        if (!empty($backgroundSplit[1])) {
            $this->_background = '<w:background' . $backgroundSplit[1];
        }
        // do some manipulations with the DOM to get or not the file contents
        $baseDocument = $this->xmlUtilities->generateDomDocument($baseTemplateDocumentT);
        // parse for front page
        $docXpath = new \DOMXPath($baseDocument);
        $docXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        // extract namespaces
        $NSQuery = '//w:document/namespace::*';
        $xmlnsNodes = $docXpath->query($NSQuery);
        foreach ($xmlnsNodes as $node) {
            self::$nameSpaces[$node->nodeName] = $node->nodeValue;
        }
        $documentQuery = '//w:document';
        $documentElement = $docXpath->query($documentQuery)->item(0);
        foreach ($documentElement->attributes as $attribute_name => $attribute_node) {
            self::$nameSpaces[$attribute_name] = $attribute_node->nodeValue;
        }
        $queryDoc = '//w:body/w:sdt';
        $docNodes = $docXpath->query($queryDoc);

        if ($docNodes->length > 0) {
            if ($docNodes->item(0)->nodeName == 'w:sdt') {
                $tempDoc = new \DOMDocument();
                $sdt = $tempDoc->importNode($docNodes->item(0), true);
                $newNode = $tempDoc->appendChild($sdt);
                $frontPage = $tempDoc->saveXML($newNode);
                $this->_wordDocumentC .= $frontPage;
            }
        }
        // create the a tempDocumentDOM for further manipulation
        $this->_tempDocumentDOM = $this->getDOMDocx();
        $querySectPr = '//w:body/w:sectPr';
        $sectPrNodes = $docXpath->query($querySectPr);
        $sectPr = $sectPrNodes->item(0);
        $this->_sectPr = new \DOMDocument();
        $sectNode = $this->_sectPr->importNode($sectPr, true);
        $this->_sectPr->appendChild($sectNode);

        $this->_contentTypeT = $this->getFromZip('[Content_Types].xml', 'DOMDocument');

        // include the standard image defaults
        $this->generateDEFAULT('gif', 'image/gif');
        $this->generateDEFAULT('jpg', 'image/jpg');
        $this->generateDEFAULT('png', 'image/png');
        $this->generateDEFAULT('jpeg', 'image/jpeg');
        $this->generateDEFAULT('bmp', 'image/bmp');

        // get the rels file
        $this->_wordRelsDocumentRelsT = $this->getFromZip('word/_rels/document.xml.rels', 'DOMDocument');
        $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');

        // get the styles
        $this->_wordStylesT = $this->getFromZip('word/styles.xml', 'DOMDocument');
        // get the settings
        $this->_wordSettingsT = $this->getFromZip('word/settings.xml', 'DOMDocument');

        // get the numbering
        // if it does not exist it will return false
        $this->_wordNumberingT = $this->getFromZip('word/numbering.xml');

        // get and keep numbering IDs
        if ($this->_wordNumberingT !== false) {
            $wordNumberingTDOM = $this->xmlUtilities->generateDomDocument($this->_wordNumberingT);
            $numberingIdsDocument = $wordNumberingTDOM->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'num');
            if ($numberingIdsDocument->length > 0) {
                foreach ($numberingIdsDocument as $numberingIdDocument) {
                    if ($numberingIdDocument->hasAttribute('w:numId')) {
                        self::$elementsId[] = (int)$numberingIdDocument->getAttribute('w:numId');
                    }
                }
            }
        }

        // manage the numbering.xml and style.xml files
        // first check if the base template file has a numbering.xml file
        self::$numUL = self::uniqueNumberId(999, 32000);
        self::$numOL = self::uniqueNumberId(999, 32000);
        if ($this->_wordNumberingT !== false) {
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$unorderedListStyle, self::$numUL);
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
        } else {
            $this->_wordNumberingT = $this->generateBaseWordNumbering();
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$unorderedListStyle, self::$numUL);
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
            // include the corresponding relationship Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'numbering', 'numbering.xml'
            );
            $this->generateOVERRIDE('/word/numbering.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml');
        }
        // make sure that there are the corresponding xmls, with all their relationships for endnotes and footnotes
        // footnotes
        if ($this->getFromZip('word/footnotes.xml') === false) {
            $this->_wordFootnotesT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$footnotesXML);
            // include the corresponding relationship and Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'footnotes', 'footnotes.xml'
            );
            $this->generateOVERRIDE('/word/footnotes.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.footnotes+xml');
        } else {
            $this->_wordFootnotesT = $this->getFromZip('word/footnotes.xml', 'DOMDocument');

            // get and keep the max ID
            $footnotesDocument = $this->_wordFootnotesT->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'footnote');
            $maxIdFootnote = 1;
            if ($footnotesDocument->length > 0) {
                foreach ($footnotesDocument as $footnoteDocument) {
                    if ($footnoteDocument->hasAttribute('w:id')) {
                        $idFootnote = (int)$footnoteDocument->getAttribute('w:id');
                        if ($idFootnote > $maxIdFootnote) {
                            $maxIdFootnote = $idFootnote;
                        }
                    }
                }
            }
            self::$elementsNotesId['footnotes'] = $maxIdFootnote + 1;
        }
        if ($this->getFromZip('word/_rels/footnotes.xml.rels') === false) {
            $this->_wordFootnotesRelsT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordFootnotesRelsT = $this->getFromZip('word/_rels/footnotes.xml.rels', 'DOMDocument');
        }
        // endnotes
        if ($this->getFromZip('word/endnotes.xml') === false) {
            $this->_wordEndnotesT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$endnotesXML);
            // include the corresponding relationship Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'endnotes', 'endnotes.xml'
            );
            $this->generateOVERRIDE('/word/endnotes.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.endnotes+xml');
        } else {
            $this->_wordEndnotesT = $this->getFromZip('word/endnotes.xml', 'DOMDocument');

            // get and keep the max ID
            $endnotesDocument = $this->_wordEndnotesT->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'endnote');
            $maxIdEndnote = 1;
            if ($endnotesDocument->length > 0) {
                foreach ($endnotesDocument as $endnoteDocument) {
                    if ($endnoteDocument->hasAttribute('w:id')) {
                        $idEndnote = (int)$endnoteDocument->getAttribute('w:id');
                        if ($idEndnote > $maxIdEndnote) {
                            $maxIdEndnote = $idEndnote;
                        }
                    }
                }
            }
            self::$elementsNotesId['endnotes'] = $maxIdEndnote + 1;
        }
        if ($this->getFromZip('word/_rels/endnotes.xml.rels') === false) {
            $this->_wordEndnotesRelsT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordEndnotesRelsT = $this->getFromZip('word/_rels/endnotes.xml.rels', 'DOMDocument');
        }
        // comments
        if ($this->getFromZip('word/comments.xml') === false) {
            $this->_wordCommentsT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$commentsXML);
            // include the corresponding relationship Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'comments', 'comments.xml'
            );
            $this->generateOVERRIDE('/word/comments.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.comments+xml');
        } else {
            $this->_wordCommentsT = $this->getFromZip('word/comments.xml', 'DOMDocument');

            // get and keep the max ID
            $commentsDocument = $this->_wordCommentsT->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'comment');
            $maxIdComment = 1;
            if ($commentsDocument->length > 0) {
                foreach ($commentsDocument as $commentDocument) {
                    if ($commentDocument->hasAttribute('w:id')) {
                        $idComment = (int)$commentDocument->getAttribute('w:id');
                        if ($idComment > $maxIdComment) {
                            $maxIdComment = $idComment;
                        }
                    }
                }
            }
            self::$elementsNotesId['comments'] = $maxIdComment + 1;
        }
        if ($this->getFromZip('word/_rels/comments.xml.rels') === false) {
            $this->_wordCommentsRelsT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$notesXMLRels);
        } else {
            $this->_wordCommentsRelsT = $this->getFromZip('word/_rels/comments.xml.rels', 'DOMDocument');
        }
        // commentsExtended
        if ($this->getFromZip('word/commentsExtended.xml') === false) {
            $this->_wordCommentsExtendedT = $this->xmlUtilities->generateDomDocument(OOXMLResources::$commentsExtendedXML);
            // include the corresponding relationship and Override
            $this->generateRELATIONSHIP(
                    'rId' . rand(99999999, 999999999), 'commentsExtended', 'commentsExtended.xml'
            );
            $this->generateOVERRIDE('/word/commentsExtended.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.commentsExtended+xml');
        } else {
            $this->_wordCommentsExtendedT = $this->getFromZip('word/commentsExtended.xml', 'DOMDocument');
        }

        // take care of the case that the template used is not one of the default preprocessed templates

        self::$numUL = 1;
        self::$numOL = self::uniqueNumberId(999, 32000);
        //make sure that we are using the default paper size and the default language
        $this->modifyPageLayout('A4');
        $this->setLanguage('en-US');
        //set bidi and rtl static variables
        self::$bidi = false;
        self::$rtl = false;
    }

    /**
     * Magic method, returns current word XML
     *
     * @access public
     * @return string Return current word
     */
    public function __toString()
    {
        $this->generateTemplateWordDocument();
        PhpdocxLogger::logger('Get document template content.', 'debug');

        return $this->_wordDocumentT;
    }

    /**
     * Setter
     *
     * @access public
     */
    public function setXmlWordDocument($domDocument)
    {
        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
    }

    /**
     * Getter DOMDocx
     *
     * @access public
     */
    public function getDOMDocx()
    {
        $loadContent = $this->_documentXMLElement . '<w:body>' . $this->_wordDocumentC . '</w:body></w:document>';
        $domDocument = $this->xmlUtilities->generateDomDocument($loadContent);

        return $domDocument;
    }

    /**
     * Getter DOMComments
     *
     * @access public
     */
    public function getDOMComments()
    {
        return $this->_wordCommentsT;
    }

    /**
     * Getter DOMEndnotes
     *
     * @access public
     */
    public function getDOMEndnotes()
    {
        return $this->_wordEndnotesT;
    }

    /**
     * Getter DOMFootnotes
     *
     * @access public
     */
    public function getDOMFootnotes()
    {
        return $this->_wordFootnotesT;
    }

    /**
     * Adds a bookmark start or end tag
     *
     * @access public
     * @param array $options
     * Values:
     * 'type' (start, end)
     * 'name' (string)
     * @throws \Exception lack of required parameters, incorrect type
     */
    public function addBookmark($options = array('type' => null, 'name' => null))
    {
        $type = $options['type'];
        $name = $options['name'];
        // first check for the requested parameters
        if (empty($type) || empty($name)) {
            PhpdocxLogger::logger('The addBookmark method is lacking at least one required parameter', 'fatal');
        }
        if ($type == 'start') {
            $bookmarkId = rand(9999999, 999999999);
            $bookmark = '<w:bookmarkStart w:id="' . $bookmarkId . '" w:name="' . $name . '" />';
            CreateDocx::$bookmarksIds[$name] = $bookmarkId;
        } else if ($type == 'end') {
            $bookmark = '<w:bookmarkEnd w:id="' . CreateDocx::$bookmarksIds[$name] . '" />';
            unset(CreateDocx::$bookmarksIds[$name]);
        } else {
            PhpdocxLogger::logger('The addBookmark type is incorrect', 'fatal');
        }
        PhpdocxLogger::logger('Adds a bookmark' . $type . ' to the Word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $bookmark;
        } else {
            $this->_wordDocumentC .= (string) $bookmark;
        }
    }

    /**
     * Adds a break
     *
     * @access public
     * @param array $options
     *  Values:
     * 'type' (line, page, column)
     * 'number' (int) the number of breaks that we want to include
     */
    public function addBreak($options = array('type' => 'line', 'number' => 1))
    {
        if (!isset($options['type'])) {
            $options['type'] = 'line';
        }
        if (!isset($options['number'])) {
            $options['number'] = 1;
        }

        $break = CreatePage::getInstance();
        $break->generatePageBreak($options);

        $contentElement = (string)$break;

        PhpdocxLogger::logger('Add break to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a caption
     *
     * @access public
     * @param string $text caption text
     * @param array $options paragraph style options. Other styles from createParagraphStyle can be used
     *      'align' (string): text align
     *      'bookmarkName' (string): set a custom bookmark name. Default as _GoBack
     *      'color' (string): text color. HEX value. Default as 1F497D
     *      'fontSize' (int): text size in half-points. Default as 18
     *      'keepNext' (bool) keep in the same page the current paragraph with next paragraph. Default as false
     *      'lineSpacing' (int): text line spacing. Default as 240
     *      'pStyle' (string): set a custom style name applied to the paragraph. This option overwrites the 'styleName' option as custom paragraph style
     *      'showLabel' (bool): show default value. Default as true
     *      'styleName' (string): allow setting a custom style name, useful to generate table of figures based on style names. Default as Caption
     *      'wrapTextInBookmarks' (bool): wrap text content between bookmarks. Default as true
     */
    public function addCaption($text, $options = array())
    {
        $options['label'] = $text;

        if ($this instanceof WordFragment) {
            $this->addImageCaption(true, $options);
        } else {
            $this->addImageCaption(false, $options);
        }
    }

    /**
     * Adds a comment
     *
     * @access public
     * @param array $options
     *  Values:
     * 'textDocument'(mixed) a string of text or WordFragment to appear in the document body as anchor for the comment or an array with the text and associated text options or a WordFragment
     * 'textComment' (mixed) a string of text to be used as the comment text or a WordFragment
     * 'textComments' (array) multiple comments
     * 'initials' (string)
     * 'author' (string)
     * 'date' (string) strtotime
     * 'completed' (bool) false as default
     * 'paraId' (string) if null, auto generate it (HEX value)
     * 'parentId' (string) reply a comment
     * 'pStyle' (string) paragraph style to be used
     * 'rStyle' (string) character style to be used
     */
    public function addComment($options = array())
    {
        // default values
        $commentPStyle = 'CommentTextPHPDOCX';
        $commentRStyle = 'CommentReferencePHPDOCX';
        if (isset($options['pStyle'])) {
            $commentPStyle = $options['pStyle'];
        }
        if (isset($options['rStyle'])) {
            $commentRStyle = $options['rStyle'];
        }

        // if there's no textComments a single comment will be added
        if (!isset($options['textComments'])) {
            $options['textComments'] = array();
            $options['textComments'][0]['textComment'] = $options['textComment'];
            if (isset($options['initials'])) {
                $options['textComments'][0]['initials'] = $options['initials'];
            }
            if (isset($options['author'])) {
                $options['textComments'][0]['author'] = $options['author'];
            }
            if (isset($options['date'])) {
                $options['textComments'][0]['date'] = $options['date'];
            }
            if (isset($options['completed'])) {
                $options['textComments'][0]['completed'] = $options['completed'];
            }
            if (isset($options['paraId'])) {
                $options['textComments'][0]['paraId'] = $options['paraId'];
            }
        }

        $commentDocument = new WordFragment();
        if (count($options['textComments']) > 0) {
            if (!is_array($options['textDocument'])) {
                $options['textDocument'] = array('text' => $options['textDocument']);
            }
            $textOptions = $options['textDocument'];
            $multipleBlocks = false;
            if (isset($textOptions['text'])) {
                $text = $textOptions['text'];
                $textOptions = self::setRTLOptions($textOptions);
                if (isset($options['textDocument']['text']) && $options['textDocument']['text'] instanceof WordFragment) {
                    $commentDocument->addText(array('text' => $text), $textOptions);
                } else {
                    $commentDocument->addText($text, $textOptions);
                }
            } else if (is_array($textOptions)) {
                // handle multiple WordFragments
                foreach ($textOptions as $textOption) {
                    if ($textOption instanceof WordFragment) {
                        $multipleBlocks = true;
                        $commentDocument->addWordFragment($textOption);
                    }
                }
            }
            foreach ($options['textComments'] as $textComments) {
                $id = ++self::$elementsNotesId['comments'];
                $idBookmark = uniqid((string)mt_rand(999, 9999));
                if ($textComments['textComment'] instanceof WordFragment) {
                    $commentBase = '<w:comment w:id="' . $id . '"';
                    if (isset($textComments['initials'])) {
                        $commentBase .= ' w:initials="' . $this->parseAndCleanTextString($textComments['initials']) . '"';
                    }
                    if (isset($textComments['author'])) {
                        $commentBase .= ' w:author="' . $this->parseAndCleanTextString($textComments['author']) . '"';
                    }
                    if (isset($textComments['date'])) {
                        $commentBase .= ' w:date="' . date("Y-m-d\TH:i:s\Z", strtotime($textComments['date'])) . '"';
                    }
                    $commentBase .= ' xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                        xmlns:o="urn:schemas-microsoft-com:office:office"
                        xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                        xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                        xmlns:v="urn:schemas-microsoft-com:vml"
                        xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                        xmlns:w10="urn:schemas-microsoft-com:office:word"
                        xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                        xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                        xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"
                        xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml"
                        xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing"
                        >';
                    $commentBase .= $this->parseWordMLNote('comment', $textComments['textComment'], array(), array());
                    $commentBase = preg_replace('/__PHX=__[A-Z]+__/', '', $commentBase);
                    $commentBase .= '<w:bookmarkStart w:id="' . $idBookmark . '" w:name="_GoBack"/><w:bookmarkEnd w:id="' . $idBookmark . '"/>';
                    $commentBase .= '</w:comment>';
                } else {
                    $commentBase = '<w:comment w:id="' . $id . '"';
                    if (isset($textComments['initials'])) {
                        $commentBase .= ' w:initials="' . $this->parseAndCleanTextString($textComments['initials']) . '"';
                    }
                    if (isset($textComments['author'])) {
                        $commentBase .= ' w:author="' . $this->parseAndCleanTextString($textComments['author']) . '"';
                    }
                    if (isset($textComments['date'])) {
                        $commentBase .= ' w:date="' . date("Y-m-d\TH:i:s\Z", strtotime($textComments['date'])) . '"';
                    }
                    $commentBase .= ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml"><w:p><w:pPr><w:pStyle w:val="'.$commentPStyle.'"/>';
                    if (self::$bidi) {
                        $commentBase .= '<w:bidi />';
                    }
                    $commentBase .= '</w:pPr>';
                    $commentBase .= '<w:r><w:rPr><w:rStyle w:val="'.$commentRStyle.'"/>';
                    if (self::$rtl) {
                        $commentBase .= '<w:rtl />';
                    }
                    $commentBase .= '</w:rPr><w:annotationRef/></w:r>';
                    $commentBase .= '<w:r>';
                    if (self::$rtl) {
                        $commentBase .= '<w:rPr><w:rtl /></w:rPr>';
                    }
                    $commentBase .= '<w:t xml:space="preserve">' . $this->parseAndCleanTextString($textComments['textComment']) . '</w:t></w:r></w:p>';
                    $commentBase .= '<w:bookmarkStart w:id="' . $idBookmark . '" w:name="_GoBack"/><w:bookmarkEnd w:id="' . $idBookmark . '"/>';
                    $commentBase .= '</w:comment>';
                }
                $commentStart = '</w:pPr><w:commentRangeStart w:id="' . $id . '"/>';
                $commentEnd = '<w:commentRangeEnd w:id="' . $id . '"/><w:r><w:rPr><w:rStyle w:val="'.$commentRStyle.'"/>';
                if (self::$rtl) {
                    $commentEnd .= '<w:rtl />';
                }
                $commentEnd .= '</w:rPr><w:commentReference w:id="' . $id . '"/></w:r></w:p>';
                // clean the commentDocument from auxiliary variable
                $commentDocument = preg_replace('/__PHX=__[A-Z]+__/', '', $commentDocument);
                // prepare the data
                if (!$multipleBlocks) {
                    $commentDocument = str_replace('</w:pPr>', $commentStart, $commentDocument);
                    $commentDocument = str_replace('</w:p>', $commentEnd, $commentDocument);
                } else {
                    // add start comment in the first block content
                    $posPpr = strpos($commentDocument, '</w:pPr>');
                    if ($posPpr !== false) {
                        $commentDocument = substr_replace($commentDocument, $commentStart, $posPpr, strlen('</w:pPr>'));
                    }
                    // add end comment in the last block content
                    $posP = strrpos($commentDocument, '</w:p>');
                    if ($posP !== false) {
                        $commentDocument = substr_replace($commentDocument, $commentEnd, $posP, strlen('</w:p>'));
                    }
                }

                // generate a w14:paraId to relate to commentsExtended
                if (isset($textComments['paraId'])) {
                    $paraId = $textComments['paraId'];
                } else {
                    $paraId = dechex(mt_rand(9, 999999));
                }
                $commentBase = str_replace('<w:p>', '<w:p w14:paraId="'.$paraId.'">', $commentBase);

                $tempNode = $this->_wordCommentsT->createDocumentFragment();
                $tempNode->appendXML($commentBase);
                $this->_wordCommentsT->documentElement->appendChild($tempNode);

                // generate _wordCommentsExtendedT
                $commentExtendedBase = '<w15:commentEx xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" ';
                if (isset($textComments['completed']) && $textComments['completed']) {
                    $commentExtendedBase .= 'w15:done="1" ';
                } else {
                    $commentExtendedBase .= 'w15:done="0" ';
                }
                $commentExtendedBase .= 'w15:paraId="'.$paraId.'" ';
                if (isset($textComments['parentId']) && $textComments['parentId']) {
                    $commentExtendedBase .= 'w15:paraIdParent="'.$textComments['parentId'].'" ';
                }
                $commentExtendedBase .= '/>';
                $tempNodeExtended = $this->_wordCommentsExtendedT->createDocumentFragment();
                $tempNodeExtended->appendXML($commentExtendedBase);
                $this->_wordCommentsExtendedT->documentElement->appendChild($tempNodeExtended);
            }
        }

        PhpdocxLogger::logger('Add comment to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $commentDocument;
        } else {
            $this->_wordDocumentC .= (string) $commentDocument;
        }
    }

    /**
     * Adds a cross reference
     *
     * @access public
     * @param string $text Text of the reference
     * @param array $options
     *  Values:
     * 'type' (bookmark, heading)
     * 'modifiers' (string) custom modifiers: \r \h, \n \h...
     * 'referenceName' (string) the name of the element to be referred
     * 'referenceTo' (string) content to display when the field is updated PAGEREF (default), REF, ABOVE_BELOW
     * For other options @see addText
     */
    public function addCrossReference($text, $options = array())
    {
        if (!isset($options['type'])) {
            $options['type'] = 'bookmark';
        }
        if (!isset($options['referenceTo'])) {
            $options['referenceTo'] = 'PAGEREF';
        }
        $modifiers = ' \h';
        if ($options['referenceTo'] == 'ABOVE_BELOW') {
            $options['referenceTo'] = 'REF';
            $modifiers = ' \p \h';
        }

        if (isset($options['modifiers'])) {
            $modifiers = $options['modifiers'];
        }

        if ($options['type'] == 'bookmark') {
            if (!isset($options['color'])) {
                $options['color'] = '0000ff';
            }
            if (!isset($options['u']) && !isset($options['underline'])) {
                $options['underline'] = 'single';
            }
            $options = self::setRTLOptions($options);
            $url = $options['referenceTo'] . ' ' . $options['referenceName'] . $modifiers;
            if (isset($options['color'])) {
                $color = $options['color'];
            } else {
                $color = '0000ff';
            }
            if (isset($options['u'])) {
                $u = $options['u'];
            } else {
                $u = 'single';
            }
            $textOptions = $options;
            $link = new WordFragment();
            $link->addText($text, $textOptions);
            $link = preg_replace('/__PHX=__[A-Z]+__/', '', $link);
            $startNodes = '<w:r><w:fldChar w:fldCharType="begin" /></w:r><w:r>
            <w:instrText xml:space="preserve">' . $url . '</w:instrText>
            </w:r><w:r><w:fldChar w:fldCharType="separate" /></w:r>';
            if (strstr($link, '</w:pPr>')) {
                $link = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $startNodes, $link);
            } else {
                $link = preg_replace('/<w:p>/', '<w:p>' . $startNodes, $link);
            }
            $endNode = '<w:r><w:fldChar w:fldCharType="end" /></w:r>';
            $link = preg_replace('/<\/w:p>/', $endNode . '</w:p>', $link);
            PhpdocxLogger::logger('Add link to word document.', 'info');

            $contentElement = (string)$link;

            if ($this instanceof WordFragment) {
                $this->wordML .= $contentElement;
            } else {
                $this->_wordDocumentC .= $contentElement;
            }
        } elseif ($options['type'] == 'heading') {
            $domDocument = $this->xmlUtilities->generateDomDocument($this->_documentXMLElement . '<w:body>' . $this->_wordDocumentC . '</w:body></w:document>');
            $domNodeList = $domDocument->getElementsByTagNameNS("http://schemas.openxmlformats.org/wordprocessingml/2006/main", "pStyle");

            foreach ($domNodeList as $styleNode) {
                $styleValue = $styleNode->getAttribute("w:val");
                if (strpos($styleValue, "Heading") !== false) {
                    $parentParagraph = $styleNode->parentNode->parentNode;
                    $headingWordsList = $parentParagraph->getElementsByTagNameNS("http://schemas.openxmlformats.org/wordprocessingml/2006/main", "t");
                    $headingText = '';

                    foreach ($headingWordsList as $word) {
                        $headingText = $headingText.$word->nodeValue;
                    }

                    if ($headingText == $options['referenceName']) {
                        if (!isset($options['color'])) {
                            $options['color'] = '0000ff';
                        }
                        if (!isset($options['u']) && !isset($options['underline'])) {
                            $options['underline'] = 'single';
                        }
                        $options = self::setRTLOptions($options);
                        $url = $options['referenceTo'] . ' ' . $options['referenceName'] . $modifiers;
                        if (isset($options['color'])) {
                            $color = $options['color'];
                        } else {
                            $color = '0000ff';
                        }
                        if (isset($options['u'])) {
                            $u = $options['u'];
                        } else {
                            $u = 'single';
                        }
                        $textOptions = $options;
                        $link = new WordFragment();
                        $link->addText($text, $textOptions);
                        $link = preg_replace('/__PHX=__[A-Z]+__/', '', $link);
                        $startNodes = '<w:r><w:fldChar w:fldCharType="begin" /></w:r><w:r>
                        <w:instrText xml:space="preserve">' . $url . '</w:instrText>
                        </w:r><w:r><w:fldChar w:fldCharType="separate" /></w:r>';
                        if (strstr($link, '</w:pPr>')) {
                            $link = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $startNodes, $link);
                        } else {
                            $link = preg_replace('/<w:p>/', '<w:p>' . $startNodes, $link);
                        }
                        $endNode = '<w:r><w:fldChar w:fldCharType="end" /></w:r>';
                        $link = preg_replace('/<\/w:p>/', $endNode . '</w:p>', $link);
                        PhpdocxLogger::logger('Add link to word document.', 'info');

                        $contentElement = (string)$link;

                        if ($this instanceof WordFragment) {
                            $this->wordML .= $contentElement;
                        } else {
                            $this->_wordDocumentC .= $contentElement;
                        }

                        $bookmarkId = rand(9999999, 999999999);
                        $bookmarkName = str_replace(" ", '_', $options['referenceName']);
                        $bookmarkName = '_'.$bookmarkName;
                        CreateDocx::$bookmarksIds[$bookmarkName] = $bookmarkId;

                        $bookmarkStart = $domDocument->createElement('w:bookmarkStart');
                        $bookmarkStart->setAttribute('w:id', $bookmarkId);
                        $bookmarkStart->setAttribute('w:name', $bookmarkName);

                        $bookmarkEnd = $domDocument->createElement('w:bookmarkEnd');
                        $bookmarkEnd->setAttribute('w:id', CreateDocx::$bookmarksIds[$bookmarkName]);

                        unset(CreateDocx::$bookmarksIds[$bookmarkName]);

                        $parentParagraph->appendChild($bookmarkStart);
                        $parentParagraph->appendChild($bookmarkEnd);

                        break;
                    }
                }
            }
        }
    }

    /**
     * Adds date and hour to the Word document
     *
     * @access public
     * @param array $options style options to apply to the date
     * 'dateFormat (string) dd/MM/yyyy H:mm:ss (default value) One may define a
     * customised format like dd' of 'MMMM' of 'yyyy' at 'H:mm (resulting in 20 of December of 2012 at 9:30)
     * 'pStyle' (string) paragraph style to be used
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'hanging' 100, 200, ...
     * 'headingLevel' (int) the heading level, if any
     * 'italic' (bool)
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480...
     * 'pageBreakBefore' (bool)
     * 'position' (int) position value, positive value for raised and negative value for lowered
     * 'rtl' (bool) if true sets right to left text orientation
     * 'scaling' (int) scaling value, 100 is the default value
     * 'smallCaps' (bool) displays text in small capital letters
     * 'spacing' (int) character spacing, positive value for expanded and negative value for condensed
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'strikeThrough' (bool)
     * 'suppressAutoHyphens' (bool) suppress hyphenation
     * 'suppressLineNumbers' (bool) suppress line numbers
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     *  if there is a tab and the tabPositions array is not defined the standard tab position (default of 708) will be used
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'underlineColor' (ffffff, ff0000, ...)
     * 'vanish' (bool)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     *
     * Theme (Premium licenses):
     * 'theme' (array):
     *      'color' (string) accent1, accent2, accent3, accent4, accent5, accent6, dk1, dk2, folHlink, hlink, lt1, lt2...
     */
    public function addDateAndHour($options = array('dateFormat' => 'dd/MM/yyyy H:mm:ss'))
    {
        $options = self::setRTLOptions($options);
        if (!isset($options['dateFormat'])) {
            $options['dateFormat'] = 'dd/MM/yyyy H:mm:ss';
        }
        $date = new WordFragment();
        $date->addText('date', $options);
        $date = preg_replace('/__PHX=__[A-Z]+__/', '', $date);
        $dateRef = '<?xml version="1.0" encoding="UTF-8" ?>' . $date;
        $dateRef = str_replace('<w:p>', '<w:p xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">', $dateRef);
        $dateDOM = $this->xmlUtilities->generateDomDocument($dateRef);

        $pPrNodes = $dateDOM->getElementsByTagName('pPr');
        if ($pPrNodes->length > 0) {
            $pPrContent = $dateDOM->saveXML($pPrNodes->item(0));
        } else {
            $pPrContent = '';
        }
        $rPrNodes = $dateDOM->getElementsByTagName('rPr');
        if ($rPrNodes->length > 0) {
            $rPrContent = $dateDOM->saveXML($rPrNodes->item(0));
        } else {
            $rPrContent = '';
        }
        if ($pPrContent != '') {
            $pPrContent = str_replace('</w:pPr>', $rPrContent . '</w:pPr>', $pPrContent);
        } else {
            $pPrContent = '<w:pPr>' . $rPrContent . '</w:pPr>';
        }
        $runs = '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="begin" /></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:instrText xml:space="preserve">TIME \@ &quot;' . $options['dateFormat'] . '&quot;</w:instrText></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="separate" /></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:t>date</w:t></w:r>';
        $runs .= '<w:r>' . $rPrContent . '<w:fldChar w:fldCharType="end" /></w:r>';

        $date = '<w:p>' . $pPrContent . $runs . '</w:p>';

        PhpdocxLogger::logger('Add a date to word document.', 'info');

        $contentElement = (string)$date;

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a drop cap
     *
     * @access public
     * @param string $letter the letter to be used as drop cap
     * @param array $options options to apply to the drop cap @see addText
     *      Default values:
     *          position: -2
     *          fontSize: 92
     * @param array $optionsParagraph paragraph options to apply to the drop cap @see addText
     *      Default values:
     *          keepNext: true
     *          framePr: dropCap ('drop'), hAnchor ('text'), lines (3), vAnchor ('text'), wrap ('around')
     *          spacing: spacingBottom (0), lineSpacing (1498), spacingLineRule ('exact')
     *          vAlign: 'baseline'
     */
    public function addDropCap($letter, $options = array(), $optionsParagraph = array())
    {
        // default values
        if (!isset($options['position'])) {
            $options['position'] = -2;
        }
        if (!isset($options['fontSize'])) {
            $options['fontSize'] = 92;
        }
        if (!isset($optionsParagraph['keepNext'])) {
            $optionsParagraph['keepNext'] = true;
        }
        if (!isset($optionsParagraph['framePr'])) {
            $optionsParagraph['framePr'] = array();
        }
        $framePrDefaults = array(
            'dropCap' => 'drop',
            'hAnchor' => 'text',
            'lines' => 3,
            'vAnchor' => 'text',
            'wrap' => 'around'
        );
        foreach ($framePrDefaults as $framePrDefaultKey => $framePrDefaultValue) {
            if (!isset($optionsParagraph['framePr'][$framePrDefaultKey])) {
                $optionsParagraph['framePr'][$framePrDefaultKey] = $framePrDefaultValue;
            }
        }
        if (!isset($optionsParagraph['spacingBottom'])) {
            $optionsParagraph['spacingBottom'] = 0;
        }
        if (!isset($optionsParagraph['lineSpacing'])) {
            $optionsParagraph['lineSpacing'] = 1498;
        }
        if (!isset($optionsParagraph['spacingLineRule'])) {
            $optionsParagraph['spacingLineRule'] = 'exact';
        }
        if (!isset($optionsParagraph['vAlign'])) {
            $optionsParagraph['vAlign'] =  'baseline';
        }

        $options['text'] = $letter;

        $this->addText(array($options), $optionsParagraph);
    }

    /**
     * Adds an endnote
     *
     * @access public
     * @param array $options
     * Values:
     * 'textDocument'(mixed) a string of text or WordFragment to appear in the document body or an array with the text and associated text options or a WordFragment
     * 'textEndnote' (mixed) a string of text to be used as the endnote text or a WordFragment
     * 'textEndnotes' (array) multiple endnotes
     * 'endnoteMark' (array) bidi, customMark, font, fontSize, bold, italic, color, rtl, highlightColor, underline, backgroundColor
     * 'referenceMark' (array) bidi, font, fontSize, bold, italic, color, rtl, highlightColor, underline, backgroundColor
     * 'pStyle' (string) paragraph style to be used
     * 'rStyle' (string) character style to be used
     */
    public function addEndnote($options = array())
    {
        // default values
        if (!isset($options['endnoteMark'])) {
            $options['endnoteMark'] = null;
        }
        if (!isset($options['referenceMark'])) {
            $options['referenceMark'] = null;
        }
        $endnotePStyle = 'endnoteTextPHPDOCX';
        $endnoteRStyle = 'endnoteReferencePHPDOCX';
        if (isset($options['pStyle'])) {
            $endnotePStyle = $options['pStyle'];
        }
        if (isset($options['rStyle'])) {
            $endnoteRStyle = $options['rStyle'];
        }

        $options['endnoteMark'] = self::translateTextOptions2StandardFormat($options['endnoteMark']);
        $options['endnoteMark'] = self::setRTLOptions($options['endnoteMark']);
        $options['referenceMark'] = self::translateTextOptions2StandardFormat($options['referenceMark']);
        $options['referenceMark'] = self::setRTLOptions($options['referenceMark']);

        // if there's no textEndnotes a single endnote will be added
        if (!isset($options['textEndnotes'])) {
            $options['textEndnotes'] = array();
            $options['textEndnotes'][0]['textEndnote'] = $options['textEndnote'];
            if (isset($options['endnoteMark'])) {
                $options['textEndnotes'][0]['endnoteMark'] = $options['endnoteMark'];
            }
            if (isset($options['referenceMark'])) {
                $options['textEndnotes'][0]['referenceMark'] = $options['referenceMark'];
            }
        }

        $endnoteDocument = new WordFragment();
        if (count($options['textEndnotes']) > 0) {
            if (!is_array($options['textDocument'])) {
                $options['textDocument'] = array('text' => $options['textDocument']);
            }
            $textOptions = $options['textDocument'];
            $textOptions = self::setRTLOptions($textOptions);
            $text = $textOptions['text'];
            if (isset($options['textDocument']['text']) && $options['textDocument']['text'] instanceof WordFragment) {
                $endnoteDocument->addText(array('text' => $text), $textOptions);
            } else {
                $endnoteDocument->addText($text, $textOptions);
            }
            foreach ($options['textEndnotes'] as $textEndnotes) {
                $id = ++self::$elementsNotesId['endnotes'];
                if (!isset($textEndnotes['endnoteMark'])) {
                    $textEndnotes['endnoteMark'] = null;
                }
                if (!isset($textEndnotes['referenceMark'])) {
                    $textEndnotes['referenceMark'] = null;
                }

                $textEndnotes['endnoteMark'] = self::translateTextOptions2StandardFormat($textEndnotes['endnoteMark']);
                $textEndnotes['endnoteMark'] = self::setRTLOptions($textEndnotes['endnoteMark']);
                $textEndnotes['referenceMark'] = self::translateTextOptions2StandardFormat($textEndnotes['referenceMark']);
                $textEndnotes['referenceMark'] = self::setRTLOptions($textEndnotes['referenceMark']);
                if ($textEndnotes['textEndnote'] instanceof WordFragment) {
                    $endnoteBase = '<w:endnote w:id="' . $id . '"
                        xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                        xmlns:o="urn:schemas-microsoft-com:office:office"
                        xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                        xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                        xmlns:v="urn:schemas-microsoft-com:vml"
                        xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                        xmlns:w10="urn:schemas-microsoft-com:office:word"
                        xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                        xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                        >';
                    $endnoteBase .= $this->parseWordMLNote('endnote', $textEndnotes['textEndnote'], $textEndnotes['endnoteMark'], $textEndnotes['referenceMark']);
                    $endnoteBase = preg_replace('/__PHX=__[A-Z]+__/', '', $endnoteBase);
                    $endnoteBase .= '</w:endnote>';
                } else {
                    $endnoteBase = '<w:endnote w:id="' . $id . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:p><w:pPr><w:pStyle w:val="'.$endnotePStyle.'"/>';
                    if (self::$bidi) {
                        $endnoteBase .= '<w:bidi />';
                    }
                    $endnoteBase .= '</w:pPr>';
                    $endnoteBase .= '<w:r><w:rPr><w:rStyle w:val="'.$endnoteRStyle.'"/>';

                    //Parse the referenceMark options
                    if (isset($textEndnotes['referenceMark']['font'])) {
                        $endnoteBase .= '<w:rFonts w:ascii="' . $textEndnotes['referenceMark']['font'] .
                                '" w:hAnsi="' . $textEndnotes['referenceMark']['font'] .
                                '" w:eastAsia="' . $textEndnotes['referenceMark']['font'] .
                                '" w:cs="' . $textEndnotes['referenceMark']['font'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['b'])) {
                        $endnoteBase .= '<w:b w:val="' . $textEndnotes['referenceMark']['b'] . '"/>';
                        $endnoteBase .= '<w:bCs w:val="' . $textEndnotes['referenceMark']['b'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['i'])) {
                        $endnoteBase .= '<w:i w:val="' . $textEndnotes['referenceMark']['i'] . '"/>';
                        $endnoteBase .= '<w:iCs w:val="' . $textEndnotes['referenceMark']['i'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['color'])) {
                        $endnoteBase .= '<w:color w:val="' . $textEndnotes['referenceMark']['color'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['backgroundColor'])) {
                        $endnoteBase .= '<w:shd w:val="clear" w:fill="' . $textEndnotes['referenceMark']['backgroundColor'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['highlightColor'])) {
                        $endnoteBase .= '<w:highlight w:val="' . $textEndnotes['referenceMark']['highlightColor'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['u'])) {
                        $endnoteBase .= '<w:u w:val="' . $textEndnotes['referenceMark']['u'] . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['sz'])) {
                        $endnoteBase .= '<w:sz w:val="' . (2 * $textEndnotes['referenceMark']['sz']) . '"/>';
                        $endnoteBase .= '<w:szCs w:val="' . (2 * $textEndnotes['referenceMark']['sz']) . '"/>';
                    }
                    if (isset($textEndnotes['referenceMark']['rtl']) && $textEndnotes['referenceMark']['rtl']) {
                        $endnoteBase .= '<w:rtl />';
                    }
                    $endnoteBase .= '</w:rPr>';
                    if (isset($textEndnotes['endnoteMark']['customMark'])) {
                        $endnoteBase .= '<w:t>' . $textEndnotes['endnoteMark']['customMark'] . '</w:t>';
                    } else {
                        $endnoteBase .= '<w:endnoteRef/>';
                    }
                    $endnoteBase .= '</w:r>';
                    $endnoteBase .= '<w:r>';
                    if (isset($textEndnotes['endnoteMark']['font']) ||
                        isset($textEndnotes['endnoteMark']['b']) ||
                        isset($textEndnotes['endnoteMark']['i']) ||
                        isset($textEndnotes['endnoteMark']['color']) ||
                        isset($textEndnotes['endnoteMark']['backgroundColor']) ||
                        isset($textEndnotes['endnoteMark']['highlightColor']) ||
                        isset($textEndnotes['endnoteMark']['u']) ||
                        isset($textEndnotes['endnoteMark']['sz']) ||
                        isset($textEndnotes['endnoteMark']['rtl']) && $textEndnotes['endnoteMark']['rtl']) {
                        $endnoteBase .= '<w:rPr>';

                        // parse the endnoteMark options
                        if (isset($textEndnotes['endnoteMark']['font'])) {
                            $endnoteBase .= '<w:rFonts w:ascii="' . $textEndnotes['endnoteMark']['font'] .
                                    '" w:hAnsi="' . $textEndnotes['endnoteMark']['font'] .
                                    '" w:eastAsia="' . $textEndnotes['endnoteMark']['font'] .
                                    '" w:cs="' . $textEndnotes['endnoteMark']['font'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['b'])) {
                            $endnoteBase .= '<w:b w:val="' . $textEndnotes['endnoteMark']['b'] . '"/>';
                            $endnoteBase .= '<w:bCs w:val="' . $textEndnotes['endnoteMark']['b'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['i'])) {
                            $endnoteBase .= '<w:i w:val="' . $textEndnotes['endnoteMark']['i'] . '"/>';
                            $endnoteBase .= '<w:iCs w:val="' . $textEndnotes['endnoteMark']['i'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['color'])) {
                            $endnoteBase .= '<w:color w:val="' . $textEndnotes['endnoteMark']['color'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['backgroundColor'])) {
                            $endnoteBase .= '<w:shd w:val="clear" w:fill="' . $textEndnotes['endnoteMark']['backgroundColor'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['highlightColor'])) {
                            $endnoteBase .= '<w:highlight w:val="' . $textEndnotes['endnoteMark']['highlightColor'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['u'])) {
                            $endnoteBase .= '<w:u w:val="' . $textEndnotes['endnoteMark']['u'] . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['sz'])) {
                            $endnoteBase .= '<w:sz w:val="' . (2 * $textEndnotes['endnoteMark']['sz']) . '"/>';
                            $endnoteBase .= '<w:szCs w:val="' . (2 * $textEndnotes['endnoteMark']['sz']) . '"/>';
                        }
                        if (isset($textEndnotes['endnoteMark']['rtl']) && $textEndnotes['endnoteMark']['rtl']) {
                            $endnoteBase .= '<w:rtl />';
                        }

                        $endnoteBase .= '</w:rPr>';
                    }

                    $endnoteBase .= '<w:t xml:space="preserve">' . $this->parseAndCleanTextString($textEndnotes['textEndnote']) . '</w:t></w:r>';
                    $endnoteBase .= '</w:p></w:endnote>';
                }
                $endnoteMark = '<w:r><w:rPr><w:rStyle w:val="'.$endnoteRStyle.'" />';
                //Parse the endnoteMark options
                if (isset($textEndnotes['endnoteMark']['font'])) {
                    $endnoteMark .= '<w:rFonts w:ascii="' . $textEndnotes['endnoteMark']['font'] .
                            '" w:hAnsi="' . $textEndnotes['endnoteMark']['font'] .
                            '" w:eastAsia="' . $textEndnotes['endnoteMark']['font'] .
                            '" w:cs="' . $textEndnotes['endnoteMark']['font'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['b'])) {
                    $endnoteMark .= '<w:b w:val="' . $textEndnotes['endnoteMark']['b'] . '"/>';
                    $endnoteMark .= '<w:bCs w:val="' . $textEndnotes['endnoteMark']['b'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['i'])) {
                    $endnoteMark .= '<w:i w:val="' . $textEndnotes['endnoteMark']['i'] . '"/>';
                    $endnoteMark .= '<w:iCs w:val="' . $textEndnotes['endnoteMark']['i'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['color'])) {
                    $endnoteMark .= '<w:color w:val="' . $textEndnotes['endnoteMark']['color'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['backgroundColor'])) {
                    $endnoteMark .= '<w:shd w:val="clear" w:fill="' . $textEndnotes['endnoteMark']['backgroundColor'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['highlightColor'])) {
                    $endnoteMark .= '<w:highlight w:val="' . $textEndnotes['endnoteMark']['highlightColor'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['u'])) {
                    $endnoteMark .= '<w:u w:val="' . $textEndnotes['endnoteMark']['u'] . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['sz'])) {
                    $endnoteMark .= '<w:sz w:val="' . (2 * $textEndnotes['endnoteMark']['sz']) . '"/>';
                    $endnoteMark .= '<w:szCs w:val="' . (2 * $textEndnotes['endnoteMark']['sz']) . '"/>';
                }
                if (isset($textEndnotes['endnoteMark']['rtl']) && $textEndnotes['endnoteMark']['rtl']) {
                    $endnoteMark .= '<w:rtl />';
                }
                $endnoteMark .= '</w:rPr><w:endnoteReference w:id="' . $id . '" ';
                if (isset($textEndnotes['endnoteMark']['customMark'])) {
                    $endnoteMark .= 'w:customMarkFollows="1"/><w:t>' . $textEndnotes['endnoteMark']['customMark'] . '</w:t>';
                } else {
                    $endnoteMark .= '/>';
                }
                $endnoteMark .= '</w:r></w:p>';
                $endnoteDocument = str_replace('</w:p>', $endnoteMark, $endnoteDocument);
                //Clean the endnoteDocument from auxilairy variable
                $endnoteDocument = preg_replace('/__PHX=__[A-Z]+__/', '', $endnoteDocument);

                $tempNode = $this->_wordEndnotesT->createDocumentFragment();
                $tempNode->appendXML($endnoteBase);
                $this->_wordEndnotesT->documentElement->appendChild($tempNode);
            }
        }

        PhpdocxLogger::logger('Add endnote to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $endnoteDocument;
        } else {
            $this->_wordDocumentC .= (string) $endnoteDocument;
        }
    }

    /**
     * Adds a footer
     *
     * @access public
     * @param array $footers
     *  Values:
     * 'default'(object) WordFragment
     * 'even' (object) WordFragment
     * 'first' (object) WordFragment
     * @throws \Exception not using WordFragments
     */
    public function addFooter($footers)
    {
        $this->removeFooters();
        foreach ($footers as $key => $value) {
            if ($value instanceof WordFragment) {
                $this->_wordFooterT[$key] = sprintf(OOXMLResources::$footersXML, (string)$value);
                $this->_wordFooterT[$key] = preg_replace('/__PHX=__[A-Z]+__/', '', $this->_wordFooterT[$key]);
                // first insert image rels
                // then insert external images rels
                // then insert link rels
                $relationships = '';
                if (isset(CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value2['rId'] . '.' . $value2['extension'] . '" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'])) {
                    foreach (CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                // create the complete rels file relative to that footer
                if ($relationships != '') {
                    $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
                    $rels .= $relationships;
                    $rels .= '</Relationships>';
                }
                // include the footer xml files
                $this->saveToZip($this->_wordFooterT[$key], 'word/' . $key . 'Footer.xml');
                // include the footer rels files
                if (isset($rels)) {
                    $this->saveToZip($rels, 'word/_rels/' . $key . 'Footer.xml.rels');
                }
                // modify the document.xml.rels file
                $newId = uniqid((string)mt_rand(999, 9999));
                $newFooterNode = '<Relationship Id="rId';
                $newFooterNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer"';
                $newFooterNode .= ' Target="' . $key . 'Footer.xml" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newFooterNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);
                // modify accordingly the sectPr node
                $newSectNode = '<w:footerReference w:type="' . $key . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);
                if ($key == 'first') {
                    $this->generateTitlePg(false);
                } else if ($key == 'even') {
                    $this->generateSetting('w:evenAndOddHeaders');
                }
                // generate the corresponding Override element in [Content_Types].xml
                $this->generateOVERRIDE(
                        '/word/' . $key . 'Footer.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.' .
                        'footer+xml'
                );
                // refresh the _relsFooter array
                $this->_relsFooter[] = $key . 'Footer.xml';
                // refresh the arrays used to hold the image and link data
                CreateDocx::$_relsHeaderFooterImage[$key . 'Footer'] = array();
                CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Footer'] = array();
                CreateDocx::$_relsHeaderFooterLink[$key . 'Footer'] = array();
            } else {
                PhpdocxLogger::logger('The footer contents must be WordFragments', 'fatal');
            }
        }
    }

    /**
     * Adds a footnote
     *
     * @access public
     * @param array $options
     *  Values:
     * 'textDocument'(mixed) a string of text or WordFragment to appear in the document body or an array with the text and associated text options or a WordFragment
     * 'textFootnote' (mixed) a string of text to be used as the footnote text or a WordFragment
     * 'textFootnotes' (array) multiple footnotes
     * 'footnoteMark' (array) bidi, customMark, font, fontSize, bold, italic, color, rtl, highlightColor, underline, backgroundColor
     * 'referenceMark' (array) bidi, font, fontSize, bold, italic, color, rtl, highlightColor, underline, backgroundColor
     * 'pStyle' (string) paragraph style to be used
     * 'rStyle' (string) character style to be used
     */
    public function addFootnote($options = array())
    {
        // default values
        if (!isset($options['footnoteMark'])) {
            $options['footnoteMark'] = null;
        }
        if (!isset($options['referenceMark'])) {
            $options['referenceMark'] = null;
        }
        $footnotePStyle = 'footnoteTextPHPDOCX';
        $footnoteRStyle = 'footnoteReferencePHPDOCX';
        if (isset($options['pStyle'])) {
            $footnotePStyle = $options['pStyle'];
        }
        if (isset($options['rStyle'])) {
            $footnoteRStyle = $options['rStyle'];
        }

        $options['footnoteMark'] = self::translateTextOptions2StandardFormat($options['footnoteMark']);
        $options['footnoteMark'] = self::setRTLOptions($options['footnoteMark']);
        $options['referenceMark'] = self::translateTextOptions2StandardFormat($options['referenceMark']);
        $options['referenceMark'] = self::setRTLOptions($options['referenceMark']);

        // if there's no textFootnotes a single footnote will be added
        if (!isset($options['textFootnotes'])) {
            $options['textFootnotes'] = array();
            $options['textFootnotes'][0]['textFootnote'] = $options['textFootnote'];
            if (isset($options['footnoteMark'])) {
                $options['textFootnotes'][0]['footnoteMark'] = $options['footnoteMark'];
            }
            if (isset($options['referenceMark'])) {
                $options['textFootnotes'][0]['referenceMark'] = $options['referenceMark'];
            }
        }

        $footnoteDocument = new WordFragment();
        if (count($options['textFootnotes']) > 0) {
            if (!is_array($options['textDocument'])) {
                $options['textDocument'] = array('text' => $options['textDocument']);
            }
            $textOptions = $options['textDocument'];
            $textOptions = self::setRTLOptions($textOptions);
            $text = $textOptions['text'];
            if (isset($options['textDocument']['text']) && $options['textDocument']['text'] instanceof WordFragment) {
                $footnoteDocument->addText(array('text' => $text), $textOptions);
            } else {
                $footnoteDocument->addText($text, $textOptions);
            }
            foreach ($options['textFootnotes'] as $textFootnotes) {
                $id = ++self::$elementsNotesId['footnotes'];
                if (!isset($textFootnotes['footnoteMark'])) {
                    $textFootnotes['footnoteMark'] = null;
                }
                if (!isset($textFootnotes['referenceMark'])) {
                    $textFootnotes['referenceMark'] = null;
                }

                $textFootnotes['footnoteMark'] = self::translateTextOptions2StandardFormat($textFootnotes['footnoteMark']);
                $textFootnotes['footnoteMark'] = self::setRTLOptions($textFootnotes['footnoteMark']);
                $textFootnotes['referenceMark'] = self::translateTextOptions2StandardFormat($textFootnotes['referenceMark']);
                $textFootnotes['referenceMark'] = self::setRTLOptions($textFootnotes['referenceMark']);

                if ($textFootnotes['textFootnote'] instanceof WordFragment) {
                    $footnoteBase = '<w:footnote w:id="' . $id . '"
                        xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                        xmlns:o="urn:schemas-microsoft-com:office:office"
                        xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                        xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                        xmlns:v="urn:schemas-microsoft-com:vml"
                        xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                        xmlns:w10="urn:schemas-microsoft-com:office:word"
                        xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                        xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"
                        >';
                    $footnoteBase .= $this->parseWordMLNote('footnote', $textFootnotes['textFootnote'], $textFootnotes['footnoteMark'], $textFootnotes['referenceMark']);
                    $footnoteBase = preg_replace('/__PHX=__[A-Z]+__/', '', $footnoteBase);
                    $footnoteBase .= '</w:footnote>';
                } else {
                    $footnoteBase = '<w:footnote w:id="' . $id . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:p><w:pPr><w:pStyle w:val="'.$footnotePStyle.'"/>';
                    if (self::$bidi) {
                        $footnoteBase .= '<w:bidi />';
                    }
                    $footnoteBase .= '</w:pPr>';
                    $footnoteBase .= '<w:r><w:rPr><w:rStyle w:val="'.$footnoteRStyle.'"/>';
                    // parse the referenceMark options
                    if (isset($textFootnotes['referenceMark']['font'])) {
                        $footnoteBase .= '<w:rFonts w:ascii="' . $textFootnotes['referenceMark']['font'] .
                                '" w:hAnsi="' . $textFootnotes['referenceMark']['font'] .
                                '" w:eastAsia="' . $textFootnotes['referenceMark']['font'] .
                                '" w:cs="' . $textFootnotes['referenceMark']['font'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['b'])) {
                        $footnoteBase .= '<w:b w:val="' . $textFootnotes['referenceMark']['b'] . '"/>';
                        $footnoteBase .= '<w:bCs w:val="' . $textFootnotes['referenceMark']['b'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['i'])) {
                        $footnoteBase .= '<w:i w:val="' . $textFootnotes['referenceMark']['i'] . '"/>';
                        $footnoteBase .= '<w:iCs w:val="' . $textFootnotes['referenceMark']['i'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['color'])) {
                        $footnoteBase .= '<w:color w:val="' . $textFootnotes['referenceMark']['color'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['backgroundColor'])) {
                        $footnoteBase .= '<w:shd w:val="clear" w:fill="' . $textFootnotes['referenceMark']['backgroundColor'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['highlightColor'])) {
                        $footnoteBase .= '<w:highlight w:val="' . $textFootnotes['referenceMark']['highlightColor'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['u'])) {
                        $footnoteBase .= '<w:u w:val="' . $textFootnotes['referenceMark']['u'] . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['sz'])) {
                        $footnoteBase .= '<w:sz w:val="' . (2 * $textFootnotes['referenceMark']['sz']) . '"/>';
                        $footnoteBase .= '<w:szCs w:val="' . (2 * $textFootnotes['referenceMark']['sz']) . '"/>';
                    }
                    if (isset($textFootnotes['referenceMark']['rtl']) && $textFootnotes['referenceMark']['rtl']) {
                        $footnoteBase .= '<w:rtl />';
                    }
                    $footnoteBase .= '</w:rPr>';
                    if (isset($textFootnotes['footnoteMark']['customMark'])) {
                        $footnoteBase .= '<w:t>' . $textFootnotes['footnoteMark']['customMark'] . '</w:t>';
                    } else {
                        $footnoteBase .= '<w:footnoteRef/>';
                    }
                    $footnoteBase .= '</w:r>';
                    $footnoteBase .= '<w:r>';
                    if (isset($textFootnotes['footnoteMark']['font']) ||
                        isset($textFootnotes['footnoteMark']['b']) ||
                        isset($textFootnotes['footnoteMark']['i']) ||
                        isset($textFootnotes['footnoteMark']['color']) ||
                        isset($textFootnotes['footnoteMark']['sz']) ||
                        isset($textFootnotes['footnoteMark']['rtl']) && $textFootnotes['footnoteMark']['rtl']) {
                        $footnoteBase .= '<w:rPr>';

                        // parse the footnoteMark options
                        if (isset($textFootnotes['footnoteMark']['font'])) {
                            $footnoteBase .= '<w:rFonts w:ascii="' . $textFootnotes['footnoteMark']['font'] .
                                    '" w:hAnsi="' . $textFootnotes['footnoteMark']['font'] .
                                    '" w:eastAsia="' . $textFootnotes['footnoteMark']['font'] .
                                    '" w:cs="' . $textFootnotes['footnoteMark']['font'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['b'])) {
                            $footnoteBase .= '<w:b w:val="' . $textFootnotes['footnoteMark']['b'] . '"/>';
                            $footnoteBase .= '<w:bCs w:val="' . $textFootnotes['footnoteMark']['b'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['i'])) {
                            $footnoteBase .= '<w:i w:val="' . $textFootnotes['footnoteMark']['i'] . '"/>';
                            $footnoteBase .= '<w:iCs w:val="' . $textFootnotes['footnoteMark']['i'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['color'])) {
                            $footnoteBase .= '<w:color w:val="' . $textFootnotes['footnoteMark']['color'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['backgroundColor'])) {
                            $footnoteBase .= '<w:shd w:val="clear" w:fill="' . $textFootnotes['footnoteMark']['backgroundColor'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['highlightColor'])) {
                            $footnoteBase .= '<w:highlight w:val="' . $textFootnotes['footnoteMark']['highlightColor'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['u'])) {
                            $footnoteBase .= '<w:u w:val="' . $textFootnotes['footnoteMark']['u'] . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['sz'])) {
                            $footnoteBase .= '<w:sz w:val="' . (2 * $textFootnotes['footnoteMark']['sz']) . '"/>';
                            $footnoteBase .= '<w:szCs w:val="' . (2 * $textFootnotes['footnoteMark']['sz']) . '"/>';
                        }
                        if (isset($textFootnotes['footnoteMark']['rtl']) && $textFootnotes['footnoteMark']['rtl']) {
                            $footnoteBase .= '<w:rtl />';
                        }

                        $footnoteBase .= '</w:rPr>';
                    }

                    $footnoteBase .= '<w:t xml:space="preserve">' . $this->parseAndCleanTextString($textFootnotes['textFootnote']) . '</w:t></w:r>';
                    $footnoteBase .= '</w:p></w:footnote>';
                }
                $footnoteMark = '<w:r><w:rPr><w:rStyle w:val="'.$footnoteRStyle.'" />';
                // parse the footnoteMark options
                if (isset($textFootnotes['footnoteMark']['font'])) {
                    $footnoteMark .= '<w:rFonts w:ascii="' . $textFootnotes['footnoteMark']['font'] .
                            '" w:hAnsi="' . $textFootnotes['footnoteMark']['font'] .
                            '" w:eastAsia="' . $textFootnotes['footnoteMark']['font'] .
                            '" w:cs="' . $textFootnotes['footnoteMark']['font'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['b'])) {
                    $footnoteMark .= '<w:b w:val="' . $textFootnotes['footnoteMark']['b'] . '"/>';
                    $footnoteMark .= '<w:bCs w:val="' . $textFootnotes['footnoteMark']['b'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['i'])) {
                    $footnoteMark .= '<w:i w:val="' . $textFootnotes['footnoteMark']['i'] . '"/>';
                    $footnoteMark .= '<w:iCs w:val="' . $textFootnotes['footnoteMark']['i'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['color'])) {
                    $footnoteMark .= '<w:color w:val="' . $textFootnotes['footnoteMark']['color'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['backgroundColor'])) {
                    $footnoteMark .= '<w:shd w:val="clear" w:fill="' . $textFootnotes['footnoteMark']['backgroundColor'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['highlightColor'])) {
                    $footnoteMark .= '<w:highlight w:val="' . $textFootnotes['footnoteMark']['highlightColor'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['u'])) {
                    $footnoteMark .= '<w:u w:val="' . $textFootnotes['footnoteMark']['u'] . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['sz'])) {
                    $footnoteMark .= '<w:sz w:val="' . (2 * $textFootnotes['footnoteMark']['sz']) . '"/>';
                    $footnoteMark .= '<w:szCs w:val="' . (2 * $textFootnotes['footnoteMark']['sz']) . '"/>';
                }
                if (isset($textFootnotes['footnoteMark']['rtl']) && $textFootnotes['footnoteMark']['rtl']) {
                    $footnoteMark .= '<w:rtl />';
                }
                $footnoteMark .= '</w:rPr><w:footnoteReference w:id="' . $id . '" ';
                if (isset($textFootnotes['footnoteMark']['customMark'])) {
                    $footnoteMark .= 'w:customMarkFollows="1"/><w:t>' . $textFootnotes['footnoteMark']['customMark'] . '</w:t>';
                } else {
                    $footnoteMark .= '/>';
                }
                $footnoteMark .= '</w:r></w:p>';
                $footnoteDocument = str_replace('</w:p>', $footnoteMark, $footnoteDocument);
                // clean the footnoteDocument from auxilairy variable
                $footnoteDocument = preg_replace('/__PHX=__[A-Z]+__/', '', $footnoteDocument);

                $tempNode = $this->_wordFootnotesT->createDocumentFragment();
                $tempNode->appendXML($footnoteBase);
                $this->_wordFootnotesT->documentElement->appendChild($tempNode);
            }
        }

        PhpdocxLogger::logger('Add footnote to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $footnoteDocument;
        } else {
            $this->_wordDocumentC .= (string) $footnoteDocument;
        }
    }

    /**
     * Adds a Form element (text field, select or checkbox)
     *
     * @access public
     * @param mixed $type it can be 'textfield', 'checkbox' or 'select'
     * @param array $options Style options to apply to the text
     *  Values:
     * 'pStyle' (string) paragraph style to be used
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'hanging' 100, 200, ...
     * 'headingLevel' (int) the heading level, if any
     * 'italic' (bool)
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480...
     * 'pageBreakBefore' (bool)
     * 'rtl' (bool) if true sets right to left text orientation
     * 'smallCaps' (bool) displays text in small capital letters
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'suppressAutoHyphens' (bool) suppress hyphenation
     * 'suppressLineNumbers' (bool) suppress line numbers
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     *  if there is a tab and the tabPositions array is not defined the standard tab position (default of 708) will be used
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'defaultValue' (mixed) a string of text for the textfield type,
     * a boolean value for the checkbox type or an integer representing the index (0 based)
     * for the options of a select form element
     * 'selectOptions' (array) an array of options for the dropdown menu
     *
     * Theme (Premium licenses):
     * 'theme' (array):
     *      'color' (string) accent1, accent2, accent3, accent4, accent5, accent6, dk1, dk2, folHlink, hlink, lt1, lt2...
     * @throws \Exception form element type not available
     */
    public function addFormElement($type, $options = array())
    {
        $options = self::setRTLOptions($options);
        $formElementTypes = array('textfield', 'checkbox', 'select');
        if (!in_array($type, $formElementTypes)) {
            PhpdocxLogger::logger('The chosen form element type is not available', 'fatal');
        }
        $formElementBase = CreateText::getInstance();
        $paragraphOptions = $options;
        $formElementBase = new WordFragment();
        $formElementBase->addText(array(array('text' => '__PHX=__formElement__')), $paragraphOptions);
        $formElement = CreateFormElement::getInstance();
        $formElement->createFormElement($type, $options, (string) $formElementBase);

        $contentElement = (string)$formElement;

        PhpdocxLogger::logger('Add form element to Word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a header
     *
     * @access public
     * @param array $headers
     *  Values:
     * 'default'(object) WordFragment
     * 'even' (object) WordFragment
     * 'first' (object) WordFragment
     * @throws \Exception not using WordFragments
     */
    public function addHeader($headers)
    {
        $this->removeHeaders();
        foreach ($headers as $key => $value) {
            if ($value instanceof WordFragment) {
                $this->_wordHeaderT[$key] = sprintf(OOXMLResources::$headersXML, (string)$value);
                $this->_wordHeaderT[$key] = preg_replace('/__PHX=__[A-Z]+__/', '', $this->_wordHeaderT[$key]);
                // first insert image Rels
                // then insert external images rels
                // then insert Link rels
                $relationships = '';
                if (isset(CreateDocx::$_relsHeaderFooterImage[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterImage[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value2['rId'] . '.' . $value2['extension'] . '" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                if (isset(CreateDocx::$_relsHeaderFooterLink[$key . 'Header'])) {
                    foreach (CreateDocx::$_relsHeaderFooterLink[$key . 'Header'] as $key2 => $value2) {
                        $relationships .= '<Relationship Id="' . $value2['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value2['url'] . '" TargetMode="External" />';
                    }
                }
                // create the complete rels file relative to that header
                if ($relationships != '') {
                    $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
                    $rels .= $relationships;
                    $rels .= '</Relationships>';
                }
                // include the header xml files
                $this->saveToZip($this->_wordHeaderT[$key], 'word/' . $key . 'Header.xml');
                // include the header rels files
                if (isset($rels)) {
                    $this->saveToZip($rels, 'word/_rels/' . $key . 'Header.xml.rels');
                }
                // modify the document.xml.rels file
                $newId = uniqid((string)mt_rand(999, 9999));
                $newHeaderNode = '<Relationship Id="rId';
                $newHeaderNode .= $newId . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/header"';
                $newHeaderNode .= ' Target="' . $key . 'Header.xml" />';
                $newNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
                $newNode->appendXML($newHeaderNode);
                $baseNode = $this->_wordRelsDocumentRelsT->documentElement;
                $baseNode->appendChild($newNode);
                // modify accordingly the sectPr node
                $newSectNode = '<w:headerReference w:type="' . $key . '" r:id="rId' . $newId . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->childNodes->item(0);
                $refNode->parentNode->insertBefore($sectNode, $refNode);
                if ($key == 'first') {
                    $this->generateTitlePg(false);
                } else if ($key == 'even') {
                    $this->generateSetting('w:evenAndOddHeaders');
                }
                // generate the corresponding Override element in [Content_Types].xml
                $this->generateOVERRIDE(
                        '/word/' . $key . 'Header.xml', 'application/vnd.openxmlformats-officedocument.wordprocessingml.' .
                        'header+xml'
                );
                // refresh the _relsHeader array
                $this->_relsHeader[] = $key . 'Header.xml';
                // refresh the arrays used to hold the image and link data
                CreateDocx::$_relsHeaderFooterImage[$key . 'Header'] = array();
                CreateDocx::$_relsHeaderFooterExternalImage[$key . 'Header'] = array();
                CreateDocx::$_relsHeaderFooterLink[$key . 'Header'] = array();
            } else {
                PhpdocxLogger::logger('The header contents must be WordFragments', 'fatal');
            }
        }
    }

    /**
     * Adds a heading to the Word document
     *
     * @access public
     * @param string $text the heading text
     * @param int $level can be 1 (default), 2, 3, ...
     * @param array $options Style options to apply to the heading
     *  Values:
     * 'pStyle' (string) paragraph style to be used
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'emboss' (bool) emboss style
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'framePr' (array)
     *      'anchorLock' (bool)
     *      'dropCap' (string) drop, margin, none
     *      'h' (int) twips
     *      'hAnchor' (string) margin, page, text
     *      'hRule' (string) atLeast, auto, exact
     *      'hSpace'  (int) twips
     *      'lines' (int)
     *      'vAnchor' (string) margin, page, text
     *      'vSpace' (int) twips
     *      'wrap' (string)
     *      'w' (int) twips
     *      'wrap' (string) around, auto, none, notBeside, through, tight
     *      'x' (int) twips
     *      'xAlign' (string) center, inside, left, outside, right
     *      'y' (int) twips
     *      'yAlign' (string) bottom, center, inline, inside, outside, top
     * 'hanging' 100, 200, ...
     * 'headingLevel' (int) the heading level, if any
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'italic' (bool)
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480...
     * 'noProof' (bool) ignore spelling and grammar errors
     * 'outline' (bool) outline style
     * 'pageBreakBefore' (bool)
     * 'position' (int) position value, positive value for raised and negative value for lowered
     * 'rtl' (bool) if true sets right to left text orientation
     * 'scaling' (int) scaling value, 100 is the default value
     * 'shadow' (bool) shadow style
     * 'smallCaps' (bool) displays text in small capital letters
     * 'spacing' (int) character spacing, positive value for expanded and negative value for condensed
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'strikeThrough' (bool)
     * 'suppressAutoHyphens' (bool) suppress hyphenation
     * 'suppressLineNumbers' (bool) suppress line numbers
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     *  if there is a tab and the tabPositions array is not defined the standard tab position (default of 708) will be used
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'underlineColor' (ffffff, ff0000, ...)
     * 'vanish' (bool)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     */
    public function addHeading($text, $level = 1, $options = array())
    {
        $options = self::translateTextOptions2StandardFormat($options);
        $options = self::setRTLOptions($options);

        if (!isset($options['b'])) {
            $options['b'] = 'on';
        }
        if (!isset($options['keepLines'])) {
            $options['keepLines'] = 'on';
        }
        if (!isset($options['keepNext'])) {
            $options['keepNext'] = 'on';
        }
        if (!isset($options['widowControl'])) {
            $options['widowControl'] = 'on';
        }
        if (!isset($options['sz'])) {
            $options['sz'] = max(15 - $level, 10);
        }
        if (!isset($options['font'])) {
            $options['font'] = 'Cambria';
        }

        $options['headingLevel'] = $level;
        $heading = CreateText::getInstance();
        $heading->createText($text, $options);

        $contentElement = (string)$heading;

        PhpdocxLogger::logger('Adds a heading of level ' . $level . 'to the Word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds an image
     *
     * @access public
     * @param array $data
     * Values:
     * 'src' (string) path to the image, stream, base64 or resource
     * 'borderColor' (string)
     * 'borderStyle'(string) can be solid, dot, dash, lgDash, dashDot, lgDashDot, lgDashDotDot, sysDash, sysDot, sysDashDot, sysDashDotDot
     * 'borderWidth' (int) given in emus (1cm = 360000 emus)
     * 'caption' (array) keys:
     *     'align' (string): text align
     *     'bookmarkName' (string): set a custom bookmark name
     *     'color' (string): text color. HEX value
     *     'fontSize' (int): text size in half-points
     *     'keepNext' (bool) keep in the same page the current paragraph with next paragraph. Default as false
     *     'label' (string): set a custom label (Figure by default)
     *     'lineSpacing' (int): text line spacing
     *     'position' (string) below (default), above
     *     'pStyle' (string): set a custom style name applied to the paragraph. This option overwrites the 'styleName' option as custom paragraph style
     *     'showLabel' (bool): show default value (Figure)
     *     'styleName' (string): allow setting a custom style name, useful to generate table of figures based on style names
     *     'text' (string): text of the caption
     *     'wrapTextInBookmarks' (bool): wrap text content between bookmarks. Default as true
     * 'float' (left, right, center) floating image. It only applies if textWrap is not inline (default value).
     * 'horizontalOffset' (int) given in emus (1cm = 360000 emus). Only applies if there is the image is not floating
     * 'imageAlign' (center, left, right, inside, outside)
     * 'descr' (string) set a descr value
     * 'distance' (array) top, right, bottom and left given in emus. Not available using inline textWrap. Spacing options can be used to set spacings in all cases. Default as 0
     * 'dpi' (int) dots per inch
     * 'height' (int) in pixels
     * 'hyperlink' (string)
     * 'mime' (string) forces a mime (image/jpg, image/jpeg, image/png, image/gif, image/bmp, image/webp)
     * 'relativeToHorizontal' (string) margin (default), page, column, character, leftMargin, rightMargin, insideMargin, outsideMargin. Not compatible with inline text wrapping
     * 'relativeToVertical' (string) margin, page, line (default), paragraph, topMargin, bottomMargin, insideMargin, outsideMargin. Not compatible with inline text wrapping
     * 'resourceMode' (bool) if true, uses src as image resource. The image resource is transformed to PNG automatically. Default as false
     * 'scaling' (int) a pecentage: 50, 100, ...
     * 'spacingTop' (int) in pixels
     * 'spacingBottom' (int) in pixels
     * 'spacingLeft' (int) in pixels
     * 'spacingRight' (int) in pixels
     * 'streamMode' (bool) if true, uses src as stream. PHP 5.4 or greater needed to autodetect the mime type; otherwise set it using mime option. Default as false
     * 'textWrap' 0 (inline), 1 (square), 2 (front), 3 (back), 4 (up and bottom)
     * 'verticalAlign' (string) top, center, bottom. To be used with relativeFromVertical
     * 'verticalOffset' (int) given in emus (1cm = 360000 emus)
     * 'width' (int) in pixels
     * @throws \Exception image does not exist, image format is not supported, getimagesizefromstring not available using streamMode and mime/height/width values are not set
     */
    public function addImage($data = array())
    {
        if (isset($data['width'])) {
            $data['sizeX'] = $data['width'];
        }
        if (isset($data['height'])) {
            $data['sizeY'] = $data['height'];
        }
        if (get_class($this) != 'Phpdocx\Create\CreateDocx' && isset($this->target)) {
            $data['target'] = $this->target;
        } else {
            $data['target'] = 'document';
        }
        if (isset($data['caption']) && !isset($data['caption']['position'])) {
            $data['caption']['position'] = 'below';
        }

        $mimeType = '';
        $dir = array();
        $isBase64 = false;
        $isResourceMode = false;
        $imageContent = '';

        // file image
        if (isset($data['src']) && (!isset($data['streamMode']) || !$data['streamMode']) && (!isset($data['resourceMode']) || !$data['resourceMode'])) {
            if ($data['src'] && strstr($data['src'], 'base64,')) {
                // check if base64
                $descrArray = explode(';base64,', $data['src']);
                $arrayExtension = explode('/', $descrArray[0]);
                $dir['extension'] = $arrayExtension[1];
                $arrayMime = explode(':', $descrArray[0]);
                $mimeType = $arrayMime[1];
                $imageContent = base64_decode($descrArray[1]);
                $isBase64 = true;
            } else if (file_exists($data['src'])) {
                $attrImage = getimagesize($data['src']);
                $mimeType = $attrImage['mime'];

                $dir = $this->parsePath($data['src']);
            } else {
                PhpdocxLogger::logger('Image does not exist.', 'fatal');
            }
        }

        // stream image
        if (isset($data['streamMode']) && $data['streamMode']) {
            if (function_exists('getimagesizefromstring')) {
                $imageStream = file_get_contents($data['src']);
                $attrImage = getimagesizefromstring($imageStream);
                $mimeType = $attrImage['mime'];

                switch ($mimeType) {
                    case 'image/gif':
                        $dir['extension'] = 'gif';
                        break;
                    case 'image/jpg':
                        $dir['extension'] = 'jpg';
                        break;
                    case 'image/jpeg':
                        $dir['extension'] = 'jpeg';
                        break;
                    case 'image/png':
                        $dir['extension'] = 'png';
                        break;
                    case 'image/bmp':
                        $dir['extension'] = 'bmp';
                        break;
                    case 'image/webp':
                        $dir['extension'] = 'webp';
                        break;
                    default:
                        break;
                }
            } else {
                if (!isset($data['mime']) || !isset($data['height']) || !isset($data['width'])) {
                    PhpdocxLogger::logger('getimagesizefromstring function is not available. Set mime, width and height options or use the file mode.', 'fatal');
                }
                $imageStream = file_get_contents($data['src']);
                $attrImage = array(
                    $data['width'],
                    $data['height'],
                );
                $mimeType = $data['mime'];

                switch ($mimeType) {
                    case 'image/gif':
                        $dir['extension'] = 'gif';
                        break;
                    case 'image/jpg':
                        $dir['extension'] = 'jpg';
                        break;
                    case 'image/jpeg':
                        $dir['extension'] = 'jpeg';
                        break;
                    case 'image/png':
                        $dir['extension'] = 'png';
                        break;
                    case 'image/bmp':
                        $dir['extension'] = 'bmp';
                        break;
                    case 'image/webp':
                        $dir['extension'] = 'webp';
                        break;
                    default:
                        break;
                }
            }
        }

        // resource image
        if (isset($data['resourceMode']) && $data['resourceMode']) {
            if (function_exists('getimagesizefromstring')) {
                // transform to PNG
                $dir['extension'] = 'png';
                $mimeType = 'image/png';
                ob_start();
                imagepng($data['src']);
                $imageContent = ob_get_contents();
                ob_end_clean();
                $attrImage = getimagesizefromstring($imageContent);
                $data['resourceModeContent'] = $imageContent;

                $isResourceMode = true;
            } else {
                if (!isset($data['width']) || !isset($data['height'])) {
                    PhpdocxLogger::logger('getimagesizefromstring function is not available. Set width and height values.', 'fatal');
                }
                $dir['extension'] = 'png';
                $mimeType = 'image/png';
                ob_start();
                imagepng($data['src']);
                $imageContent = ob_get_contents();
                ob_end_clean();
                $attrImage = array(
                    $data['width'],
                    $data['height'],
                );
                $data['resourceModeContent'] = $imageContent;

                $isResourceMode = true;
            }
        }

        if (isset($data['mime']) && !empty($data['mime'])) {
            $mimeType = $data['mime'];
        }

        // check mime type
        if (!in_array($mimeType, array('image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'))) {
            PhpdocxLogger::logger('Image format is not supported.', 'fatal');
        }

        PhpdocxLogger::logger('Create image.', 'debug');
        try {
            self::$intIdWord++;
            PhpdocxLogger::logger('New ID rId' . self::$intIdWord . ' . Image.', 'debug');

            // generate hyperlink rId
            if (isset($data['hyperlink'])) {
                $data['hyperlink'] = $this->parseAndCleanTextString($data['hyperlink']);
                $data['rIdHyperlink'] = self::$intIdWord . 'link';
            }
            $image = CreateImage::getInstance();
            $data['rId'] = self::$intIdWord;
            $image->createImage($data);

            PhpdocxLogger::logger('Add image word/media/imgrId' .
                    self::$intIdWord . '.' . $dir['extension'] .
                    '.xml to DOCX.', 'info');
            if ($isBase64 || $isResourceMode) {
                $this->_zipDocx->addContent('word/media/imgrId' . self::$intIdWord . '.' . $dir['extension'], $imageContent);
            } else {
                $this->_zipDocx->addFile('word/media/imgrId' . self::$intIdWord . '.' . $dir['extension'], $data['src']);
            }
            $this->generateDEFAULT($dir['extension'], $mimeType);
            if ((string) $image != '') {
                // consider the case where the image will be included in a header or footer
                if ($data['target'] == 'defaultHeader' ||
                        $data['target'] == 'firstHeader' ||
                        $data['target'] == 'evenHeader' ||
                        $data['target'] == 'defaultFooter' ||
                        $data['target'] == 'firstFooter' ||
                        $data['target'] == 'evenFooter') {
                    CreateDocx::$_relsHeaderFooterImage[$data['target']][] = array('rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']);
                    if (isset($data['hyperlink'])) {
                        if (strpos($data['hyperlink'], '#') === 0) {
                            // bookmark
                            CreateDocx::$_relsHeaderFooterLink[$data['target']][] = array('rId' => 'rId' . $data['rIdHyperlink'], 'url' => $data['hyperlink']);
                        } else {
                            // external hyperlink
                            CreateDocx::$_relsHeaderFooterLink[$data['target']][] = array('rId' => 'rId' . $data['rIdHyperlink'], 'url' => $data['hyperlink'], 'TargetMode' => 'External');
                        }
                    }
                } else if ($data['target'] == 'footnote' ||
                        $data['target'] == 'endnote' ||
                        $data['target'] == 'comment') {
                    CreateDocx::$_relsNotesImage[$data['target']][] = array('rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']);
                    if (isset($data['hyperlink'])) {
                        if (strpos($data['hyperlink'], '#') === 0) {
                            // bookmark
                            CreateDocx::$_relsNotesLink[$data['target']][] = array('rId' => 'rId' . $data['rIdHyperlink'], 'url' => $data['hyperlink']);
                        } else {
                            // external hyperlink
                            CreateDocx::$_relsNotesLink[$data['target']][] = array('rId' => 'rId' . $data['rIdHyperlink'], 'url' => $data['hyperlink'], 'TargetMode' => 'External');
                        }
                    }
                } else {
                    $this->generateRELATIONSHIP(
                            'rId' . self::$intIdWord, 'image', 'media/imgrId' . self::$intIdWord . '.'
                            . $dir['extension']
                    );
                    if (isset($data['hyperlink'])) {
                        if (strpos($data['hyperlink'], '#') === 0) {
                            // bookmark
                            $this->generateRELATIONSHIP('rId' . $data['rIdHyperlink'], 'hyperlink', $data['hyperlink']);
                        } else {
                            // external hyperlink
                            $this->generateRELATIONSHIP('rId' . $data['rIdHyperlink'], 'hyperlink', $data['hyperlink'], 'TargetMode="External"');
                        }
                    }
                }
            }

            $contentElement = (string)$image;

            if ($this instanceof WordFragment) {
                if (isset($data['caption']) && $data['caption']['position'] == 'above') {
                    // above position
                    if (!isset($data['caption']['label'])) {
                        $data['caption']['label'] = 'Figure';
                    }
                    if (!isset($data['imageAlign'])) {
                        $data['imageAlign'] = 'left';
                    }
                    $data['caption']['align'] = ($data['imageAlign']) ? $data['imageAlign'] : 'left';
                    $this->addImageCaption(true, $data['caption']);
                }
                $this->wordML .= $contentElement;
                if (isset($data['caption']) && $data['caption']['position'] == 'below') {
                    // below position
                    if (!isset($data['caption']['label'])) {
                        $data['caption']['label'] = 'Figure';
                    }
                    if (!isset($data['imageAlign'])) {
                        $data['imageAlign'] = 'left';
                    }
                    $data['caption']['align'] = ($data['imageAlign']) ? $data['imageAlign'] : 'left';
                    $this->addImageCaption(true, $data['caption']);
                }
            } else {
                if (isset($data['caption']) && $data['caption']['position'] == 'above') {
                    // below position
                    if (!isset($data['caption']['label'])) {
                        $data['caption']['label'] = 'Figure';
                    }
                    if (!isset($data['imageAlign'])) {
                        $data['imageAlign'] = 'left';
                    }
                    $data['caption']['align'] = ($data['imageAlign']) ? $data['imageAlign'] : 'left';
                    $this->addImageCaption(false, $data['caption']);
                }
                $this->_wordDocumentC .= $contentElement;
                if (isset($data['caption']) && $data['caption']['position'] == 'below') {
                    // below position
                    if (!isset($data['caption']['label'])) {
                        $data['caption']['label'] = 'Figure';
                    }
                    if (!isset($data['imageAlign'])) {
                        $data['imageAlign'] = 'left';
                    }
                    $data['caption']['align'] = ($data['imageAlign']) ? $data['imageAlign'] : 'left';
                    $this->addImageCaption(false, $data['caption']);
                }
            }
        } catch (\Exception $e) {
            PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }
    }

    /**
     * Adds line numbering
     *
     * @access public
     * @param array $options
     * countBy (int) line number increments to display (default value is 1)
     * start (int) initial line number (default value is 0)
     * distance (int) separation in twentieths of a point between the number and the text (defaults to auto)
     * restart (string) could be:
     *      continuous (default value: the numbering does not get restarted anywhere in the document),
     *      newPage (the numbering restarts at the beginning of every page)
     *      newSection (the numbering restarts at the beginning of every section)
     * sectionNumbers (array) if empty it will apply to all sections
     */
    public function addLineNumbering($options = array())
    {
        // restart condition available types
        $restart_types = array('continuous', 'newPage', 'newSection');
        $lineNumberOptions = array();
        // set defaults
        if (isset($options['countBy']) && is_int($options['countBy'])) {
            $lineNumberOptions['countBy'] = $options['countBy'];
        } else {
            $lineNumberOptions['countBy'] = 1;
        }
        if (isset($options['start']) && is_int($options['start'])) {
            $lineNumberOptions['start'] = $options['start'];
        } else {
            $lineNumberOptions['start'] = 0;
        }
        if (isset($options['distance']) && is_int($options['distance'])) {
            $lineNumberOptions['distance'] = $options['distance'];
        }
        if (isset($options['restart']) && in_array($options['restart'], $restart_types)) {
            $lineNumberOptions['restart'] = $options['restart'];
        } else {
            $lineNumberOptions['restart'] = 'continuous';
        }
        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = null;
        }
        // get the current sectPr nodes
        $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        // modify them
        foreach ($sectPrNodes as $sectionNode) {
            $this->modifySingleSectionProperty($sectionNode, 'lnNumType', $lineNumberOptions);
        }
        $this->restoreDocumentXML();
    }

    /**
     * Adds a link
     *
     * @access public
     * @param array $options
     * @see addText
     * additional parameters:
     * 'url' (string) URL or #bookmarkName
     * 'rStyle' (string) apply a custom rStyle to links
     * @throws \Exception linked text or url are missing
     */
    public function addLink($text, $options = array())
    {
        if (!isset($options['color'])) {
            $options['color'] = '0000ff';
        }
        if (!isset($options['u']) && !isset($options['underline'])) {
            $options['underline'] = 'single';
        }
        $options = self::setRTLOptions($options);
        $options['url'] = $this->parseAndCleanTextString($options['url']);
        if (substr($options['url'], 0, 1) == '#') {
            $url = 'HYPERLINK \l "' . substr($options['url'], 1) . '"';
        } else {
            $url = 'HYPERLINK "' . $options['url'] . '"';
        }
        if ($text == '') {
            PhpdocxLogger::logger('The linked text is missing', 'fatal');
        } else if ($options['url'] == '') {
            PhpdocxLogger::logger('The URL is missing', 'fatal');
        }

        // create an array to apply a rStyle
        if (!isset($options['rStyle']) || empty($options['rStyle'])) {
            $options['rStyle'] = 'DefaultParagraphFontPHPDOCX';
        }
        $text = array(
            array(
                'text' => $text,
            )
        );
        $text[0] += $options;
        // avoid adding rStyle to w:pPr, as it's not needed
        unset($options['rStyle']);

        $textOptions = $options;
        $link = new WordFragment();
        $link->addText($text, $textOptions);
        $link = preg_replace('/__PHX=__[A-Z]+__/', '', $link);
        $startNodes = '<w:r><w:fldChar w:fldCharType="begin" /></w:r><w:r>
        <w:instrText xml:space="preserve">' . $url . '</w:instrText>
        </w:r><w:r><w:fldChar w:fldCharType="separate" /></w:r>';
        if (strstr($link, '</w:pPr>')) {
            $link = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $startNodes, $link);
        } else {
            $link = preg_replace('/<w:p>/', '<w:p>' . $startNodes, $link);
        }
        $endNode = '<w:r><w:fldChar w:fldCharType="end" /></w:r>';
        $link = preg_replace('/<\/w:p>/', $endNode . '</w:p>', $link);

        $contentElement = (string)$link;

        PhpdocxLogger::logger('Add link to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a list
     *
     * @access public
     * @param array $data Values of the list
     * @param mixed $styleType (mixed), 0 (clear), 1 (inordinate), 2 (numerical) or the name of the created list
     * @param array $options formatting parameters for the text of all list items
     *  Values:
     * 'bold' (bool)
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000, ...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'highlightColor' (string) available highlighting colors are: black, blue, cyan, green, magenta, red, yellow, white, darkBlue, darkCyan, darkGreen, darkMagenta, darkRed, darkYellow, darkGray, lightGray, none.
     * 'italic' (bool)
     * 'numId' (positive int) useful to generate a continuous numbering
     * 'outlineLvl' (int) heading level
     * 'pStyle' (string) paragraph style name
     * 'smallCaps' (bool) displays text in small capital letters
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'useWordFragmentStyles' (bool) use WordFragment paragraph styles. Default as false
     */
    public function addList($data, $styleType = 1, $options = array())
    {
        $options['val'] = (int) $styleType;
        $list = CreateList::getInstance();

        if ($options['val'] == 2) {
            self::$numOL = self::uniqueNumberId(999, 32000);
            $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, OOXMLResources::$orderedListStyle, self::$numOL);
        }
        if (is_string($styleType)) {
            $options['val'] = self::$customLists[$styleType]['id'];
        }
        $list->createList($data, $options);

        $contentElement = (string)$list;

        PhpdocxLogger::logger('Add list to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds page borders
     *
     * @access public
     * @param array $options (<side> stands for top, right, bottom or left)
     * 'zOrder' (int)
     * 'display' (string) posible values are:allPages (display page border on all pages, default value),
     *  firstPage(display page border on first page), notFirstPage (display page border on all pages except first)
     * 'offsetFrom' (string) posible values are: page or text
     * 'borderStyle' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *       this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * sectionNumbers (array)
     */
    public function addPageBorders($options = array())
    {
        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = null;
        }

        $options = CreateDocx::translateTableOptions2StandardFormat($options);

        //Get the current sectPr nodes
        $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        //Modify them
        foreach ($sectPrNodes as $sectionNode) {
            $this->modifyPageBordersSectionProperty($sectionNode, $options);
        }
        $this->restoreDocumentXML();
    }

    /**
     * Adds a page number to the document
     * WARNING: if the page number is not added to a header or footer the user may
     * need to press F9 in the MS Word interface to update its value to the current page
     *
     * @access public
     * @param mixed $type (String): numerical, alphabetical, page-of
     * @param array $options Style options to apply to the numbering
     * Numerical and alphabetical
     *  Values:
     * 'bidi' (bool)
     * 'bold' (bool)
     * 'color' (ffffff, ff0000...)
     * 'font' (Arial, Times New Roman...)
     * 'fontSize' (int) size in half-points
     * 'italic' (bool)
     * 'indentLeft' (int) distange in twentieths of a point (twips)
     * 'indentRight' (int) distange in twentieths of a point (twips)
     * 'pageBreakBefore' (bool)
     * 'textAlign' (both, center, distribute, left, right)
     * 'underline' (dash, dotted, double, single, wave, words)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     * 'lineSpacing' 120, 240 (standard), 480, ...
     * 'defaultValue' (int)
     * Page-of
     *  Values:
     * 'pStyle' pStyle name (Footer as default)
     * 'textAlign' center (default), left, right
     */
    public function addPageNumber($type = 'numerical', $options = array('defaultValue' => 1))
    {
        $options = self::setRTLOptions($options);
        if (!isset($options['defaultValue'])) {
            if ($type == 'numerical') {
                $options['defaultValue'] = '1';
            } else if ($type == 'alphabetical') {
                $options['defaultValue'] = 'a';
            }
        }

        if ($type == 'page-of') {
            // page-of number
            if (!isset($options['pStyle'])) {
                $options['pStyle'] = 'Footer';
            }
            if (!isset($options['textAlign'])) {
                $options['textAlign'] = 'center';
            }
            $pageNumber = OOXMLResources::$pageNumber;
            $pageNumber = str_replace(
                array('__ID__PAGENUMBER__SDTPR__', '__ID__PAGENUMBER__SDTCONTENT__', '__PSTYLE__PAGENUMBER__PPR__', '__JC__PAGENUMBER__PPR__'),
                array(rand(100000000, 999999999), rand(100000000, 999999999), $options['pStyle'], $options['textAlign']),
                $pageNumber
            );

        } else {
            // numerical and alphabetical number
            $pageNumber = new WordFragment();
            $pageNumber->addText($options['defaultValue'], $options);

            if ($type == 'alphabetical') {
                $beguin = '<w:fldSimple w:instr="PAGE \* alphabetic \* MERGEFORMAT">';
            } else {
                $beguin = '<w:fldSimple w:instr="PAGE \* MERGEFORMAT">';
            }
            $end = '</w:fldSimple>';
            $pageNumber = str_replace('<w:r>', $beguin . '<w:r>', (string) $pageNumber);
            $pageNumber = str_replace('</w:r>', '</w:r>' . $end, (string) $pageNumber);
        }
        PhpdocxLogger::logger('Add page number to word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $pageNumber;
        } else {
            $this->_wordDocumentC .= (string) $pageNumber;
        }
    }

    /**
     * Adds properties to document
     *
     * @access public
     * @param array $values Parameters to use
     *  Values: 'title', 'subject', 'creator', 'keywords', 'description', 'created' (W3CDTF without time zone), 'modified' (W3CDTF without time zone), lastModifiedBy,
     *  'category', 'contentStatus', 'Manager','Company', 'custom' ('name' => array('type' => 'value')), 'revision'
     */
    public function addProperties($values)
    {
        $this->_modifiedDocxProperties = true;
        if (is_null($this->propsCore)) {
            $this->propsCore = $this->getFromZip('docProps/core.xml', 'DOMDocument');
        }
        if (is_null($this->propsApp)) {
            $this->propsApp = $this->getFromZip('docProps/app.xml', 'DOMDocument');
        }
        if (is_null($this->propsCustom)) {
            $this->propsCustom = $this->getFromZip('docProps/custom.xml', 'DOMDocument');
        }
        if ($this->propsCustom === false) {
            $this->generateCustomRels = true;
            $this->propsCustom = $this->xmlUtilities->generateDomDocument(OOXMLResources::$customProperties);
            // write the new Override node associated to the new custon.xml file en [Content_Types].xml
            $this->generateOVERRIDE(
                    '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.' .
                    'custom-properties+xml'
            );
            $this->saveToZip($this->propsCustom, 'docProps/custom.xml');
        }
        if (is_null($this->relsRels)) {
            $this->relsRels = $this->getFromZip('_rels/.rels', 'DOMDocument');
        }

        $prop = CreateProperties::getInstance();
        if (!empty($values['title']) || !empty($values['subject']) || !empty($values['creator']) || !empty($values['keywords']) || !empty($values['description']) || !empty($values['category']) || !empty($values['contentStatus']) || !empty($values['created']) || !empty($values['modified']) || !empty($values['lastModifiedBy']) || !empty($values['revision']) ) {
            $this->propsCore = $prop->createProperties($values, $this->propsCore);
        }
        if (isset($values['contentStatus']) && $values['contentStatus'] == 'Final') {
            $this->propsCustom = $prop->createPropertiesCustom(array('_MarkAsFinal' => array('boolean' => 'true')), $this->propsCustom);
        }
        if (!empty($values['Manager']) || !empty($values['Company'])) {
            $this->propsApp = $prop->createPropertiesApp($values, $this->propsApp);
        }
        if (!empty($values['custom']) && is_array($values['custom'])) {
            $this->propsCustom = $prop->createPropertiesCustom($values['custom'], $this->propsCustom);
            // write the new Override node associated to the new custon.xml file en [Content_Types].xml
            $this->generateOVERRIDE(
                    '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.' .
                    'custom-properties+xml'
            );
        }
        if ($this->generateCustomRels) {
            $this->generateCUSTOMRELS();
            $this->generateCustomRels = false;
        }
        PhpdocxLogger::logger('Adding properties to word document.', 'info');
    }

    /**
     * Adds a ruby (phonetic guide) content
     *
     * @param array $ruby
     *      'rt' (string) phonetic guide text
     *      'rubyBase' (array) phonetic guide base text @see addText
     * @param array $options
     *      'rubyAlign' (string) center, distributeLetter, distributeSpace (default), left, right, rightVertical
     *      'hps' (int) phonetic guide text font size. Size in half-points. Default as 11
     *      'hpsBaseText' (int) phonetic guide base text font size. Size in half-points. Default as 22
     *      'hpsRaise' (int) distance between phonetic guide text and phonetic guide base text. Size in half-points. Default as 20
     *      'lid' (string) language ID for phonetic guide. Default as 'en-US'
     *      paragraph styles @see addText
     */
    public function addRuby($ruby, $options = array())
    {
        $options = self::setRTLOptions($options);
        // default options
        if (!isset($options['rubyAlign'])) {
            $options['rubyAlign'] = 'distributeSpace';
        }
        if (!isset($options['hps'])) {
            $options['hps'] = 11;
        }
        if (!isset($options['hpsRaise'])) {
            $options['hpsRaise'] = 20;
        }
        if (!isset($options['hpsBaseText'])) {
            $options['hpsBaseText'] = 22;
        }
        if (!isset($options['lid'])) {
            $options['lid'] = 'en-US';
        }

        $rtText = new WordFragment();
        $rtText->addText($ruby['rt'], $options);

        $rubyBaseText = new WordFragment();
        $rubyBaseOptions = $ruby['rubyBase'];
        unset($rubyBaseOptions['text']);
        $rubyBaseText->addText(array($ruby['rubyBase']), array_merge($rubyBaseOptions, $options));

        $textStyles = new WordFragment();
        $textStyles->addText('ruby', $options);

        $rubyContents = CreateRuby::getInstance();
        $rubyContents->createRuby($rtText, $rubyBaseText, $options);

        $rubyContentsParagraph = '<?xml version="1.0" encoding="UTF-8" ?>' . str_replace('<w:p>', '<w:p xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">', (string)$textStyles);
        $rubyContentsDOM = $this->xmlUtilities->generateDomDocument($rubyContentsParagraph);

        $pPrNodes = $rubyContentsDOM->getElementsByTagName('pPr');
        $pPrContent = '';
        if ($pPrNodes->length > 0) {
            $pPrContent = $rubyContentsDOM->saveXML($pPrNodes->item(0));
        }
        $pPrContent = preg_replace('/__PHX=__[A-Z]+__/', '', $pPrContent);
        $rubyContents = preg_replace('/__PHX=__[A-Z]+__/', '', (string)$rubyContents);
        $ruby = '<w:p>' . $pPrContent . $rubyContents . '</w:p>';

        PhpdocxLogger::logger('Add a ruby to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $ruby;
        } else {
            $this->_wordDocumentC .= $ruby;
        }
    }

    /**
     * Adds a section
     *
     * @access public
     * @param string $sectionType (string): nextPage, nextColumn, continuous, evenPage, oddPage
     * @param string $paperType (string): A4, A3, letter, legal, A4-landscape, A3-landscape, letter-landscape, legal-landscape, custom
     * @param array $options
     * Values:
     * width (int) measurement in twips (twentieths of a point)
     * height (int) measurement in twips (twentieths of a point)
     * numberCols (int) number of columns
     * sepCols (bool) draw a line between columns. Default as false
     * orient (string) portrait, landscape
     * marginTop (int) measurement in twips (twentieths of a point)
     * marginRight (int) measurement in twips (twentieths of a point)
     * marginBottom (int) measurement in twips (twentieths of a point)
     * marginLeft (int) measurement in twips (twentieths of a point)
     * marginHeader (int) measurement in twips (twentieths of a point)
     * marginFooter (int) measurement in twips (twentieths of a point)
     * space (int) column spacing, measurement in twips (twentieths of a point)
     * gutter (int) measurement in twips (twentieths of a point)
     * vAlign (string) vertical alignment (top, center, both, bottom)
     * bidi (bool)
     * rtl (bool)
     * excludeHeadersAndFooters (bool): if true, exclude headers and footers reference tags. Default as false
     * pageNumberType (array) with the following keys and values (all keys are needed):
     *     fmt (string): number format (cardinalText, decimal, decimalEnclosedCircle, decimalEnclosedFullstop, decimalEnclosedParen, decimalZero, lowerLetter, lowerRoman, none, ordinalText, upperLetter, upperRoman)
     *     start (int): page number
     * columns (array) allows generating a page layout with custom column numbers and sizes with the following keys and values:
     *     width (int)
     *     space (int)
     * endnotes (array) sets endnote options with the following keys and values:
     *     numFmt (string) numbering format: decimal, upperRoman, lowerRoman, upperLetter...
     *     numRestart (string) continuous, eachSect, eachPage
     *     numStart (int) starting value
     *     pos (string) sectEnd, docEnd
     * footnotes (array) sets footnote options with the following keys and values:
     *     numFmt (string) numbering format: decimal, upperRoman, lowerRoman, upperLetter...
     *     numRestart (string) continuous, eachSect, eachPage
     *     numStart (int) starting value
     *     pos (string) pageBottom, beneathText
     */
    public function addSection($sectionType = 'nextPage', $paperType = '', $options = array())
    {
        $options = self::translateTextOptions2StandardFormat($options);
        $options = self::setRTLOptions($options);
        if (empty($paperType)) {
            $paperType = 'A4';
        }
        $previousSectionPr = '<w:p><w:pPr>' . $this->_sectPr->saveXML() . '</w:pPr></w:p>';
        $previousSectionPr = str_replace('<?xml version="1.0"?>', '', $previousSectionPr);

        $contentElement = (string)$previousSectionPr;

        $this->_wordDocumentC .= $contentElement;
        $options['onlyLastSection'] = true;
        $this->modifyPageLayout($paperType, $options);
        $nodeSz = $this->_sectPr->getElementsByTagName('pgSz')->item(0);

        // avoid setting w:type if the same exists
        $nodeType = $this->_sectPr->getElementsByTagName('type');
        $addType = true;
        if ($nodeType->length > 0) {
            if ($nodeType->item(0)->hasAttribute('w:val') && $nodeType->item(0)->getAttribute('w:val') == $sectionType) {
            } else {
                $nodeType->item(0)->setAttribute('w:val', $sectionType);
            }
            // w:type tag exists, do not add a new one
            $addType = false;
        }

        if ($addType) {
            $typeNode = $this->_sectPr->createDocumentFragment();
            $typeNode->appendXML('<w:type xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val="' . $sectionType . '" />');
            $nodeSz->parentNode->insertBefore($typeNode, $nodeSz);
        }

        if (isset($options['excludeHeadersAndFooters']) && $options['excludeHeadersAndFooters']) {
            $sectPrDom = $this->xmlUtilities->generateDomDocument($this->_sectPr->saveXML());
            $sectPrXPath = new \DOMXPath($sectPrDom);
            $sectPrXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            // remove the w:headerReference and w:footerReference elements
            $headerAndFooterReferencesQuery = '//w:headerReference | //w:footerReference';
            $headerAndFooterReferencesNodes = $sectPrXPath->query($headerAndFooterReferencesQuery);
            foreach ($headerAndFooterReferencesNodes as $headerAndFooterReferencesNode) {
                $headerAndFooterReferencesNode->parentNode->removeChild($headerAndFooterReferencesNode);
            }
            $this->_sectPr = $sectPrDom;
        }
    }

    /**
     * Adds a shape
     *
     * @access public
     * @param string $type Type of shape to draw: arc, curve, line, polyline, rect, roundrect, shape, oval, straightArrow, arrowLeft, arrowRight, customShape
     * @param array $options
     *      'fillcolor' (string) #ff0000, #00ffff,...
     *      'height' (int) in points
     *      'marginTop' (float)
     *      'marginLeft' (float)
     *      'position' (string) absolute
     *      'relativeToHorizontal' (string) margin, page, text, char
     *      'relativeToVertical' (string) margin, page, text, line
     *      'strokecolor' (string) #ff0000, #00ffff,...
     *      'strokeweight' (1.0pt, 3.5pt, ...)
     *      'width' (int) in points
     *      'z-index' (int)
     *      'textContent' it may be a WordFragment, a plain text string or an array with same parameters used in the addText method
     *          The first array entry is the text to be included in the text box, the second one is itself another array with all the standard text formatting options.
     *      'imageContent' file path to the image to be added
     * Options for especific type:
     *      arc: 'startAngle' (0, 45, 90, ...), 'endAngle' (0, 45, 90, ...)
     *      line and curve: 'from' and 'to' (initial and final points in x,y format)
     *      curve: 'control1' (x,y), 'control2' (x,y)
     *      polyline: 'points' (x1,y1 x2,y2 ...)
     *      roundrect: 'arcsize' (0.5, 1.8, ...)
     *      shape: 'path' (VML path), 'coordsize' (x,y)
     *      straightArrow, arrowLeft, arrowRight, customShape: 'extraShapeStyles' (string), 'opacity' (int) 0 to 100, 'rotation' (int)
     *      customShape: 'customShape' XML of the shape type
     * @throws \Exception image does not exist, image format is not supported
     */
    public function addShape($type, $options = array())
    {
        if (!empty($options['marginTop'])) {
            $options['margin-top'] = $options['marginTop'];
        }
        if (!empty($options['marginLeft'])) {
            $options['margin-left'] = $options['marginLeft'];
        }

        if (get_class($this) != 'Phpdocx\Create\CreateDocx' && isset($this->options)) {
            $options['target'] = $this->options;
        } else {
            $options['target'] = 'document';
        }

        if (isset($options['imageContent'])) {
            $mimeType = '';
            // file image
            if (file_exists($options['imageContent'])) {
                $attrImage = getimagesize($options['imageContent']);
                $mimeType = $attrImage['mime'];
                $dir = $this->parsePath($options['imageContent']);
            } else {
                PhpdocxLogger::logger('Image does not exist.', 'fatal');
            }
            // check mime type
            if (!in_array($mimeType, array('image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'))) {
                PhpdocxLogger::logger('Image format is not supported.', 'fatal');
            }

            self::$intIdWord++;
            $options['imageContentrId'] = self::$intIdWord;

            $this->_zipDocx->addFile('word/media/imgrId' . self::$intIdWord . '.' . $dir['extension'], $options['imageContent']);
            $this->generateDEFAULT($dir['extension'], $mimeType);
            // consider the case where the image will be included in a header or footer
            if ($options['target'] == 'defaultHeader' ||
                    $options['target'] == 'firstHeader' ||
                    $options['target'] == 'evenHeader' ||
                    $options['target'] == 'defaultFooter' ||
                    $options['target'] == 'firstFooter' ||
                    $options['target'] == 'evenFooter') {
                CreateDocx::$_relsHeaderFooterImage[$options['target']][] = array('rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']);
            } else if ($options['target'] == 'footnote' ||
                    $options['target'] == 'endnote' ||
                    $options['target'] == 'comment') {
                CreateDocx::$_relsNotesImage[$options['target']][] = array('rId' => 'rId' . self::$intIdWord, 'extension' => $dir['extension']);
            } else {
                $this->generateRELATIONSHIP(
                        'rId' . self::$intIdWord, 'image', 'media/imgrId' . self::$intIdWord . '.'
                        . $dir['extension']
                );
            }
        }

        $shape = new CreateShape();
        $shapeData = $shape->createShape($type, $options);

        $contentElement = '<w:r>' . (string)$shapeData . '</w:r>';

        PhpdocxLogger::logger('Add a ' . $type . 'to the Word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= '<w:p>' . $contentElement . '</w:p>';
        } else {
            $paragraphShape = '<w:p>' . $contentElement . '</w:p>';
            $this->_wordDocumentC .= $paragraphShape;
        }
    }

    /**
     * Adds a simple field to the Word document
     * WARNING: if the page number is not added to a header or footer the user may
     * need to press F9 in the MS Word interface to update its value to the current page
     *
     * @access public
     * @param $fieldName the field value. Available fields are:
     * AUTHOR, COMMENTS, DOCPROPERTY, FILENAME, FILESIZE, KEYWORDS,
     * LASTSAVEDBY, NUMCHARS, NUMPAGES, NUMWORDS, SUBJECT, TEMPLATE, TITLE
     * @param string $type: date, numeric or general.
     * @param string $format
     * @param array $options style options to apply to the field
     * Values:
     * 'defaultValue' (mixed)
     * 'doNotShadeFormData' (bool)
     * 'updateFields' (bool)
     * For the available options @see addText
     */
    public function addSimpleField($fieldName, $type = 'general', $format = '', $options = array())
    {
        $options = self::setRTLOptions($options);
        $availableTypes = array('date' => '\@', 'numeric' => '\#', 'general' => '\*');
        $fieldOptions = array();
        if (isset($options['doNotShadeFormData']) && $options['doNotShadeFormData']) {
            $fieldOptions['doNotShadeFormData'] = true;
        }
        if (isset($options['updateFields']) && $options['updateFields']) {
            $fieldOptions['updateFields'] = true;
        }
        if (count($fieldOptions) > 0) {
            $this->docxSettings($fieldOptions);
        }
        $simpleField = new WordFragment();
        $simpleField->addText($fieldName, $options);

        $data = $fieldName . ' ';
        if (!empty($format)) {
            $data .= $availableTypes[$type] . ' ' . $format . ' ';
        }
        $data .= '\* MERGEFORMAT';
        $beguin = '<w:fldSimple w:instr=" ' . $data . ' ">';

        $end = '</w:fldSimple>';
        $simpleField = str_replace('<w:r>', $beguin . '<w:r>', (string) $simpleField);
        $simpleField = str_replace('</w:r>', '</w:r>' . $end, (string) $simpleField);

        PhpdocxLogger::logger('Adding a simple field to the Word document.', 'info');
        // in order to preserve the run styles insert them within the <w:pPr> tag
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $simpleField;
        } else {
            $this->_wordDocumentC .= (string) $simpleField;
        }
    }

    /**
     * Adds a Structured Document Tag
     *
     * @access public
     * @param string $type checkbox, comboBox, date, dropDownList, richText, text, sdtContent
     * @param array $options Style options to apply to the text
     *  Values:
     * 'placeholderText' (string) text to be shown by default
     * 'alias' (string) the label that will be shown by the structured document tag
     * 'lock' (string) locking properties: sdtLocked (cannot be deleted), contentLocked (contents can not be edited directly), unlocked (default value: no locking) and sdtContentLocked (contents can not be directly edited or the structured tag removed)
     * 'tag' (string) a programmatic tag
     * 'temporary' (bool) if true the structured tag is removed after editing
     * 'listItems' (array) an array of arrays each one of them containing the text to show and value
     * 'checked' (bool)
     * 'checkedState', 'uncheckedState' (array)
     *      'font' (string) MS Gothic as default
     *      'value' (string) 2612 as default for checkedState. 2610 as default for uncheckedState
     * 'sym' (array) Custom symbol used with checkbox. Use with checkedState and uncheckedState options
     *      'font' (string)
     *      'char' (string)
     * 'calendar' (string) gregorian as default
     * 'dateFormat' (string) M/d/yyyy as default
     * 'local' (string) en-US as default
     * 'text' (string) richText and text types. Add text content without adding a placeholder
     * 'parseLineBreaks' (bool) richText and text types. If true parses the line breaks to include them in the Word document. Default as false
     * 'repeatingSection' (bool) sets as repeating section. Use with the sdtContent type. Compatible from MS Word 2013
     * 'repeatingSectionItem' (bool) sets as repeating section item. Use with the sdtContent type. Compatible from MS Word 2013
     * 'wordFragment' (WordFragment) richText and sdtContent types. Add WordFragment content without adding a placeholder
     * For other options @see addText
     * @throws \Exception structured document tag type is not available
     */
    public function addStructuredDocumentTag($type, $options = array())
    {
        $options = self::setRTLOptions($options);
        $sdtTypes = array('checkbox', 'comboBox', 'date', 'dropDownList', 'richText', 'text', 'sdtContent');
        if (!in_array($type, $sdtTypes)) {
            PhpdocxLogger::logger('The chosen Structured Document Tag type is not available', 'fatal');
        }
        $sdtBase = CreateText::getInstance();
        $paragraphOptions = $options;
        if ($type == 'checkbox') {
            if (isset($paragraphOptions['checked']) && $paragraphOptions['checked'] === true) {
                $paragraphOptions['text'] = '☒';
            } else {
                $paragraphOptions['text'] = '☐';
            }
        } else {
            if (isset($options['placeholderText'])) {
                $paragraphOptions['text'] = $options['placeholderText'];
            } else if (isset($options['text'])) {
                $paragraphOptions['text'] = $options['text'];
            }
        }
        $sdtBase->createText(array($paragraphOptions), $paragraphOptions);
        $sdt = CreateStructuredDocumentTag::getInstance();
        if (isset($options['wordFragment']) && $options['wordFragment'] instanceof WordFragment && ($type == 'richText' || $type == 'sdtContent')) {
            $sdtBase = $options['wordFragment'];
        }
        $sdtBase = (string) $sdtBase;

        if (isset($options['parseLineBreaks']) && $options['parseLineBreaks']) {
            $sdtBase = str_replace(array('\n\r', '\r\n', '\n', '\r', "\n\r", "\r\n", "\n", "\r"), '</w:t><w:br/><w:t xml:space="preserve">', $sdtBase);
        }

        $sdt->createStructuredDocumentTag($type, $options, $sdtBase);
        PhpdocxLogger::logger('Add Structured Document Tag to Word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $sdt;
        } else {
            $this->_wordDocumentC .= (string) $sdt;
        }
    }

    /**
     * Adds a tab
     *
     * @access public
     * @param array $options
     */
    public function addTab($options = array())
    {
        $contentElement = '<w:r><w:tab/></w:r>';

        PhpdocxLogger::logger('Adds a tab to the Word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= '<w:p>' . $contentElement . '</w:p>';
        } else {
            $this->_wordDocumentC .= '<w:p>' . $contentElement . '</w:p>';
        }
    }

    /**
     * Adds a table
     *
     * @access public
     * @param array $tableData an array of arrays with the table data organized by rows
     * Each cell content may be a string, WordFragment or array.
     * If the cell contents are in the form of an array its keys and posible values are:
     *      'value' (mixed) a string or WordFragment
     *      'rowspan' (int)
     *      'colspan' (int)
     *      'width' (int) in twentieths of a point
     *      'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *          this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     *      'borderColor' (ffffff, ff0000)
     *          this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     *      'borderSpacing' (0, 1, 2...)
     *          this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     *      'borderWidth' (10, 11...) in eights of a point
     *          this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     *      'backgroundColor' (ffffff, ff0000)
     *      'noWrap' (bool)
     *      'cellMargin' (mixed) an integer value or an array:
     *          'top' (int) in twentieths of a point
     *          'right' (int) in twentieths of a point
     *          'bottom' (int) in twentieths of a point
     *          'left' (int) in twentieths of a point
     *      'textDirection' (string) available values are: tbRl and btLr
     *      'fitText' (bool) if true fits the text to the size of the cell
     *      'vAlign' (string) vertical align of text: top, center, both or bottom
     * @param array $tableProperties Parameters to use
     *  Values:
     *  'bidi' (bool) set to true for right to left languages
     *  'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *  'borderColor' (ffffff, ff0000)
     *  'borderSpacing' (0, 1, 2...)
     *  'borderWidth' (10, 11...) in eights of a point
     *  'borderSettings' (all, outside, inside) if all (default value) the border styles apply to all table borders.
     *  If the value is set to outside or inside the border styles will only apply to the outside or inside borders respectively.
     *  'cantSplitRows' (bool) set global row split properties (can be overriden by rowProperties)
     *  'caption' (array) keys:
     *     'align' (string): text align
     *     'bookmarkName' (string): set a custom bookmark name
     *     'color' (string): text color. HEX value
     *     'fontSize' (int): text size in half-points
     *     'keepNext' (bool) keep in the same page the current paragraph with next paragraph. Default as false
     *     'label' (string): set a custom label (Table by default)
     *     'lineSpacing' (int): text line spacing
     *     'position' (string) below (default), above
     *     'pStyle' (string): set a custom style name applied to the paragraph. This option overwrites the 'styleName' option as custom paragraph style
     *     'showLabel' (bool): show default value (Table)
     *     'styleName' (string): allow setting a custom style name, useful to generate table of figures based on style names
     *     'text' (string): text of the caption
     *     'wrapTextInBookmarks' (bool): wrap text content between bookmarks. Default as true
     *  'cellMargin' (array) the keys are top, right, bottom and left and the values is given in twips (twentieths of a point)
     *  'cellSpacing' (int) given in twips (twentieths of a point)
     *  'columnWidths': column width fix (int)
     *              column width variable (array)
     *  'conditionalFormatting' (array) with the following keys and values:
     *      'firstRow' (bool) first table row conditional formatting
     *      'lastRow' (bool) last table row conditional formatting
     *      'firstCol' (bool) first table column conditional formatting
     *      'lastCol' (bool) last table column conditional formatting
     *      'noHBand' (bool) do not apply row banding conditional formatting
     *      'noVBand' (bool) do not apply column banding conditional formatting
     *  The default values are: firstRow (true), firstCol (true), noVBand (true) and all other false
     *  'descr' (string) set a description value
     *  'descrTitle' (string) set a title description value
     *  'float' (array) with the following keys and values:
     *      'align' (string) posible values are: left (default), center, right, outside, inside
     *      'textMarginTop' (int) in twentieths of a point
     *      'textMarginRight' (int) in twentieths of a point
     *      'textMarginBottom' (int) in twentieths of a point
     *      'textMarginLeft' (int) in twentieths of a point
     *      'horzAnchor' (string) margin (default), page, text
     *      'vertAnchor' (string) margin, page, text (default)
     *      'tblpXSpec' (string) center, inside, left, outside, right. Default as align value
     *      'tblpYSpec' (string) center, inside (default), bottom, outside, inline, top
     *  'font' (Arial, Times New Roman...)
     *  'indent' (int) given in twips (twentieths of a point)
     *  'tableAlign' (center, left, right)
     *  'tableLayout' (fixed, autofit) set to 'fixed' only if you do not want Word to handle the best possible width fit
     *  'tableStyle' (string) table style
     *  'tableWidth' (array) its posible keys and values are:
     *      'type' (pct, dxa) pct if the value refers to percentage and dxa if the value is given in twentieths of a point (twips)
     *      'value' (int)
     *  'textProperties' (array) it may include any of the paragraph properties of the addText method
     * @param array $rowProperties (array) each entry is an array with keys and values:
     *      'cantSplit' (bool)
     *      'minHeight' (int) in twentieths of a point
     *      'height' (int) in twentieths of a point
     *      'tableHeader' (bool) if true this row repeats at the beginning of each new page
     */
    public function addTable($tableData, $tableProperties = array(), $rowProperties = array())
    {
        // default values
        if (isset($tableProperties['caption']) && !isset($tableProperties['caption']['position'])) {
            $tableProperties['caption']['position'] = 'below';
        }
        if (isset($tableProperties['caption']) && !isset($tableProperties['caption']['align'])) {
            $tableProperties['caption']['align'] = 'left';
        }

        $tableProperties = CreateDocx::translateTableOptions2StandardFormat($tableProperties);
        $tableProperties = self::setRTLOptions($tableProperties);
        $table = CreateTable::getInstance();
        $table->createTable($tableData, $tableProperties, $rowProperties);

        $contentElement = (string)$table;

        PhpdocxLogger::logger('Add table to Word document.', 'info');

        if ($this instanceof WordFragment) {
            if (isset($tableProperties['caption']) && $tableProperties['caption']['position'] == 'above') {
                // above position
                if (!isset($tableProperties['caption']['label'])) {
                    $tableProperties['caption']['label'] = 'Table';
                }
                if (!isset($tableProperties['caption']['align'])) {
                    $tableProperties['caption']['align'] = 'left';
                }
                $tableProperties['caption']['align'] = ($tableProperties['caption']['align']) ? $tableProperties['caption']['align'] : 'left';
                $this->addImageCaption(true, $tableProperties['caption']);
            }
            $this->wordML .= $contentElement;
            if (isset($tableProperties['caption']) && $tableProperties['caption']['position'] == 'below') {
                // below position
                if (!isset($tableProperties['caption']['label'])) {
                    $tableProperties['caption']['label'] = 'Table';
                }
                if (!isset($tableProperties['caption']['align'])) {
                    $tableProperties['caption']['align'] = 'left';
                }
                $tableProperties['caption']['align'] = ($tableProperties['caption']['align']) ? $tableProperties['caption']['align'] : 'left';
                $this->addImageCaption(true, $tableProperties['caption']);
            }
        } else {
            if (isset($tableProperties['caption']) && $tableProperties['caption']['position'] == 'above') {
                // above position
                if (!isset($tableProperties['caption']['label'])) {
                    $tableProperties['caption']['label'] = 'Table';
                }
                if (!isset($tableProperties['caption']['align'])) {
                    $tableProperties['caption']['align'] = 'left';
                }
                $tableProperties['caption']['align'] = ($tableProperties['caption']['align']) ? $tableProperties['caption']['align'] : 'left';
                $this->addImageCaption(false, $tableProperties['caption']);
            }
            $this->_wordDocumentC .= $contentElement;
            if (isset($tableProperties['caption']) && $tableProperties['caption']['position'] == 'below') {
                // below position
                if (!isset($tableProperties['caption']['label'])) {
                    $tableProperties['caption']['label'] = 'Table';
                }
                if (!isset($tableProperties['caption']['align'])) {
                    $tableProperties['caption']['align'] = 'left';
                }
                $tableProperties['caption']['align'] = ($tableProperties['caption']['align']) ? $tableProperties['caption']['align'] : 'left';
                $this->addImageCaption(false, $tableProperties['caption']);
            }
        }
    }

    /**
     * Adds a table of contents
     *
     * @access public
     * @param array $options
     *  Values:
     * 'autoUpdate' (bool) if true it will try to update the TOC when first opened
     * 'displayLevels' (string) must be of the form '1-3' where the first number is
     * the start level an the second the end level. If not defined all existing levels are shown
     * @param array $legend for the available options @see addText
     * @param string $stylesTOC path to the docx with the required styles for the Table of Contents
     */
    public function addTableContents($options = array(), $legend = array(), $stylesTOC = '')
    {
        $legend = self::translateTextOptions2StandardFormat($legend);
        $legend = self::setRTLOptions($legend);
        if (!empty($stylesTOC)) {
            $this->importStyles($stylesTOC, 'merge', array('TDC1', 'TDC2', 'TDC3', 'TDC4', 'TDC5', 'TDC6', 'TDC7', 'TDC8', 'TDC9', 'TOC1', 'TOC2', 'TOC3', 'TOC4', 'TOC5', 'TOC6', 'TOC7', 'TOC8', 'TOC9'), 'styleID');
        }
        if (empty($legend['text'])) {
            $legend['text'] = 'Click here to update the Table of Contents';
        }
        $legendOptions = $legend;
        unset($legendOptions['text']);
        $legendData = new WordFragment();
        $legendData->addText(array($legend), $legendOptions);
        $tableContents = CreateTableContents::getInstance();
        $tableContents->createTableContents($options, $legendData);
        if (isset($options['autoUpdate']) && $options['autoUpdate']) {
            $this->generateSetting('w:updateFields');
        }
        PhpdocxLogger::logger('Add table of contents to word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $tableContents;
        } else {
            $this->_wordDocumentC .= (string) $tableContents;
        }
    }

    /**
     * Adds a table of figures
     *
     * @access public
     * @param array $options
     *  Values:
     * 'autoUpdate' (bool) if true it will try to update the content when first opened
     * 'scope' (string) contents to display: Table (default), Figure and other custom values based on the content style ID
     * 'style' (string) custom paragraph style to be applied
     * @param array $legend for the available options @see addText
     */
    public function addTableFigures($options = array(), $legend = array())
    {
        if (!isset($options['scope'])) {
            $options['scope'] = 'Table';
        }
        $legend = self::translateTextOptions2StandardFormat($legend);
        $legend = self::setRTLOptions($legend);
        if (!isset($legend['text']) || empty($legend['text'])) {
            $legend['text'] = 'No table of figures entries found.';
        }
        $legendOptions = $legend;
        unset($legendOptions['text']);
        $legendData = new WordFragment();
        $legendData->addText(array($legend), $legendOptions);
        $tableFigures = CreateTableFigures::getInstance();
        $tableFigures->createTableFigures($options, $legendData);
        if (isset($options['autoUpdate']) && $options['autoUpdate']) {
            $this->generateSetting('w:updateFields');
        }
        PhpdocxLogger::logger('Add table of figures to word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $tableFigures;
        } else {
            $this->_wordDocumentC .= (string) $tableFigures;
        }
    }

    /**
     * Adds a text paragraph
     *
     * @access public
     * @param mixed $textParams if a string just the text to be included, if an array is or an array of arrays with each element containing the text to be inserted and their formatting properties or an instance of WordFragment
     * Array values:
     * 'text' (string) the run of text to be inserted
     * 'bold' (bool)
     * 'caps' (bool) display text in capital letters
     * 'characterBorder' (array). Keys:
     *     'type' => none, single, double, dashed...
     *     'color' => ffffff, ff0000
     *     'spacing' => 0, 1, 2...
     *     'width' => in eights of a point
     * 'color' (ffffff, ff0000, ...)
     * 'columnBreak' (before, after, both) inserts a column break before, after or both, a run of text
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'emboss' (bool) emboss style
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'highlightColor' (string) available highlighting colors are: black, blue, cyan, green, magenta, red, yellow, white, darkBlue, darkCyan, darkGreen, darkMagenta, darkRed, darkYellow, darkGray, lightGray, none.
     * 'italic' (bool)
     * 'lang' force a lang value
     * 'lineBreak' (before, after, both) inserts a line break before, after or both, a run of text
     * 'noProof' (bool) ignore spelling and grammar errors
     * 'numForm' (string) default, lining, oldStyle
     * 'numSpacing' (string) default, proportional, tabular
     * 'outline' (bool) outline style
     * 'position' (int) position value, positive value for raised and negative value for lowered
     * 'rStyle' (string) character style to be used
     * 'rtl' (bool) if true sets right to left text orientation
     * 'scaling' (int) scaling value, 100 is the default value
     * 'shadow' (bool) shadow style
     * 'smallCaps' (bool) displays text in small capital letters
     * 'spaces' number of spaces at the beginning of the run of text
     * 'spacing' (int) character spacing, positive value for expanded and negative value for condensed
     * 'strikeThrough' (bool)
     * 'subscript' (bool)
     * 'superscript' (bool)
     * 'tab' (bool) inserts a tab. Default value is false
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'underlineColor' (ffffff, ff0000, ...)
     * 'vanish' (bool)
     *
     * Theme (Premium licenses):
     * 'theme' (array):
     *      'color' (string) accent1, accent2, accent3, accent4, accent5, accent6, dk1, dk2, folHlink, hlink, lt1, lt2...
     * @param array $paragraphParams Style options to apply to the whole paragraph
     *  Values:
     * 'pStyle' (string) paragraph style to be used
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'emboss' (bool) emboss style
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'framePr' (array)
     *      'anchorLock' (bool)
     *      'dropCap' (string) drop, margin, none
     *      'h' (int) twips
     *      'hAnchor' (string) margin, page, text
     *      'hRule' (string) atLeast, auto, exact
     *      'hSpace'  (int) twips
     *      'lines' (int)
     *      'vAnchor' (string) margin, page, text
     *      'vSpace' (int) twips
     *      'w' (int) twips
     *      'wrap' (string) around, auto, none, notBeside, through, tight
     *      'x' (int) twips
     *      'xAlign' (string) center, inside, left, outside, right
     *      'y' (int) twips
     *      'yAlign' (string) bottom, center, inline, inside, outside, top
     * 'hanging' 100, 200, ...
     * 'headingLevel' (int) the heading level, if any
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'italic' (bool)
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480...
     * 'noProof' (bool) ignore spelling and grammar errors
     * 'outline' (bool) outline style
     * 'pageBreakBefore' (bool)
     * 'parseLineBreaks' (bool) if true (default is false) parses the line breaks to include them in the Word document
     * 'parseTabs' (bool) if true (default is false) parses the tabs to include them in the Word document as w:tab tags
     * 'position' (int) position value, positive value for raised and negative value for lowered
     * 'rtl' (bool) if true sets right to left text orientation
     * 'scaling' (int) scaling value, 100 is the default value
     * 'shadow' (bool) shadow style
     * 'smallCaps' (bool) displays text in small capital letters
     * 'spacing' (int) character spacing, positive value for expanded and negative value for condensed
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'spacingLineRule' (string) auto (default), atLeast, exact
     * 'strikeThrough' (bool)
     * 'suppressAutoHyphens' (bool) suppress hyphenation
     * 'suppressLineNumbers' (bool) suppress line numbers
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     *  if there is a tab and the tabPositions array is not defined the standard tab position (default of 708) will be used
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'underlineColor' (ffffff, ff0000, ...)
     * 'vAlign' (string) vertical character alignment on line (auto, baseline, bottom, center, top)
     * 'vanish' (bool)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     *
     * Theme (Premium licenses):
     * 'theme' (array):
     *      'color' (string) accent1, accent2, accent3, accent4, accent5, accent6, dk1, dk2, folHlink, hlink, lt1, lt2...
     */
    public function addText($textParams, $paragraphParams = array())
    {
        $paragraphParams = self::setRTLOptions($paragraphParams);
        $textParams = self::translateTextOptions2StandardFormat($textParams);
        $paragraphParams = self::translateTextOptions2StandardFormat($paragraphParams);
        $text = CreateText::getInstance();
        $text->createText($textParams, $paragraphParams);

        $contentElement = (string)$text;

        if (isset($paragraphParams['parseLineBreaks']) && $paragraphParams['parseLineBreaks']) {
            $contentElement = str_replace(array('\n\r', '\r\n', '\n', '\r', "\n\r", "\r\n", "\n", "\r"), '</w:t><w:br/><w:t xml:space="preserve">', $contentElement);
        }

        if (isset($paragraphParams['parseTabs']) && $paragraphParams['parseTabs']) {
            $contentElement = str_replace(array('\t', "\t"), '</w:t><w:tab/><w:t xml:space="preserve">', $contentElement);
        }

        PhpdocxLogger::logger('Add text to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a textbox
     *
     * @access public
     * @param mixed $content it may be a WordFragment, a plain text string or an array with same parameters used in the addText method
     * The first array entry is the text to be included in the text box, the second one
     * is itself another array with all the standard text formatting options
     * @param array $options includes the specific textbox options
     *  Values:
     * 'align' (string) (left, center, right, absolute, inline) default value is left
     * 'border' (bool) default value is true
     * 'borderColor' (string) hexadecimal value (#ff0000, #0000ff, ...)
     * 'borderWidth' (float) value in points
     * 'contentVerticalAlign' (string) (top, center, bottom) default value is top
     * 'dashStyle' (string) 'longDashDot', '1 1', '3 1'...
     * 'direction' (string) 'ltr', 'rtl'
     * 'fillColor' (string) hexadecimal value (#ff0000, #0000ff, ...)
     * 'height' (mixed) height in points or 'auto' (default value)
     * 'lineStyle' (string) single, thinThin, thinThick, thickThin, thickBetweenThin
     * 'marginTop' (float)
     * 'marginLeft' (float)
     * 'marginBottom' (float)
     * 'marginRight' (float)
     * 'paddingBottom' (float) distance in mm (default is 1.3)
     * 'paddingLeft' (float) distance in mm (default is 2.5)
     * 'paddingRight' (float) distance in mm (default is 2.5)
     * 'paddingTop' (float) distance in mm (default is 1.3)
     * 'position' (string) absolute
     * 'relativeToHorizontal' (string) margin, page, text, char
     * 'relativeToVertical' (string) margin, page, text, line
     * 'textboxStyle' (string) extra textbox styles. Default as 'mso-fit-shape-to-text:t;' if height is 'auto'
     * 'textWrap' (string) (tight, square, through, topAndBottom...) default value is square
     * 'width' (float) width in points
     * 'z-index' (int)
     */
    public function addTextBox($content, $options = array())
    {
        $textBox = CreateTextBox::getInstance();
        if ($content instanceof WordFragment) {
            $textBoxContent = (string) $content;
        } else if (is_array($content)) {
            $textBoxParagraph = new WordFragment();
            $textBoxParagraph->addText($content[0], $content[1]);
            $textBoxContent = (string) $textBoxParagraph;
        } else {
            $textBoxParagraph = new WordFragment();
            $textBoxParagraph->addText($content);
            $textBoxContent = (string) $textBoxParagraph;
        }
        $textBox->createTextBox($textBoxContent, $options);

        $contentElement = (string)$textBox;

        PhpdocxLogger::logger('Add textbox to word document.', 'info');

        if ($this instanceof WordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Adds a WordFragment
     *
     * @access public
     * @param mixed $wordFragment
     */
    public function addWordFragment($wordFragment)
    {
        PhpdocxLogger::logger('Add a WordFragment into the Word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $wordFragment;
        } else {
            $this->_wordDocumentC .= $wordFragment;
        }
    }

    /**
     * Adds a raw WordML chunk of code
     *
     * @access public
     * @param string $wordML
     */
    public function addWordML($wordML)
    {
        PhpdocxLogger::logger('Add raw WordML into the Word document.', 'info');
        if ($this instanceof WordFragment) {
            $this->wordML .= (string) $wordML;
        } else {
            $this->_wordDocumentC .= $wordML;
        }
    }

    /**
     * Eliminates all block type elements from a WordML string
     *
     * @access public
     */
    public function cleanWordMLBlockElements($wordML)
    {
        $namespaces = 'xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" ';
        $wordML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:root ' . $namespaces . '>' . $wordML;
        $wordML = $wordML . '</w:root>';
        $wordMLChunk = $this->xmlUtilities->generateDomDocument($wordML);
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
                            $nodeR = str_replace($contentNodeRStdP, $contentNodeRStdR, $nodeR);
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

    /**
     * Creates a new character style
     *
     * @access public
     * @param string $name the name we want to give to the created style
     * @param mixed $styleOptions it includes the required style options
     * Array values:
     * 'bold' (bool)
     * 'caps' (bool) display text in capital letters
     * 'characterBorder' (array). Keys:
     *     'type' => none, single, double, dashed...
     *     'color' => ffffff, ff0000
     *     'spacing' => 0, 1, 2...
     *     'width' => in eights of a point
     * 'color' (ffffff, ff0000...)
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'emboss' (bool) emboss style
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in half-points
     * 'hidden' (bool)
     * 'italic' (bool)
     * 'locked' (bool)
     * 'next' (string) style to be automatically applied to the next paragraph with the current style applied
     * 'noProof' (bool) ignore spelling and grammar errors
     * 'outline' (bool) outline style
     * 'position' (int) position value, positive value for raised and negative value for lowered
     * 'rtl' (bool) if true sets right to left text orientation
     * 'semiHidden' (bool)
     * 'shadow' (bool) shadow style
     * 'smallCaps' (bool) displays text in small capital letters
     * 'strikeThrough' (bool)
     * 'subscript' (bool)
     * 'superscript' (bool)
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'unhideWhenUsed' (bool)
     * 'vanish' (bool)
     * 'vertAlign' (string) baseline, subscript, superscript
     */
    public function createCharacterStyle($name, $styleOptions = array())
    {
        $styleOptions = self::translateTextOptions2StandardFormat($styleOptions);

        // use paragraph style class but adding only character styles to the styles file
        $newStyle = new CreateParagraphStyle();
        $style = $newStyle->createCustomCharacterStyle($name, $styleOptions);
        //Let's get the original styles
        $styleXML = $this->_wordStylesT->saveXML();
        //append the new styles as a string at the end of the styles file
        $styleXML = str_replace('</w:styles>', $style . '</w:styles>', $styleXML);
        $this->_wordStylesT = $this->xmlUtilities->generateDomDocument($styleXML);
    }

    /**
     * Generates the new DOCX file
     *
     * @access public
     * @param string $fileName path to the resulting docx
     * @return void|DOCXStructure
     * @throws \Exception license not valid, error generating the file
     */
    public function createDocx($fileName = 'document')
    {
        PhpdocxLogger::logger('Set DOCX name to: ' . $fileName . '.', 'info');

        $this->saveToZip($this->_contentTypeT, '[Content_Types].xml');
        $this->saveToZip($this->_wordRelsDocumentRelsT, 'word/_rels/document.xml.rels');
        $this->saveToZip($this->_wordSettingsT, 'word/settings.xml');
        $this->saveToZip($this->_wordFootnotesT, 'word/footnotes.xml');
        $this->saveToZip($this->_wordEndnotesT, 'word/endnotes.xml');
        $this->saveToZip($this->_wordCommentsT, 'word/comments.xml');
        $this->saveToZip($this->_wordCommentsExtendedT, 'word/commentsExtended.xml');
        if (file_exists(__DIR__ . '/../Tracking/Tracking.php')) {
            $this->saveToZip($this->_wordDocumentPeople, 'word/people.xml');
        }

        if ($this->_modifiedDocxProperties) {
            $this->saveToZip($this->propsCore, 'docProps/core.xml');
            $this->saveToZip($this->propsApp, 'docProps/app.xml');
            $this->saveToZip($this->propsCustom, 'docProps/custom.xml');
            $this->saveToZip($this->relsRels, '_rels/.rels');
        }

        $this->generateTemplateWordDocument();

        PhpdocxLogger::logger('Add word/document.xml content to DOCX file.', 'info');

        if (self::$_encodeUTF) {
            if (PHP_VERSION_ID >= 80200) {
                $contentDocumentXML = mb_convert_encoding($this->_wordDocumentT, 'UTF-8', mb_list_encodings());
            } else {
                $contentDocumentXML = utf8_encode($this->_wordDocumentT);
            }
        } else {
            $contentDocumentXML = $this->_wordDocumentT;
        }

        // repair document.xml to make sure there is no invalid markup
        $repair = Repair::getInstance();
        $repair->setXML($contentDocumentXML);
        $repair->addParapraphEmptyTablesTags();
        $contentRepair = (string) $repair;

        $this->saveToZip($this->_wordStylesT, 'word/styles.xml');
        $this->saveToZip($contentRepair, 'word/document.xml');
        $this->saveToZip($this->_wordNumberingT, 'word/numbering.xml');
        //Check if there are rels for footnotes, endnotes and comments
        if (!empty(CreateDocx::$_relsNotesImage['footnote']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['footnote']) ||
                !empty(CreateDocx::$_relsNotesLink['footnote'])) {
            $this->generateRelsNotes('footnote');
            $this->saveToZip($this->_wordFootnotesRelsT, 'word/_rels/footnotes.xml.rels');
        }
        if (!empty(CreateDocx::$_relsNotesImage['endnote']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['endnote']) ||
                !empty(CreateDocx::$_relsNotesLink['endnote'])) {
            $this->generateRelsNotes('endnote');
            $this->saveToZip($this->_wordEndnotesRelsT, 'word/_rels/endnotes.xml.rels');
        }
        if (!empty(CreateDocx::$_relsNotesImage['comment']) ||
                !empty(CreateDocx::$_relsNotesExternalImage['comment']) ||
                !empty(CreateDocx::$_relsNotesLink['comment'])) {
            $this->generateRelsNotes('comment');
            $this->saveToZip($this->_wordCommentsRelsT, 'word/_rels/comments.xml.rels');
        }

        return $this->_zipDocx->saveDocx($fileName);
    }

    /**
     * Generates and downloads a new DOCX file
     *
     * @access public
     * @param string $fileName File name
     * @param bool $removeAfterDownload Remove the file after download it
     * @throws \Exception license not valid, unclosed bookmarks, error generating the file
     */
    public function createDocxAndDownload($fileName, $removeAfterDownload = false)
    {
        $args = func_get_args();

        try {
            $this->createDocx($args[0]);
        } catch (\Exception $e) {
            echo 'Error while trying to write to ' . $args[0] . ' . Check write access.';
            PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }

        if (isset($args[0]) && !empty($args[0])) {
            $fileName = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $args[0]);
            $completeName = explode(DIRECTORY_SEPARATOR, $fileName);
            $fileNameDownload = array_pop($completeName);
        } else {
            $fileName = 'document';
            $fileNameDownload = 'document';
        }

        // check if the path has as extension, and remove it if true
        if (substr($fileNameDownload, -5) == '.docx') {
            $fileNameDownload = substr($fileNameDownload, 0, -5);
        }

        // get absolute path to the file to be used with filesize and readfile methods
        $filePath = $fileNameDownload;
        if (isset($args[0])) {
            $fileInfo = pathinfo($args[0]);
            $filePath = $fileInfo['dirname'] . '/' . $fileNameDownload;
        }

        PhpdocxLogger::logger('Download file ' . $fileNameDownload . '.' . $this->_extension . '.', 'info');
        header(
                'Content-Type: application/vnd.openxmlformats-officedocument.' .
                'wordprocessingml.document'
        );
        header(
                'Content-Disposition: attachment; filename="' . $fileNameDownload .
                '.' . $this->_extension . '"'
        );
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filePath . '.' . $this->_extension));
        readfile($filePath . '.' . $this->_extension);

        // remove the generated file
        if ($removeAfterDownload) {
            unlink($filePath . '.' . $this->_extension);
        }
    }

    /**
     * Create a new paragraph style and linked char style to be used in your Word document.
     *
     * @access public
     * @param string $name the name we want to give to the created style
     * @param mixed $styleOptions it includes the required style options
     * Array values:
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in half-points
     * 'hanging' 100, ...
     * 'hidden' (bool)
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'indentFirstLine' 100, ...
     * 'italic' (bool)
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480, ...
     * 'locked' (bool)
     * 'name' (string) forces a name value, otherwise $name is used as styleId and name
     * 'next' (string) style to be automatically applied to the next paragraph with the current style applied
     * 'numberingStyle' numbering style
     * 'outlineLvl' or 'headingLevel' (int) heading level (1-9)
     * 'pageBreakBefore' (bool)
     * 'position'
     * 'pStyle' id of the style this paragraph style is based on (it may be retrieved with the parseStyles method)
     * 'primaryStyle' (bool) if true sets the style as primary style to be displayed in the styles interface
     * 'rtl' (bool) if true sets right to left text orientation
     * 'semiHidden' (bool)
     * 'smallCaps' (bool) display text in small caps
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'suppressAutoHyphens' (bool) suppress hyphenation
     * 'suppressLineNumbers' (bool) suppress line numbers
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'underlineColor' (ffffff, ff0000, ...)
     * 'unhideWhenUsed' (bool)
     * 'vanish' (bool)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     */
    public function createParagraphStyle($name, $styleOptions = array())
    {
        $styleOptions = self::translateTextOptions2StandardFormat($styleOptions);
        $newStyle = new CreateParagraphStyle();
        $style = $newStyle->addParagraphStyle($name, $styleOptions);
        //Let's get the original styles
        $styleXML = $this->_wordStylesT->saveXML();
        //append the new styles as a string at the end of the styles file
        $styleXML = str_replace('</w:styles>', $style[0] . '</w:styles>', $styleXML);
        $styleXML = str_replace('</w:styles>', $style[1] . '</w:styles>', $styleXML);
        $this->_wordStylesT = $this->xmlUtilities->generateDomDocument($styleXML);
    }

    /**
     * Create a new table style to be used in your Word document.
     *
     * @access public
     * @param string $name the name we want to give to the created style
     * @param mixed $styleOptions it includes the required style options
     * Array values:
     * 'border' (nil, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *         this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom', 'borderLeft', 'borderInsideH' and 'borderInsideV'
     * 'borderColor' (ffffff, ff0000)
     *         this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor', 'borderLeftColor', 'borderInsideHColor' and 'borderInsideVColor'
     * 'borderSpacing' (0, 1, 2...)
     *         this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing', 'borderLeftSpacing', 'borderInsideHSpacing' and 'borderInsideVSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *         this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth', 'borderLeftWidth', 'borderInsideHWidth' and 'borderInsideVWidth'
     * 'cantSplit' (bool) if true rows cannot be split over two pages
     * 'cellBackgroundColor' (string) ffffff, ff0000
     * 'cellMargin' (mixed) an integer value or an array:
     *          'top' (int) in twentieths of a point
     *          'right' (int) in twentieths of a point
     *          'bottom' (int) in twentieths of a point
     *          'left' (int) in twentieths of a point
     * 'hidden' (bool)
     * 'indent' (int) given in twips (twentieths of a point)
     * 'locked' (bool)
     * 'next' (string) style to be automatically applied to the next paragraph with the current style applied
     * 'rPrStyles' (array) @see createCharacterStyle
     * 'pPrStyles' (array) @see createParagraphStyle
     * 'semiHidden' (bool)
     * 'tableStyle' id of the style this table style is based on (it may be retrieved with the parseStyles method)
     * 'tblStyleColBandSize' (bool) true or false, banded style
     * 'tblStyleRowBandSize' (bool) true or false, banded style
     * 'unhideWhenUsed' (bool)
     *
     * 'band1HorzStyle' (array) set odd rows styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'band1VertStyle' (array) set odd cols styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'band2HorzStyle' (array) set even rows styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'band2VertStyle' (array) set even cols styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'firstColStyle' (array) set first column styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'firstRowStyle' (array) set first row styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'lastColStyle' (array) set last col styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'lastRowStyle' (array) set last row styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'neCellStyle' (array) set top right styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'nwCellStyle' (array) set top left styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'seCellStyle' (array) set bottom right styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     * 'swCellStyle' (array) set bottom left styles using border, borderColor, borderSpacing, borderWidth, backgroundColor, vAlign, rPrStyles, pPrStyles properties
     */
    public function createTableStyle($name, $styleOptions = array())
    {
        $newStyle = new CreateTableStyle();
        $style = $newStyle->addTableStyle($name, $styleOptions);

        //Let's get the original styles
        $styleXML = $this->_wordStylesT->saveXML();
        //append the new styles as a string at the end of the styles file
        $styleXML = str_replace('</w:styles>', $style . '</w:styles>', $styleXML);
        $this->_wordStylesT = $this->xmlUtilities->generateDomDocument($styleXML);
    }

    /**
     * Stablish the general docx settings in settings.xml
     *
     * @access public
     * @param array $settingParameters
     * Keys and values:
     * 'view' (string): none (default), print, outline, masterPages, normal (draft view), web
     * 'writeProtection' (bool)
     * 'zoom'(mixed): a percentage or none, fullPage (display one full page), bestFit (display page width), textFit (display text width)
     * 'mirrorMargins' (bool) if true interchanges inside and outside margins in odd and even pages
     * 'bordersDoNotSurroundHeader' (bool)
     * 'bordersDoNotSurroundFooter' (bool)
     * 'gutterAtTop' (bool)
     * 'hideSpellingErrors' (bool)
     * 'hideGrammaticalErrors' (bool)
     * 'documentType' (string): notSpecified (default), letter, eMail
     * 'trackRevisions' (bool)
     * 'defaultTabStop'(int) in twips (twentieths of a point)
     * 'autoHyphenation' (bool)
     * 'consecutiveHyphenLimit'(int): maximum number of consecutively hyphenated lines
     * 'hyphenationZone' (int) distance in twips (twentieths of a point)
     * 'doNotHyphenateCaps' (bool): do not hyphenate capital letters
     * 'defaultTableStyle' (string): the table style to be used by default
     * 'bookFoldRevPrinting' (bool): reverse book fold printing
     * 'bookFoldPrinting' (bool): book fold printing
     * 'bookFoldPrintingSheets' (int): number of pages per booklet
     * 'doNotShadeFormData' (bool)
     * 'noPunctuationKerning' (bool): never kern punctuation characters
     * 'printTwoOnOne' (bool): print two pages per sheet
     * 'savePreviewPicture' (bool): generate thumbnail for document on save
     * 'updateFields' (bool): automatically recalculate fields on open
     * 'compat' (array): set compat settings
     * 'customSetting' (array): set custom settings
     */
    public function docxSettings($settingParameters)
    {
        $settingParams = array(
            'writeProtection',
            'view',
            'zoom',
            'displayBackgroundShape',
            'mirrorMargins',
            'bordersDoNotSurroundHeader',
            'bordersDoNotSurroundFooter',
            'gutterAtTop',
            'hideSpellingErrors',
            'hideGrammaticalErrors',
            'documentType',
            'trackRevisions',
            'defaultTabStop',
            'autoHyphenation',
            'consecutiveHyphenLimit',
            'hyphenationZone',
            'doNotHyphenateCaps',
            'defaultTableStyle',
            'bookFoldRevPrinting',
            'bookFoldPrinting',
            'bookFoldPrintingSheets',
            'doNotShadeFormData',
            'noPunctuationKerning',
            'printTwoOnOne',
            'savePreviewPicture',
            'updateFields',
            'compat',
            'customSetting',
        );
        foreach ($settingParameters as $tag => $value) {
            if ((!in_array($tag, $settingParams))) {
                PhpdocxLogger::logger('That setting tag is not supported.', 'info');
            } else {
                $settingIndex = array_search('w:' . $tag, OOXMLResources::$settings);
                $selectedElements = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
                if ($tag == 'customSetting' && is_array($value)) {
                    $selectedElements = $this->_wordSettingsT->documentElement->getElementsByTagName($value['tag']);
                }
                if ($selectedElements->length == 0) {
                    $settingsElement = $this->_wordSettingsT->createDocumentFragment();
                    if ($tag == 'zoom') {
                        if (is_numeric($value)) {
                            $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:percent="' . $value . '"/>');
                        } else {
                            $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val="' . $value . '"/>');
                        }
                    } else if ($tag == 'customSetting' && is_array($value)) {
                        $attributesCustomSetting = '';
                        foreach ($value['values'] as $keyValue => $valueValue) {
                            $attributesCustomSetting .= $keyValue . '="' . $valueValue . '" ';
                        }
                        $settingsElement->appendXML('<w:' . $value['tag'] . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ' . $attributesCustomSetting . '/>');
                    } else if ($tag == 'compat' && is_array($value)) {
                        // create the compat tag and its children
                        $compatTagContent = '<w:compat xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">';
                        foreach ($value as $keyValue => $valueValue) {
                            if ($keyValue == 'customSetting') {
                                // customSetting tag
                                $attributesCustomSetting = '';
                                foreach ($valueValue['values'] as $keyCustomSettingAttribute => $valueCustomSettingAttribute) {
                                    $attributesCustomSetting .= $keyCustomSettingAttribute . '="' . $valueCustomSettingAttribute . '" ';
                                }
                                $compatTagContent .= '<w:' . $valueValue['tag'] . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ' . $attributesCustomSetting . '/>';
                            } else {
                                $compatTagContent .= '<w:compatSetting xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:name="' . $keyValue . '" w:uri="http://schemas.microsoft.com/office/word" w:val="' . $valueValue['val'] . '"/>';
                            }
                        }
                        $compatTagContent .= '</w:compat>';
                        $settingsElement->appendXML($compatTagContent);
                    } else if ($tag == 'writeProtection' && is_bool($value)) {
                        if ($value) {
                            $settingsElement->appendXML('<w:writeProtection xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:recommended="1"/>');
                        } else {
                            // do not add w:writeProtection tag
                            continue;
                        }
                    } else {
                        $settingsElement->appendXML('<w:' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:val = "' . $value . '"/>');
                    }
                    $childNodes = $this->_wordSettingsT->documentElement->childNodes;
                    $index = false;
                    foreach ($childNodes as $node) {
                        $name = $node->nodeName;
                        $index = array_search($node->nodeName, OOXMLResources::$settings);
                        if ($index > $settingIndex) {
                            $node->parentNode->insertBefore($settingsElement, $node);
                            break;
                        }
                    }
                    // in case no node was found (pretty unlikely) append the node
                    if (!$index) {
                        $this->_wordSettingsT->documentElement->appendChild($settingsElement);
                    }
                } else {
                    // that setting is already present
                    if ($tag == 'zoom') {
                        $selectedElements->item(0)->removeAttribute('w:val');
                        $selectedElements->item(0)->removeAttribute('w:percent');
                        if (is_numeric($value)) {
                            $selectedElements->item(0)->setAttribute('w:percent', $value);
                        } else {
                            $selectedElements->item(0)->setAttribute('w:val', $value);
                        }
                    } else if ($tag == 'customSetting' && is_array($value)) {
                        foreach ($value['values'] as $keyValue => $valueValue) {
                            $selectedElements->item(0)->setAttribute($keyValue, $valueValue);
                        }
                    } else if ($tag == 'writeProtection') {
                        if ($value) {
                            $selectedElements->item(0)->setAttribute('w:recommended', '1');
                        } else {
                            $selectedElements->item(0)->parentNode->removeChild($selectedElements->item(0));
                        }
                    } else if ($tag == 'compat' && is_array($value)) {
                        foreach ($value as $keyValue => $valueValue) {
                            if ($keyValue == 'customSetting') {
                                // create the customSetting tag if doesn't exist. Otherwise change its val attribute
                                $wordSettingsXPath = new \DOMXPath($this->_wordSettingsT);
                                $wordSettingsXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
                                $query = '//w:' . $valueValue['tag'];
                                $compatCustomSettingElement = $wordSettingsXPath->query($query);

                                if ($compatCustomSettingElement->length == 0) {
                                    $attributesCustomSetting = '';
                                    foreach ($valueValue['values'] as $keyCustomSettingAttribute => $valueCustomSettingAttribute) {
                                        $attributesCustomSetting .= $keyCustomSettingAttribute . '="' . $valueCustomSettingAttribute . '" ';
                                    }
                                    $settingsElement = $this->_wordSettingsT->createDocumentFragment();
                                    $settingsElement->appendXML('<w:' . $valueValue['tag'] . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ' . $attributesCustomSetting . '/>');
                                    $selectedElements->item(0)->appendChild($settingsElement);
                                } else {
                                    // change the attributes of the custom setting
                                    foreach ($valueValue['values'] as $keyCustomSettingAttribute => $valueCustomSettingAttribute) {
                                        $compatCustomSettingElement->item(0)->setAttribute($keyCustomSettingAttribute, $valueCustomSettingAttribute);
                                    }
                                }
                            } else {
                                // create the compatSetting tag if doesn't exist. Otherwise change its val attribute
                                $wordSettingsXPath = new \DOMXPath($this->_wordSettingsT);
                                $wordSettingsXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
                                $query = '//w:compatSetting[@w:name="' . $keyValue . '"]';
                                $compatSettingsElement = $wordSettingsXPath->query($query);

                                if ($compatSettingsElement->length == 0) {
                                    $settingsElement = $this->_wordSettingsT->createDocumentFragment();
                                    $settingsElement->appendXML('<w:compatSetting xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:name="' . $keyValue . '" w:uri="http://schemas.microsoft.com/office/word" w:val="' . $valueValue['val'] . '"/>');
                                    $selectedElements->item(0)->appendChild($settingsElement);
                                } else {
                                    $compatSettingsElement->item(0)->setAttribute('w:val', $valueValue['val']);
                                }
                            }
                        }
                    } else {
                        $selectedElements->item(0)->setAttribute('w:val', $value);
                    }
                }
            }
        }
    }

    /**
     * Generates a unique number not used in elements of the document
     *
     * @access protected
     * @static
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function uniqueNumberId($min, $max)
    {
        $proposedId = mt_rand($min, $max);
        if (in_array($proposedId, self::$elementsId)) {
            $proposedId = self::uniqueNumberId($min, $max);
        }
        self::$elementsId[] = $proposedId;

        return $proposedId;
    }

    /**
     * Creates an empty word numbering base string
     *
     * @return string
     * @throws \Exception error opening the file
     */
    public function generateBaseWordNumbering()
    {
        // copy the numbering.xml file from the standard PHPDocX template into the new base template
        $templateStructure = new DOCXStructureTemplate();
        $numZip = $templateStructure->getStructure();

        $baseWordNumbering = $numZip->getContent('word/numbering.xml');

        return $baseWordNumbering;
    }

    /**
     *
     * Inserts a new numbering style.
     *
     * @param string $numberingsXML the numberings.xml that we wish to modify
     * @param string $newNumbering the new numbering style we wish to add
     * @param mixed $numberId a unique integer tha determines the numId
     * @param mixed $originalAbstractNumId a unique integer that determines the abstractNumId
     * @param bool $removeNsid
     */
    public function importSingleNumbering($numberingsXML, $newNumbering, $numberId, $originalAbstractNumId = '', $removeNsid = false)
    {
        // insert the $newNumbering into $numberingsXML
        $myNumbering = $this->xmlUtilities->generateDomDocument($numberingsXML);

        // check if there's content in the numbering. Add a base it there's no child
        if ($myNumbering->documentElement->firstChild === null) {
            $this->_wordNumberingT = $this->generateBaseWordNumbering();
            $myNumbering = $this->xmlUtilities->generateDomDocument($this->_wordNumberingT);
        }

        // modify the w:abstractNumId atribute
        $newNumbering = str_replace('w:abstractNumId="' . $originalAbstractNumId . '"', 'w:abstractNumId="' . $numberId . '"', $newNumbering);
        $newNumbering = str_replace('w:tplc=""', 'w:tplc="' . rand(10000000, 99999999) . '"', $newNumbering);
        $new = $myNumbering->createDocumentFragment();
        $prevValueLibXmlInternalErrors = libxml_use_internal_errors(true);
        $new->appendXML($newNumbering);
        libxml_clear_errors();
        libxml_use_internal_errors($prevValueLibXmlInternalErrors);
        $base = $myNumbering->documentElement->firstChild;
        $base->parentNode->insertBefore($new, $base);

        if ($removeNsid) {
            $numXPath = new \DOMXPath($myNumbering);
            $numXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $nsidQuery = '//w:nsid | //w:tmpl';
            $nsidNodes = $numXPath->query($nsidQuery);
            foreach ($nsidNodes as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        $numberingsXML = $myNumbering->saveXML();

        // include the relationship
        $newNum = '<w:num w:numId="' . $numberId . '"><w:abstractNumId w:val="' . $numberId . '" /></w:num>';
        // check if there is a w:numIdMacAtCleanup element
        if (strpos($numberingsXML, 'w:numIdMacAtCleanup') !== false) {
            $numberingsXML = str_replace('<w:numIdMacAtCleanup', $newNum . '<w:numIdMacAtCleanup', $numberingsXML);
        } else {
            $numberingsXML = str_replace('</w:numbering>', $newNum . '</w:numbering>', $numberingsXML);
        }

        return $numberingsXML;
    }

    /**
     * Imports an existing style sheet from an existing docx document.
     *
     * @access public
     * @param string|DOCXStructure $path. Must be a valid path to an existing .docx, .dotx o .docm document
     * @param string $type 'replace' (overwrites the current styles) or 'merge' (adds the selected styles)
     * @param array $myStyles a list of specific styles to be merged. If it is empty or the choosen type is 'replace' it will be ignored.
     * @param string $styleIdentifier can be styleName or styleID
     * @throws \Exception error opening the file
     */
    public function importStyles($path, $type = 'replace', $myStyles = array(), $styleIdentifier = 'styleName')
    {
        if ($path instanceof DOCXStructure) {
            $zipStyles = $path;
        } else {
            $zipStyles = new DOCXStructure();
            $zipStyles->parseDocx($path);
        }

        if ($type == 'replace') {
            // overwrite the original styles file
            $this->_wordStylesT = $this->xmlUtilities->generateDomDocument($zipStyles->getContent('word/styles.xml'));

            // in order not to loose certain styles needed for certain PHPDOCX methods, merge them
            $templateStructure = new DOCXStructureTemplate();
            $numZip = $templateStructure->getStructure();
            $this->importStyles($numZip, 'PHPDOCXStyles');
        } else {
            if ($type == 'PHPDOCXStyles') {
                $newStyles = OOXMLResources::$PHPDOCXStyles;
            } else {
                // first extract the new styles from the external docx
                try {
                    $newStyles = $zipStyles->getContent('word/styles.xml');
                    if (!$newStyles) {
                        throw new \Exception('Error while extracting the styles from the external docx');
                    }
                } catch (\Exception $e) {
                    PhpdocxLogger::logger($e->getMessage(), 'fatal');
                }
            }

            // parse the different styles via XPath
            $newStylesDoc = $this->xmlUtilities->generateDomDocument($newStyles);
            $stylesXpath = new \DOMXPath($newStylesDoc);
            $stylesXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $queryStyle = '//w:style';
            $styleNodes = $stylesXpath->query($queryStyle);

            // search for linked styles and basedOn styles
            if ($type == 'merge' && count($myStyles) > 0) {
                foreach ($myStyles as $singleStyle) {
                    if ($styleIdentifier == 'styleID') {
                        $query = '//w:style[@w:styleId="' . $singleStyle . '"]/w:basedOn | //w:style[@w:styleId="' . $singleStyle . '"]/w:link | //w:style[@w:styleId="' . $singleStyle . '"]';
                        $linkedNodes = $stylesXpath->query($query);
                        foreach ($linkedNodes as $linked) {
                            $myStyles[] = $linked->getAttribute('w:val');
                        }
                    } else if ($styleIdentifier == 'styleName') {
                        $query = '//w:style[w:name[@w:val="' . $singleStyle . '"]]/w:basedOn | //w:style[w:name[@w:val="' . $singleStyle . '"]]/w:link | //w:style[@w:name="' . $singleStyle . '"]';
                        $linkedNodes = $stylesXpath->query($query);
                        foreach ($linkedNodes as $linked) {
                            $linkedID = $linked->getAttribute('w:val');
                            $query = '//w:style[@w:styleId="' . $linkedID . '"]/w:name';
                            $nodeNames = $stylesXpath->query($query);
                            if ($nodeNames->length > 0) {
                                $myStyles[] = $nodeNames->item(0)->getAttribute('w:val');
                            }
                        }
                    }
                }
            }

            // get the original styles as a DOMDocument
            $baseNode = $this->_wordStylesT->documentElement;
            $stylesDocumentXPath = new \DOMXPath($this->_wordStylesT);
            $stylesDocumentXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $query = '//w:style';
            $originalNodes = $stylesDocumentXPath->query($query);

            // insert the new styles at the end of the styles.xml
            foreach ($styleNodes as $node) {
                // check if the style has a numId to be added
                $numIdNode = $node->getElementsByTagName('numId');
                if ($numIdNode->length > 0) {
                    $numId = $numIdNode->item(0)->getAttribute('w:val');
                    // import and add the numbering
                    $externalNumbering = $this->xmlUtilities->generateDomDocument($zipStyles->getContent('word/numbering.xml'));
                    $numXPath = new \DOMXPath($externalNumbering);
                    $numXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
                    $query = '//w:num[@w:numId = "' . $numId . '"]';
                    $numbering = $numXPath->query($query);
                    if ($numbering->length > 0) {
                        $abstractNumId = $numbering->item(0)->getElementsByTagName('abstractNumId')->item(0)->getAttribute('w:val');
                        $query2 = '//w:abstractNum[@w:abstractNumId = "' . $abstractNumId . '"]';
                        $listStyleNode = $numXPath->query($query2)->item(0);
                        $listStyleXML = $listStyleNode->ownerDocument->saveXML($listStyleNode);
                        $listId = self::uniqueNumberId(999, 32766);
                        $originalAbstractNumId = self::uniqueNumberId(999, 32766);
                        // check if the style includes a numStyleLink tag to apply their properties
                        $numStyleLinkNodes = $listStyleNode->getElementsByTagName('numStyleLink');
                        if ($numStyleLinkNodes->length > 0) {
                            $styleValue = $numStyleLinkNodes->item(0)->getAttribute('w:val');
                            $queryStyleValue = '//w:abstractNum/w:styleLink[@w:val="'.$styleValue.'"]';
                            $abstractStyleNode = $numXPath->query($queryStyleValue);
                            if ($abstractStyleNode->length > 0) {
                                $abstractStyleLvlNodes = $abstractStyleNode->item(0)->parentNode->getElementsByTagName('lvl');
                                if ($abstractStyleLvlNodes->length > 0) {
                                    // add the level styles to the new list style to use them instead of the numStyleLink value
                                    $keepNodes = array();
                                    foreach ($abstractStyleLvlNodes as $abstractStyleLvlNode) {
                                        $keepNodes[] = clone($abstractStyleLvlNode);
                                    }
                                    // insert the nodes
                                    foreach ($keepNodes as $keepNode) {
                                        $numStyleLinkNodes->item(0)->parentNode->appendChild($keepNode);
                                    }
                                    // remove numStyleLink
                                    $numStyleLinkNodes->item(0)->parentNode->removeChild($numStyleLinkNodes->item(0));
                                }
                                $listStyleXML = $listStyleNode->ownerDocument->saveXML($listStyleNode);
                            }
                        }
                        $this->_wordNumberingT = $this->importSingleNumbering($this->_wordNumberingT, $listStyleXML, $listId, $abstractNumId);
                        $this->_wordNumberingT = str_replace('<w:abstractNum w:abstractNumId="0"', '<w:abstractNum w:abstractNumId="' . $listId . '"', $this->_wordNumberingT);
                        $listStyleXML = str_replace('<w:abstractNum w:abstractNumId="0"', '<w:abstractNum w:abstractNumId="' . $originalAbstractNumId . '"', $listStyleXML);
                        if (!isset($name)) {
                            $name = 'nl' . $listId;
                        }
                        self::$customLists[$name]['id'] = $listId;
                        self::$customLists[$name]['wordML'] = $listStyleXML;
                        $numIdNode->item(0)->setAttribute('w:val', $listId);
                    }
                }

                // in order to avoid duplicated Ids we first remove from the
                // original styles.xml any duplicity with the new ones
                foreach ($originalNodes as $oldNode) {
                    if ($styleIdentifier == 'styleID') {
                        if ($oldNode->getAttribute('w:styleId') == $node->getAttribute('w:styleId') && in_array($oldNode->getAttribute('w:styleId'), $myStyles)) {
                            $oldNode->parentNode->removeChild($oldNode);
                        }
                    } else {
                        $oldName = $oldNode->getElementsByTagName('name');
                        foreach ($oldName as $myNode) {
                            $myName = $myNode->getAttribute('w:val');
                            if ($oldNode->getAttribute('w:styleId') == $node->getAttribute('w:styleId') && in_array($myName, $myStyles)) {
                                $oldNode->parentNode->removeChild($oldNode);
                            }
                        }
                    }
                }
                if (count($myStyles) > 0) {
                    // insert the selected styles
                    if ($styleIdentifier == 'styleID') {
                        if (in_array($node->getAttribute('w:styleId'), $myStyles)) {
                            $insertNode = $this->_wordStylesT->importNode($node, true);
                            $baseNode->appendChild($insertNode);
                        }
                    } else {
                        $nodeChilds = $node->childNodes;
                        foreach ($nodeChilds as $child) {
                            if ($child->nodeName == 'w:name') {
                                $styleName = $child->getAttribute('w:val');
                                if (in_array($styleName, $myStyles)) {
                                    $insertNode = $this->_wordStylesT->importNode($node, true);
                                    $baseNode->appendChild($insertNode);
                                }
                            }
                        }
                    }
                } else {
                    $insertNode = $this->_wordStylesT->importNode($node, true);
                    $baseNode->appendChild($insertNode);
                }
            }
        }

        PhpdocxLogger::logger('Import styles from an external docx.', 'info');
    }

    /**
     * Imports MS Word default styles
     *
     * @access public
     * @param string $type 'ignore' (ignore styles with the same name) (default), 'replace' (overwrite styles with the same name)
     * @param array $styles styles to be imported. All as default.
     * Available styles:
     *      'DefaultParagraphFont' (character)
     *      'CommentReference', 'CommentText', 'CommentTextChar' (comment)
     *      'EndnoteReference', 'EndnoteText', 'EndnoteTextChar' (endnote)
     *      'FootnoteReference', 'FootnoteText', 'FootnoteTextChar' (footnote)
     *      'Heading1', 'Heading2', 'Heading3', 'Heading4', 'Heading5', 'Heading6', 'Heading1Char', 'Heading2Char', 'Heading3Char', 'Heading4Char', 'Heading5Char', 'Heading6Char' (heading)
     *      'Hyperlink' (hyperlink)
     *      'NoList' (numbering)
     *      'NoSpacing' (paragraph)
     *      'TableGrid', 'TableNormal' (table)
     *      'Title', 'TitleChar', 'Subtitle', 'SubtitleChar' (title)
     */
    public function importStylesWordDefault($type = 'ignore', $styles = array())
    {
        $stylesToImport = array(
            'DefaultParagraphFont', // character
            'CommentReference', 'CommentText', 'CommentTextChar', // comment
            'EndnoteReference', 'EndnoteText', 'EndnoteTextChar', // endnote
            'FootnoteReference', 'FootnoteText', 'FootnoteTextChar', // footnote
            'Heading1', 'Heading2', 'Heading3', 'Heading4', 'Heading5', 'Heading6', 'Heading1Char', 'Heading2Char', 'Heading3Char', 'Heading4Char', 'Heading5Char', 'Heading6Char', // heading
            'Hyperlink', // hyperlink
            'NoList', // numbering
            'NoSpacing', // paragraph
            'TableGrid', 'TableNormal', // table
            'Title', 'TitleChar', 'Subtitle', 'SubtitleChar', // title
        );

        if (count($styles) > 0) {
            $stylesToImport = $styles;
        }

        // get the original styles as a DOMDocument
        $stylesDocumentXPath = new \DOMXPath($this->_wordStylesT);
        $stylesDocumentXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        foreach ($stylesToImport as $styleToImport) {
            if (!isset(OOXMLResources::$PHPDOCXMSWORDDefaultStyles[$styleToImport])) {
                // do not add not valid styles
                continue;
            }
            $query = '//w:style[@w:styleId="'.$styleToImport.'"]';
            $existingStyle = $stylesDocumentXPath->query($query);
            if ($existingStyle->length > 0 && $type == 'ignore') {
                // the styleId exists and the import type is set as ignore. Do not import the new style
                continue;
            } else if ($existingStyle->length > 0) {
                // the styleId exists and the import type is set as replace. Remove the existing style
                $existingStyle->item(0)->parentNode->removeChild($existingStyle->item(0));
            }

            // import the new style
            $newStyleNode = $this->_wordStylesT->createDocumentFragment();
            $newStyleNode->appendXML(OOXMLResources::$PHPDOCXMSWORDDefaultStyles[$styleToImport]);
            $this->_wordStylesT->documentElement->appendChild($newStyleNode);
        }

        PhpdocxLogger::logger('Import MS Word default styles.', 'info');
    }

    /**
     * Modifies page layout
     *
     * @access public
     * @param string $paperType (string): A4, A3, letter, legal, A4-landscape, A3-landscape, letter-landscape, legal-landscape, custom
     * @param array $options
     * Values:
     * width (int) measurement in twips (twentieths of a point)
     * height (int) measurement in twips (twentieths of a point)
     * numberCols (int) integer
     * sepCols (bool) draw a line between columns. Default as false
     * orient (string) portrait, landscape
     * marginTop (int) measurement in twips (twentieths of a point)
     * marginRight (int) measurement in twips (twentieths of a point)
     * marginBottom (int) measurement in twips (twentieths of a point)
     * marginLeft (int) measurement in twips (twentieths of a point)
     * marginHeader (int) measurement in twips (twentieths of a point)
     * marginFooter (int) measurement in twips (twentieths of a point)
     * space (int) column spacing, measurement in twips (twentieths of a point)
     * gutter (int) measurement in twips (twentieths of a point)
     * vAlign (string) vertical alignment: top, center, both, bottom
     * bidi (bool) set to true for right to left languages
     * rtlGutter (bool) set to true for right to left languages
     * onlyLastSection (bool) if true it only modifies the last section (default value is false)
     * sectionNumbers (array) an array with the sections to modify
     * pageNumberType (array) with the following keys and values:
     *     fmt (string) number format (cardinalText, decimal, decimalEnclosedCircle, decimalEnclosedFullstop, decimalEnclosedParen, decimalZero, lowerLetter, lowerRoman, none, ordinalText, upperLetter, upperRoman)
     *     start (int) page number
     * columns (array) allows generating a page layout with custom column numbers and sizes with the following keys and values:
     *     width (int)
     *     space (int)
     * endnotes (array) sets endnote options with the following keys and values:
     *     numFmt (string) numbering format: decimal, upperRoman, lowerRoman, upperLetter...
     *     numRestart (string) continuous, eachSect, eachPage
     *     numStart (int) starting value
     *     pos (string) sectEnd, docEnd
     * footnotes (array) sets footnote options with the following keys and values:
     *     numFmt (string) numbering format: decimal, upperRoman, lowerRoman, upperLetter...
     *     numRestart (string) continuous, eachSect, eachPage
     *     numStart (int) starting value
     *     pos (string) pageBottom, beneathText
     * @throws \Exception invalid paper size
     */
    public function modifyPageLayout($paperType = 'letter', $options = array())
    {
        $options = $options = self::setRTLOptions($options);
        if (empty($options['onlyLastSection'])) {
            $options['onlyLastSection'] = false;
        }
        $paperTypes = OOXMLResources::$pageLayoutPaperTypes;
        $layoutOptions = OOXMLResources::$pageLayoutOptions;
        $referenceSizes = OOXMLResources::$pageLayoutReferenceSizes;

        try {
            if (!in_array($paperType, $paperTypes)) {
                throw new \Exception('You have used an invalid paper size');
            }
        } catch (\Exception $e) {
            PhpdocxLogger::logger($e->getMessage(), 'fatal');
        }

        $layout = array();
        foreach ($layoutOptions as $opt) {
            if (isset($referenceSizes[$paperType][$opt])) {
                $layout[$opt] = $referenceSizes[$paperType][$opt];
            }
        }
        foreach ($layoutOptions as $opt) {
            if (isset($options[$opt])) {
                $layout[$opt] = $options[$opt];
            }
        }

        if (isset($options['pageNumberType'])) {
            $layout['pageNumberType'] = $options['pageNumberType'];
        }

        if (!isset($options['sectionNumbers'])) {
            $options['sectionNumbers'] = null;
        }
        // get the current sectPr nodes
        if ($options['onlyLastSection']) {
            $this->_tempDocumentDOM = $this->getDOMDocx();
            $sectPrNodes = array();
            $sectPrNodes[] = $this->_sectPr->documentElement;
        } else {
            $sectPrNodes = $this->getSectionNodes($options['sectionNumbers']);
        }
        // modify them
        foreach ($sectPrNodes as $sectionNode) {
            if (isset($layout['width'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:w', $layout['width']);
            }
            if (isset($layout['height'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:h', $layout['height']);
            }
            if (isset($layout['orient'])) {
                $this->_sectPr->getElementsByTagName('pgSz')->item(0)->setAttribute('w:orient', $layout['orient']);
            }
            if (isset($layout['code'])) {
                $sectionNode->getElementsByTagName('pgSz')->item(0)->setAttribute('w:code', $layout['code']);
            }
            if (isset($layout['marginTop'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:top', $layout['marginTop']);
            }
            if (isset($layout['marginRight'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:right', $layout['marginRight']);
            }
            if (isset($layout['marginBottom'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:bottom', $layout['marginBottom']);
            }
            if (isset($layout['marginLeft'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:left', $layout['marginLeft']);
            }
            if (isset($layout['marginHeader'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:header', $layout['marginHeader']);
            }
            if (isset($layout['marginFooter'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:footer', $layout['marginFooter']);
            }
            if (isset($layout['gutter'])) {
                $sectionNode->getElementsByTagName('pgMar')->item(0)->setAttribute('w:gutter', $layout['gutter']);
            }
            if (isset($layout['bidi'])) {
                $this->modifySingleSectionProperty($sectionNode, 'bidi', array('val' => $layout['bidi']));
            }
            if (isset($layout['rtlGutter'])) {
                $this->modifySingleSectionProperty($sectionNode, 'rtlGutter', array('val' => $layout['rtlGutter']));
            }
            if (isset($options['vAlign'])) {
                $this->modifySingleSectionProperty($sectionNode, 'vAlign', array('val' => $options['vAlign']));
            }
            if (isset($layout['pageNumberType'])) {
                $this->modifySingleSectionProperty($sectionNode, 'pgNumType', array('fmt' => $layout['pageNumberType']['fmt'], 'start' => $layout['pageNumberType']['start']));
            }

            // look at the case of columns
            $sepCols = '';
            if (isset($options['sepCols']) && $options['sepCols']) {
                $sepCols = ' w:sep="1" ';
                if ($sectionNode->getElementsByTagName('cols')->length > 0) {
                    $sectionNode->getElementsByTagName('cols')->item(0)->setAttribute('w:sep', '1');
                }
            }

            if (isset($layout['numberCols'])) {
                if ($sectionNode->getElementsByTagName('cols')->length > 0) {
                    $sectionNode->getElementsByTagName('cols')->item(0)->setAttribute('w:num', $layout['numberCols']);
                } else {
                    $colsNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $colsNode->appendXML('<w:cols w:num="' . $layout['numberCols'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" /> ' . $sepCols);
                    $sectionNode->appendChild($colsNode);
                }
            }

            if (isset($options['space'])) {
                if ($sectionNode->getElementsByTagName('cols')->length > 0) {
                    $sectionNode->getElementsByTagName('cols')->item(0)->setAttribute('w:space', $options['space']);
                } else {
                    $colsNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $colsNode->appendXML('<w:cols w:num="' . $layout['numberCols'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:space="' . $options['space'] . '" ' . $sepCols . '/>');
                    $sectionNode->appendChild($colsNode);
                }
            }

            if (isset($options['columns']) && array($options['columns'])) {
                if ($sectionNode->getElementsByTagName('cols')->length > 0) {
                    $sectionNode->getElementsByTagName('cols')->item(0)->setAttribute('w:equalWidth', '0');
                } else {
                    $colsNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $colsNode->appendXML('<w:cols w:num="' . $layout['numberCols'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:space="' . $options['columns'][0]['space'] . '" ' . $sepCols . '/>');
                    $sectionNode->appendChild($colsNode);
                }

                // remove existing internal columns to avoid generating more col tags than the requested
                $colsNode = $sectionNode->getElementsByTagName('cols')->item(0);
                $colNodes = $colsNode->getElementsByTagName('col');
                $nodesToBeRemoved = array();
                foreach ($colNodes as $currentColNode) {
                    $nodesToBeRemoved[] = $currentColNode;
                }
                foreach ($nodesToBeRemoved as $nodeToBeRemoved) {
                    $nodeToBeRemoved->parentNode->removeChild($nodeToBeRemoved);
                }

                foreach ($options['columns'] as $columnData) {
                    $colNode = $colsNode->ownerDocument->createDocumentFragment();
                    if (isset($columnData['space'])) {
                        $colNode->appendXML('<w:col w:w="' . $columnData['width'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:space="' . $options['space'] . '"/>');
                    } else {
                        $colNode->appendXML('<w:col w:w="' . $columnData['width'] . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
                    }
                    $colsNode->appendChild($colNode);
                }
            }

            if (isset($options['footnotes']) && array($options['footnotes'])) {
                if ($sectionNode->getElementsByTagName('footnotePr')->length == 0) {
                    $footnotePrNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $footnotePrNode->appendXML('<w:footnotePr xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"></w:footnotePr>');
                    $sectionNode->appendChild($footnotePrNode);
                }

                foreach ($options['footnotes'] as $footnoteSectionKey => $footnoteSectionValue) {
                    $sectionFootnotePr = $sectionNode->getElementsByTagName('footnotePr');
                    if ($sectionFootnotePr->length > 0) {
                        $sectionFootnoteProperty = $sectionFootnotePr->item(0)->getElementsByTagName($footnoteSectionKey);
                        if ($sectionFootnoteProperty->length == 0) {
                            // create the property
                            $footnotePrNode = $sectionFootnotePr->item(0)->ownerDocument->createDocumentFragment();
                            $footnotePrNode->appendXML('<w:' . $footnoteSectionKey . ' ' . 'w:val="' . $footnoteSectionValue . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
                            $sectionFootnotePr->item(0)->appendChild($footnotePrNode);
                        } else {
                            // update the existing property
                            $sectionFootnoteProperty->item(0)->setAttribute('w:val', $footnoteSectionValue);
                        }
                    }
                }
            }

            if (isset($options['endnotes']) && array($options['endnotes'])) {
                if ($sectionNode->getElementsByTagName('endnotePr')->length == 0) {
                    $endnotePrNode = $sectionNode->ownerDocument->createDocumentFragment();
                    $endnotePrNode->appendXML('<w:endnotePr xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"></w:endnotePr>');
                    $sectionNode->appendChild($endnotePrNode);
                }

                foreach ($options['endnotes'] as $endnoteSectionKey => $endnoteSectionValue) {
                    $sectionEndnotePr = $sectionNode->getElementsByTagName('endnotePr');
                    if ($sectionEndnotePr->length > 0) {
                        $sectionEndnoteProperty = $sectionEndnotePr->item(0)->getElementsByTagName($endnoteSectionKey);
                        if ($sectionEndnoteProperty->length == 0) {
                            // create the property
                            $endnotePrNode = $sectionEndnotePr->item(0)->ownerDocument->createDocumentFragment();
                            $endnotePrNode->appendXML('<w:' . $endnoteSectionKey . ' ' . 'w:val="' . $endnoteSectionValue . '" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
                            $sectionEndnotePr->item(0)->appendChild($endnotePrNode);
                        } else {
                            // update the existing property
                            $sectionEndnoteProperty->item(0)->setAttribute('w:val', $endnoteSectionValue);
                        }
                    }
                }
            }
        }

        $this->restoreDocumentXML();
    }

    /**
     *
     * Remove existing footers
     *
     */
    public function removeFooters()
    {
        foreach ($this->_relsFooter as $key => $value) {
            // first remove the actual footer files
            $this->_zipDocx->deleteContent('word/' . $value);
            $this->_zipDocx->deleteContent('word/_rels/' . $value . '.rels');

            // modify the rels file
            $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');
            $counter = $relationships->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $relationships->item($j)->getAttribute('Target');
                if ($target == $value) {
                    $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                }
            }
            // remove the corresponding override tags from [Content_Types].xml
            $overrides = $this->_contentTypeT->getElementsByTagName('Override');
            $counter = $overrides->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $overrides->item($j)->getAttribute('PartName');
                if ($target == '/word/' . $value) {
                    $this->_contentTypeT->documentElement->removeChild($overrides->item($j));
                }
            }
        }
        // change the section properties
        $footers = $this->_sectPr->getElementsByTagName('footerReference');
        $counter = $footers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($footers->item($j));
        }
        $titlePage = $this->_sectPr->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($titlePage->item($j));
        }
        // remove the footer references that may exist
        // within $this->_wordDocumentC
        $domDocument = $this->getDOMDocx();
        $footers = $domDocument->getElementsByTagName('footerReference');
        $counter = $footers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $footers->item($j)->parentNode->removeChild($footers->item($j));
        }
        $titlePage = $domDocument->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $titlePage->item($j)->parentNode->removeChild($titlePage->item($j));
        }
        $this->_tempDocumentDOM = $domDocument;
        $this->restoreDocumentXML();
        // finally, if it exists, the evenAndOddHeader element from settings
        $this->removeSetting('w:evenAndOddHeaders');
    }

    /**
     *
     * Remove existing headers
     *
     */
    public function removeHeaders()
    {
        foreach ($this->_relsHeader as $key => $value) {
            // first remove the actual header files
            $this->_zipDocx->deleteContent('word/' . $value);
            $this->_zipDocx->deleteContent('word/_rels/' . $value . '.rels');

            // modify the rels file
            $relationships = $this->_wordRelsDocumentRelsT->getElementsByTagName('Relationship');
            $counter = $relationships->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $relationships->item($j)->getAttribute('Target');
                if ($target == $value) {
                    $this->_wordRelsDocumentRelsT->documentElement->removeChild($relationships->item($j));
                }
            }

            // remove the corresponding override tags from [Content_Types].xml
            $overrides = $this->_contentTypeT->getElementsByTagName('Override');
            $counter = $overrides->length - 1;
            for ($j = $counter; $j > -1; $j--) {
                $target = $overrides->item($j)->getAttribute('PartName');
                if ($target == '/word/' . $value) {
                    $this->_contentTypeT->documentElement->removeChild($overrides->item($j));
                }
            }
        }

        // change the section properties
        $headers = $this->_sectPr->getElementsByTagName('headerReference');
        $counter = $headers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($headers->item($j));
        }
        $titlePage = $this->_sectPr->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $this->_sectPr->documentElement->removeChild($titlePage->item($j));
        }
        // remove the header references that may exist
        // within $this->_wordDocumentC
        $domDocument = $this->getDOMDocx();
        $headers = $domDocument->getElementsByTagName('headerReference');
        $counter = $headers->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $headers->item($j)->parentNode->removeChild($headers->item($j));
        }
        $titlePage = $domDocument->getElementsByTagName('titlePg');
        $counter = $titlePage->length - 1;
        for ($j = $counter; $j > -1; $j--) {
            $titlePage->item($j)->parentNode->removeChild($titlePage->item($j));
        }
        $this->_tempDocumentDOM = $domDocument;
        $this->restoreDocumentXML();

        // finally, if it exists, the evenAndOddHeader element from settings
        $this->removeSetting('w:evenAndOddHeaders');
    }

    /**
     * Removes headers and footers
     *
     */
    public function removeHeadersAndFooters()
    {
        $this->removeHeaders();
        $this->removeFooters();
    }

    /**
     * Changes the background color of the document
     *
     * @access public
     * @param string $color
     * Values: hexadecimal color value without # (ffff00, 0000ff, ...)
     */
    public function setBackgroundColor($color)
    {
        $this->_backgroundColor = $color;
        // construct the background WordML code
        if ($this->_background == '') {
            $this->_background = '<w:background w:color="' . $color . '" />';
            // modify the settings.xml file
            $this->docxSettings(array('displayBackgroundShape' => true));
        } else {
            $this->_background = str_replace('w:color="FFFFFF"', 'w:color="' . $color . '"', $this->_background);
        }
    }

    /**
     * Sets the compatility mode
     *
     * @access public
     * @param string $value 14, 15...
     */
    public function setCompatibilityMode($value)
    {
        $settings = array(
            'compat' => array(
                'compatibilityMode' => array('val' => $value)
            )
        );

        $this->docxSettings($settings);
    }

    /**
     * Changes the decimal symbol in the settings file
     *
     * @access public
     * @param string $symbol
     *  Values: '.', ',', ...
     */
    public function setDecimalSymbol($symbol)
    {
        $decimalNodes = $this->_wordSettingsT->getElementsByTagName('decimalSymbol');
        if ($decimalNodes->length > 0) {
            $decimalNode = $decimalNodes->item(0);
            $decimalNode->setAttribute('w:val', $symbol);
        }
        PhpdocxLogger::logger('Change decimal symbol.', 'info');
    }

    /**
     * Changes the default font
     *
     * @access public
     * @param string $font The new font
     *  Values: 'Arial', 'Times New Roman'...
     */
    public function setDefaultFont($font)
    {
        $this->_defaultFont = $font;
        // get the original theme as a DOMdocument
        $themeDocument = $this->getFromZip('word/theme/theme1.xml', 'DOMDocument');
        $latinNode = $themeDocument->getElementsByTagName('latin');
        $latinNode->item(0)->setAttribute('typeface', $font);
        $latinNode->item(1)->setAttribute('typeface', $font);
        $this->saveToZip($themeDocument, 'word/theme/theme1.xml');
        //To preserve the default font for PDF conversion make sure the $font is
        //defined in the fontTable.xml file
        $fontDocument = $this->getFromZip('word/fontTable.xml', 'DOMDocument');
        $fontXPath = new \DOMXPath($fontDocument);
        $fontXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $query = '//w:font[@w:name="' . $font . '"]';
        $fonts = $fontXPath->query($query);
        //If the font is not found append a w:font node to fontTable.xml
        if ($fonts->length == 0) {
            $newNode = $fontDocument->createElementNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'w:font');
            $newNode->setAttributeNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'w:name', $font);
            $fontDocument->documentElement->appendChild($newNode);
            $this->saveToZip($fontDocument, 'word/fontTable.xml');
        }
        PhpdocxLogger::logger('The default font was changed to ' . $font, 'info');
    }

    /**
     * Changes document default styles
     *
     * @access public
     * @param mixed $styleOptions it includes the required style options
     * Array values:
     * 'backgroundColor' (string) hexadecimal value (FFFF00, CCCCCC, ...)
     * 'bidi' (bool) if true sets right to left paragraph orientation
     * 'bold' (bool)
     * 'border' (none, single, double, dashed, threeDEngrave, threeDEmboss, outset, inset, ...)
     *      this value can be override for each side with 'borderTop', 'borderRight', 'borderBottom' and 'borderLeft'
     * 'borderColor' (ffffff, ff0000)
     *      this value can be override for each side with 'borderTopColor', 'borderRightColor', 'borderBottomColor' and 'borderLeftColor'
     * 'borderSpacing' (0, 1, 2...)
     *      this value can be override for each side with 'borderTopSpacing', 'borderRightSpacing', 'borderBottomSpacing' and 'borderLeftSpacing'
     * 'borderWidth' (10, 11...) in eights of a point
     *      this value can be override for each side with 'borderTopWidth', 'borderRightWidth', 'borderBottomWidth' and 'borderLeftWidth'
     * 'caps' (bool) display text in capital letters
     * 'color' (ffffff, ff0000...)
     * 'contextualSpacing' (bool) ignore spacing above and below when using identical styles
     * 'doubleStrikeThrough' (bool)
     * 'em' (none, dot, circle, comma, underDot) emphasis mark type
     * 'firstLineIndent' first line indent in twentieths of a point (twips)
     * 'font' (string|array) Arial, Times New Roman... array sets specific font attributes: ascii, hAnsi, eastAsia, cs
     * 'fontSize' (8, 9, 10, ...) size in points
     * 'hanging' 100, ...
     * 'indentLeft' 100, ...
     * 'indentRight' 100, ...
     * 'indentFirstLine' 100, ...
     * 'italic' (bool)
     * 'keepLines' (bool) keep all paragraph lines in the same page
     * 'keepNext' (bool) keep in the same page the current paragraph with next paragraph
     * 'lineSpacing' 120, 240 (standard), 360, 480, ...
     * 'outlineLvl' (int) heading level (1-9)
     * 'pageBreakBefore' (bool)
     * 'pStyle' id of the style this paragraph style is based on (it may be retrieved with the parseStyles method)
     * 'rtl' (bool) if true sets right to left text orientation
     * 'smallCaps' (bool) display text in small caps
     * 'spacingBottom' (int) bottom margin in twentieths of a point
     * 'spacingTop' (int) top margin in twentieths of a point
     * 'tabPositions' (array) each entry is an associative array with the following keys and values
     *      'type' (string) can be clear, left (default), center, right, decimal, bar and num
     *      'leader' (string) can be none (default), dot, hyphen, underscore, heavy and middleDot
     *      'position' (int) given in twentieths of a point
     * 'textAlign' (both, center, distribute, left, right)
     * 'textDirection' (lrTb, tbRl, btLr, lrTbV, tbRlV, tbLrV) text flow direction
     * 'underline' (none, dash, dotted, double, single, wave, words)
     * 'vanish' (bool)
     * 'widowControl' (bool)
     * 'wordWrap' (bool)
     */
    public function setDocumentDefaultStyles($styleOptions)
    {
        $styleOptions = self::translateTextOptions2StandardFormat($styleOptions);

        // get pPr and rPr styles through the paragraph styles class
        $newStyle = new CreateParagraphStyle();
        $style = $newStyle->addParagraphStyle('defaultstyles', $styleOptions);

        // get the pPr childNodes if exist
        $wordStylesPPr = $this->xmlUtilities->generateDomDocument($style[0]);
        $pPrStyleTags = $wordStylesPPr->getElementsByTagName('pPr');
        if ($pPrStyleTags->item(0) && $pPrStyleTags->item(0)->childNodes->length > 0) {
            $pPrDefaultStyles = $this->_wordStylesT->getElementsByTagName('pPrDefault');
            $pPrDefaultStylesPprChildren = $pPrDefaultStyles->item(0)->getElementsByTagName('pPr')->item(0);

            // iterate styles to be added to replace the existing styles and add the new ones
            foreach ($wordStylesPPr->firstChild->getElementsByTagName('pPr')->item(0)->childNodes as $wordStylesPPrChildNode) {
                $tagCurrentStyle = $pPrDefaultStylesPprChildren->getElementsByTagName($wordStylesPPrChildNode->localName);

                $nodeToBeImported = $pPrDefaultStylesPprChildren->ownerDocument->importNode($wordStylesPPrChildNode);

                if ($tagCurrentStyle->length > 0) {
                    // the style exists, replace it
                    $tagCurrentStyle->item(0)->parentNode->replaceChild($nodeToBeImported, $tagCurrentStyle->item(0));
                } else {
                    // the style is new, add it
                    $nodeToBeImported = $pPrDefaultStylesPprChildren->ownerDocument->importNode($wordStylesPPrChildNode);
                    $pPrDefaultStylesPprChildren->appendChild($nodeToBeImported);
                }
            }
        }
        $wordStylesRPr = $this->xmlUtilities->generateDomDocument($style[1]);
        $rPrStyleTags = $wordStylesRPr->getElementsByTagName('rPr');
        if ($rPrStyleTags->item(0) && $rPrStyleTags->item(0)->childNodes->length > 0) {
            $rPrDefaultStyles = $this->_wordStylesT->getElementsByTagName('rPrDefault');
            $rPrDefaultStylesRprChildren = $rPrDefaultStyles->item(0)->getElementsByTagName('rPr')->item(0);

            // iterate styles to be added to replace the existing styles and add the new ones
            foreach ($wordStylesRPr->firstChild->getElementsByTagName('rPr')->item(0)->childNodes as $wordStylesRPrChildNode) {
                $tagCurrentStyle = $rPrDefaultStylesRprChildren->getElementsByTagName($wordStylesRPrChildNode->localName);

                $nodeToBeImported = $rPrDefaultStylesRprChildren->ownerDocument->importNode($wordStylesRPrChildNode);

                if ($tagCurrentStyle->length > 0) {
                    // the style exists, replace it
                    $tagCurrentStyle->item(0)->parentNode->replaceChild($nodeToBeImported, $tagCurrentStyle->item(0));
                } else {
                    // the style is new, add it
                    $nodeToBeImported = $rPrDefaultStylesRprChildren->ownerDocument->importNode($wordStylesRPrChildNode);
                    $rPrDefaultStylesRprChildren->appendChild($nodeToBeImported);
                }
            }
        }
    }

    /**
     * Transforms to UTF-8 charset
     *
     * @access public
     */
    public function setEncodeUTF8()
    {
        self::$_encodeUTF = 1;
    }

    /**
     * Changes default language
     * @param $lang Locale: en-US, es-ES...
     * @access public
     */
    public function setLanguage($lang = null)
    {
        if (!$lang) {
            $lang = 'en-US';
        }
        // get the original styles as a DOMdocument
        $langNode = $this->_wordStylesT->getElementsByTagName('lang');
        if ($langNode->length > 0) {
            $langNode->item(0)->setAttribute('w:val', $lang);
            $langNode->item(0)->setAttribute('w:eastAsia', $lang);
        }
        // check also if tehre is a themeFontlanfg entry in the settings file
        $themeFontLangNode = $this->_wordSettingsT->getElementsByTagName('themeFontLang');
        if ($themeFontLangNode->length > 0) {
            $themeFontLangNode->item(0)->setAttribute('w:val', $lang);
        }

        PhpdocxLogger::logger('Set language: ' . $lang, 'info');
    }

    /**
     * Sets global right to left options
     *
     * @access public
     * @param array $options
     * values:
     *  'bidi' (bool)
     *  'rtl' (bool)
     */
    public function setRTL($options = array('bidi' => true, 'rtl' => true))
    {
        if (isset($options['bidi']) && $options['bidi']) {
            self::$bidi = true;
        } else if (isset($options['bidi']) && !$options['bidi']) {
            self::$bidi = false;
        }
        if (isset($options['rtl']) && $options['rtl']) {
            self::$rtl = true;
        } else if (isset($options['rtl']) && !$options['rtl']) {
            self::$rtl = false;
        }
        $this->modifyPageLayout('custom', array('bidi' => $options['bidi'], 'rtlGutter' => $options['rtl']));
        // set footnotes and endnotes separators for bidi and rtl
        $notesArray = array('footnote' => $this->_wordFootnotesT, 'endnote' => $this->_wordEndnotesT);
        foreach ($notesArray as $note => $value) {
            $noteXPath = new \DOMXPath($value);
            $noteXPath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $query = '//w:' . $note . '[@w:type="separator"] | //w:' . $note . '[@w:type="continuationSeparator"]';
            $selectedNodes = $noteXPath->query($query);
            foreach ($selectedNodes as $node) {
                $pPrNode = $node->getElementsbyTagName('pPr')->item(0);
                $bidiNodes = $node->getElementsbyTagName('bidi');
                if ($bidiNodes->length > 0) {
                    $bidiNodes->item(0)->setAttribute('w:val', $options['bidi']);
                } else {
                    $bidi = $pPrNode->ownerDocument->createElement('w:bidi');
                    $bidi->setAttribute('w:val', $options['bidi']);
                    $pPrNode->appendChild($bidi);
                }
                $rtlNodes = $node->getElementsbyTagName('rtl');
                if ($rtlNodes->length > 0) {
                    $rtlNodes->item(0)->setAttribute('w:val', $options['rtl']);
                } else {
                    $rtl = $pPrNode->ownerDocument->createElement('w:rtl');
                    $rtl->setAttribute('w:val', $options['rtl']);
                    $pPrNode->appendChild($rtl);
                }
            }
        }
    }

    /**
     * Sets global right to left options for the different methods
     *
     * @access public
     * @static
     * @param array $options
     * @return array
     */
    public static function setRTLOptions($options)
    {
        if (!isset($options['bidi']) && CreateDocx::$bidi) {
            $options['bidi'] = true;
        }
        if (!isset($options['rtl']) && CreateDocx::$rtl) {
            $options['rtl'] = true;
        }
        return $options;
    }

    /**
     * Translates chart option arrays to a predefined format
     *
     * @access public
     * @static
     * @param array $options
     * @return array
     */
    public static function translateChartOptions2StandardFormat($options)
    {
        foreach ($options as $key => $value) {
            $options[strtolower($key)] = $value;
        }
        if (isset($options['chartAlign'])) {
            $options['jc'] = $options['chartAlign'];
        }
        return $options;
    }

    /**
     * Translates table option arrays to a predefined format
     *
     * @access public
     * @static
     * @param array $options
     * @return array
     */
    public static function translateTableOptions2StandardFormat($options)
    {
        $options = OOXMLResources::translateTableOptions2StandardFormat($options);
        return $options;
    }

    /**
     * Translates table option arrays to a predefined format
     *
     * @access public
     * @static
     * @param array $options
     * @return array
     */
    public static function translateTextOptions2StandardFormat($options)
    {
        $options = OOXMLResources::translateTextOptions2StandardFormat($options);
        return $options;
    }

    /**
     * Creates image caption
     *
     * @access protected
     */
    protected function addImageCaption($isWordFragment, $data)
    {
        if (!isset($data['styleName'])) {
            $data['styleName'] = 'Caption';
        }
        $nameBookmark = '_GoBack';
        if (isset($data['bookmarkName'])) {
            $nameBookmark = $data['bookmarkName'];
        }

        // increment caption IDs not to repeat the same ID
        $styleNameCaption = $data['styleName'];
        if (isset(self::$captionsIds[$styleNameCaption])) {
            self::$captionsIds[$styleNameCaption]++;
        } else {
            self::$captionsIds[$styleNameCaption] = 1;
        }

        $caption =  CreateImageCaption::getInstance();
        $caption->initCaption($data);
        $caption->createCaption();
        $bookmarkStart = new WordFragment();
        $bookmarkStart->addBookmark(array('type' => 'start', 'name' => $nameBookmark));
        $bookmarkEnd = new WordFragment();
        $bookmarkEnd->addBookmark(array('type' => 'end', 'name' => $nameBookmark));

        if (!isset($data['align'])) {
            $data['align'] = 'left';
        }
        if (!isset($data['color'])) {
            $data['color'] = '1F497D';
        }
        if (isset($data['fontSize'])) {
            $data['sz'] = $data['fontSize'];
        }
        if (!isset($data['lineSpacing'])) {
            $data['lineSpacing'] = 240;
        }
        if (!isset($data['sz'])) {
            $data['sz'] = 18;
        }
        if (!isset($data['wrapTextInBookmarks'])) {
            $data['wrapTextInBookmarks'] = true;
        }

        $options = array(
            'color' => $data['color'],
            'lineSpacing' => $data['lineSpacing'],
            'jc' => $data['align'],
            'sz' => $data['sz'],
        );

        // check if the Caption style exists, create it otherwise
        $stylesXpath = new \DOMXPath($this->_wordStylesT);
        $stylesXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $queryStyle = '//w:style[@w:styleId="'.$data['styleName'].'"]';
        $styleCaption = $stylesXpath->query($queryStyle);
        if ($styleCaption->length == 0) {
            $this->createParagraphStyle($data['styleName'], $options);
        }

        if ($data['wrapTextInBookmarks']) {
            $caption = str_replace('</w:pPr>', '</w:pPr>' . (string) $bookmarkStart, (string) $caption);
            $caption = str_replace('__PHX=__GENERATESUBR__', (string) $bookmarkEnd, (string) $caption);
        } else {
            $caption = str_replace('</w:pPr>', '</w:pPr>' . (string) $bookmarkStart, (string) $caption);
            $caption = str_replace('</w:fldSimple>', '</w:fldSimple>' . (string) $bookmarkEnd, (string) $caption);
            $caption = str_replace('__PHX=__GENERATESUBR__', '', (string) $caption);
        }
        $contentElement = (string)$caption;

        if ($isWordFragment) {
            $this->wordML .= $contentElement;
        } else {
            $this->_wordDocumentC .= $contentElement;
        }
    }

    /**
     * Cleans template
     *
     * @access protected
     */
    protected function cleanTemplate()
    {
        PhpdocxLogger::logger('Remove existing template tags.', 'debug');
        $this->_wordDocumentT = preg_replace(
                '/__PHX=__[A-Z]+__/', '', $this->_wordDocumentT
        );
    }

    /**
     * Generates custom XML files if they don't exist
     *
     * @access protected
     */
    protected function generateCustomXMLFiles()
    {
        // check if the file has a customXML folder and the required files, otherwise create them
        $customXMLItemProps = $this->getFromZip('customXml/itemProps1.xml');
        if (!$customXMLItemProps) {
            $this->generateOVERRIDE('/customXml/itemProps1.xml', 'application/vnd.openxmlformats-officedocument.customXmlProperties+xml');

            $this->_zipDocx->addContent('customXml/itemProps1.xml', OOXMLResources::$item1PropsCustomXML);

            $customXMLItem1 = $this->getFromZip('customXml/item1.xml');
            if (!$customXMLItem1) {
                $this->_zipDocx->addContent('customXml/item1.xml', OOXMLResources::$item1CustomXML);
            }
            $customXMLItemRels = $this->getFromZip('customXml/_rels/item1.xml.rels');
            if (!$customXMLItemRels) {
                $this->_zipDocx->addContent('customXml/_rels/item1.xml.rels', OOXMLResources::$item1RelsCustomXML);
            }

            $this->generateRELATIONSHIP('rId' . rand(99999999, 999999999), 'customXml', '../customXml/item1.xml');

        }
    }

    /**
     * Generates a relationship entry for the custom properties XML file
     *
     * @access protected
     */
    protected function generateCUSTOMRELS()
    {
        // write the new Relationship node
        $strCustom = '<Relationship Id="rId' . self::uniqueNumberId(999, 9999) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties" Target="docProps/custom.xml" />';
        $tempNode = $this->relsRels->createDocumentFragment();
        $tempNode->appendXML($strCustom);
        $this->relsRels->documentElement->appendChild($tempNode);
    }

    /**
     * Generate DEFAULT
     *
     * @access protected
     */
    protected function generateDEFAULT($extension, $contentType)
    {
        $strContent = $this->_contentTypeT->saveXML();
        if (
            stripos($strContent, 'Extension="' . strtolower($extension) . '"') === false
        ) {
            $strContentTypes = '<Default Extension="' . $extension . '" ContentType="' . $contentType . '"> </Default>';
            $tempNode = $this->_contentTypeT->createDocumentFragment();
            $tempNode->appendXML($strContentTypes);
            $this->_contentTypeT->documentElement->appendChild($tempNode);
        }
    }

    /**
     * Generate OVERRIDE
     *
     * @access protected
     * @param string $partName
     * @param string $contentType
     */
    protected function generateOVERRIDE($partName, $contentType)
    {
        $strContent = $this->_contentTypeT->saveXML();
        if (
                strpos($strContent, 'PartName="' . $partName . '"') === false
        ) {
            $strContentTypes = '<Override PartName="' . $partName . '" ContentType="' . $contentType . '" />';
            $tempNode = $this->_contentTypeT->createDocumentFragment();
            $tempNode->appendXML($strContentTypes);
            $this->_contentTypeT->documentElement->appendChild($tempNode);
        }
    }

    /**
     * Generate RELATIONSHIP
     *
     * @access protected
     */
    protected function generateRELATIONSHIP()
    {
        $arrArgs = func_get_args();

        if ($arrArgs[1] == 'vbaProject') {
            $type = 'http://schemas.microsoft.com/office/2006/relationships/vbaProject';
        } else if ($arrArgs[1] == 'commentsExtended' || $arrArgs[1] == 'people') {
            $type = 'http://schemas.microsoft.com/office/2011/relationships/' . $arrArgs[1];
        } else if ($arrArgs[1] == 'chartEx') {
            $type = 'http://schemas.microsoft.com/office/2014/relationships/chartEx';
        } else {
            $type = 'http://schemas.openxmlformats.org/officeDocument/2006/' .
                    'relationships/' . $arrArgs[1];
        }

        if (!isset($arrArgs[3])) {
            $nodeWML = '<Relationship Id="' . $arrArgs[0] . '" Type="' . $type .
                    '" Target="' . $arrArgs[2] . '"></Relationship>';
        } else {
            $nodeWML = '<Relationship Id="' . $arrArgs[0] . '" Type="' . $type .
                    '" Target="' . $arrArgs[2] . '" ' . $arrArgs[3] .
                    '></Relationship>';
        }
        // check if there's a target with the same value to don't add the new relationship in this cases
        $domDocumentRels = $this->xmlUtilities->generateDomDocument($this->_wordRelsDocumentRelsT->saveXML());
        $domDocumentRelsXpath = new \DOMXPath($domDocumentRels);
        $domDocumentRelsXpath->registerNamespace('xmlns', 'http://schemas.openxmlformats.org/package/2006/relationships');
        $queryTarget = '//xmlns:Relationship[@Target="' . $arrArgs[2] . '"]';
        $elementsRelationshipTarget = $domDocumentRelsXpath->query($queryTarget);

        if ($elementsRelationshipTarget->length == 0) {
            $relsNode = $this->_wordRelsDocumentRelsT->createDocumentFragment();
            $relsNode->appendXML($nodeWML);
            $this->_wordRelsDocumentRelsT->documentElement->appendChild($relsNode);
        }
    }

    /**
     * Modify/create the rels files for footnotes, endnotes and comments
     * @param string $type can be footnote, endnote or comment
     * @access protected
     * @throws \Exception wrong note type
     */
    protected function generateRelsNotes($type)
    {
        if ($type == 'footnote') {
            $relsDOM = $this->_wordFootnotesRelsT;
        } else if ($type == 'endnote') {
            $relsDOM = $this->_wordEndnotesRelsT;
        } else if ($type == 'comment') {
            $relsDOM = $this->_wordCommentsRelsT;
        } else {
            $relsDOM = new \DOMDocument();
            PhpdocxLogger::logger('Wrong note type', 'fatal');
        }
        if (!empty(CreateDocx::$_relsNotesImage[$type])) {
            foreach (CreateDocx::$_relsNotesImage[$type] as $key => $value) {
                if (empty($value['name'])) {
                    $value['name'] = $value['rId'];
                }
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="media/img' . $value['name'] . '.' . $value['extension'] . '" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }
        if (!empty(CreateDocx::$_relsNotesExternalImage[$type])) {
            foreach (CreateDocx::$_relsNotesExternalImage[$type] as $key => $value) {
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="' . $value['url'] . '" TargetMode="External" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }
        if (!empty(CreateDocx::$_relsNotesLink[$type])) {
            foreach (CreateDocx::$_relsNotesLink[$type] as $key => $value) {
                $nodeWML = '<Relationship Id="' . $value['rId'] . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink" Target="' . $value['url'] . '" TargetMode="External" ></Relationship>';
                $relsNode = $relsDOM->createDocumentFragment();
                $relsNode->appendXML($nodeWML);
                $relsDOM->documentElement->appendChild($relsNode);
            }
        }

        if ($type == 'footnote') {
            $this->_wordFootnotesRelsT = $relsDOM;
        } else if ($type == 'endnote') {
            $this->_wordEndnotesRelsT = $relsDOM;
        } else if ($type == 'comment') {
            $this->_wordCommentsRelsT = $relsDOM;
        }
    }

    /**
     * Generate SECTPR
     *
     * @access protected
     * @param mixed $args Section style
     */
    protected function generateSECTPR($args = '')
    {
        $page = CreatePage::getInstance();
        $page->createSECTPR($args);
        $this->_wordDocumentC .= (string) $page;
    }

    /**
     * Generates an element in settings.xml
     *
     * @access protected
     * @throws \Exception incorrect setting tag
     */
    protected function generateSetting($tag)
    {
        if ((!in_array($tag, OOXMLResources::$settings))) {
            PhpdocxLogger::logger('Incorrect setting tag', 'fatal');
        }
        $settingIndex = array_search($tag, OOXMLResources::$settings);
        $selectedElements = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
        if ($selectedElements->length == 0) {
            $settingsElement = $this->_wordSettingsT->createDocumentFragment();
            $settingsElement->appendXML('<' . $tag . ' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />');
            $childNodes = $this->_wordSettingsT->documentElement->childNodes;
            $index = false;
            foreach ($childNodes as $node) {
                $index = array_search($node->nodeName, OOXMLResources::$settings);
                if ($index > $settingIndex) {
                    $node->parentNode->insertBefore($settingsElement, $node);
                    break;
                }
            }
            // in case no node was found (pretty unlikely) append the node
            if (!$index) {
                $this->_wordSettingsT->documentElement->appendChild($settingsElement);
            }
        }
    }

    /**
     * Generate WordDocument XML template
     *
     * @access protected
     */
    protected function generateTemplateWordDocument()
    {
        if (count(CreateDocx::$insertNameSpaces) > 0) {
            $strxmlns = '';
            foreach (CreateDocx::$insertNameSpaces as $key => $value) {
                $strxmlns .= $key . '="' . $value . '" ';
            }
            $this->_documentXMLElement = str_replace('<w:document', '<w:document ' . $strxmlns, $this->_documentXMLElement);
        }
        $this->_wordDocumentC .= $this->_sectPr->saveXML($this->_sectPr->documentElement);
        if (!empty($this->_wordHeaderC)) {
            $this->_wordDocumentC = str_replace(
                    '__PHX=__GENERATEHEADERREFERENCE__', '<' . CreateDocx::NAMESPACEWORD . ':headerReference ' .
                    CreateDocx::NAMESPACEWORD . ':type="default" r:id="rId' .
                    $this->_idWords['header'] . '"></' .
                    CreateDocx::NAMESPACEWORD . ':headerReference>', $this->_wordDocumentC
            );
        }
        if (!empty($this->_wordFooterC)) {
            $this->_wordDocumentC = str_replace(
                    '__PHX=__GENERATEFOOTERREFERENCE__', '<' . CreateDocx::NAMESPACEWORD . ':footerReference ' .
                    CreateDocx::NAMESPACEWORD . ':type="default" r:id="rId' .
                    $this->_idWords['footer'] . '"></' .
                    CreateDocx::NAMESPACEWORD . ':footerReference>', $this->_wordDocumentC
            );
        }
        $this->_wordDocumentT = $this->_documentXMLElement .
                $this->_background .
                '<' . CreateDocx::NAMESPACEWORD . ':body>' .
                $this->_wordDocumentC .
                '</' . CreateDocx::NAMESPACEWORD . ':body>' .
                '</' . CreateDocx::NAMESPACEWORD . ':document>';
        $this->cleanTemplate();
    }

    /**
     * Generates a TitlePg element in SectPr
     *
     * @access protected
     * @param bool $extraSections if true there is more than one section
     */
    protected function generateTitlePg($extraSections)
    {
        if ($extraSections) {
            $domDocument = $this->getDOMDocx();
            $sections = $domDocument->getElementsByTagName('sectPr');
            $firstSection = $sections->item(0);
            $foundNodes = $firstSection->getElementsByTagName('titlePg');
            if ($foundNodes->length == 0) {
                $newSectNode = '<w:titlePg xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />';
                $sectNode = $domDocument->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $firstSection->appendChild($sectNode);
            } else {
                $foundNodes->item(0)->setAttribute('val', 1);
            }
            $stringDoc = $domDocument->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        } else {

            $foundNodes = $this->_sectPr->documentElement->getElementsByTagName('titlePg');
            if ($foundNodes->length == 0) {
                $newSectNode = '<w:titlePg xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />';
                $sectNode = $this->_sectPr->createDocumentFragment();
                $sectNode->appendXML($newSectNode);
                $refNode = $this->_sectPr->documentElement->appendChild($sectNode);
            } else {
                $foundNodes->item(0)->setAttribute('val', 1);
            }
        }
    }

    /**
     * Extracts a file from the template docx zip and returns it as an string or a DOMDocument/SimpleXMLElement object
     *
     * @access protected
     * @param mixed $src the path of the file to be retrieved
     * @param string $type string, DOMDocument or SimpleXMLElement
     * @param mixed $zip
     * @return mixed
     * @throws \Exception not valid type
     */
    protected function getFromZip($src, $type = 'string', $zip = '')
    {
        if ($zip instanceof \ZipArchive) {
            $XMLData = $zip->getFromName($src);
        } else if ($zip instanceof DOCXStructure) {
            $XMLData = $zip->getContent($src);
        } else {
            $XMLData = $this->_zipDocx->getContent($src);
        }

        // return the data in the requested format
        if ($type == 'string') {
            return $XMLData;
        } else if ($type == 'DOMDocument') {
            if ($XMLData !== false) {
                $domDocument = $this->xmlUtilities->generateDomDocument($XMLData);
                return $domDocument;
            } else {
                return false;
            }
        } else if ($type == 'SimpleXMLElement') {
            if ($XMLData !== false) {
                $simpleXML = $this->xmlUtilities->generateSimpleXmlElement($XMLData);
            } else {
                return false;
            }
        } else {
            PhpdocxLogger::logger('getFromZip: The chosen type is not recognized', 'fatal');
        }
    }

    /**
     * Gets all section nodes present in the docx
     *
     * @access protected
     * @param mixed $sectionNumbers
     * @return array
     */
    protected function getSectionNodes($sectionNumbers)
    {
        $sectNodes = array();
        // get all sectPr sections that may exist
        // within $this->_wordDocumentC
        $this->_tempDocumentDOM = $this->getDOMDocx();
        $sections = $this->_tempDocumentDOM->getElementsByTagName('sectPr');
        foreach ($sections as $section) {
            $sectNodes[] = $section;
        }
        $sectNodes[] = $this->_sectPr->documentElement;

        $finalSectNodes = array();
        if (empty($sectionNumbers)) {
            $finalSectNodes = $sectNodes;
        } else {
            foreach ($sectionNumbers as $key => $value) {
                if (isset($sectNodes[$value - 1])) {
                    $finalSectNodes[] = $sectNodes[$value - 1];
                }
            }
        }
        return $finalSectNodes;
    }

    /**
     * Return a Word DOM content based on the target
     *
     * @access protected
     * @param string $target Target
     * @return array DOM
     */
    protected function getWordContentDOM($target = 'document')
    {
        if ($target == 'style') {
            $domDocument = $this->_wordStylesT;
        } elseif ($target == 'lastSection') {
            $domDocument = $this->_sectPr;
        } else {
            // document target
            $domDocument = $this->getDOMDocx();
        }

        $domXpath = new \DOMXPath($domDocument);
        $domXpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $domXpath->registerNamespace('wp', 'http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing');
        $domXpath->registerNamespace('a', 'http://schemas.openxmlformats.org/drawingml/2006/main');
        $domXpath->registerNamespace('c', 'http://schemas.openxmlformats.org/drawingml/2006/chart');
        $domXpath->registerNamespace('pic', 'http://schemas.openxmlformats.org/drawingml/2006/picture');
        $domXpath->registerNamespace('m', 'http://schemas.openxmlformats.org/officeDocument/2006/math');

        return array($domDocument, $domXpath);
    }

    /**
     * Modify the w:PageBorders sectPr property
     *
     * @access protected
     * @param \DOMNode $sectionNode
     * @param array $options
     */
    protected function modifyPageBordersSectionProperty($sectionNode, $options)
    {
        // restart condition available types
        $display_types = array('allPages', 'firstPage', 'notFirstPage');
        $offset_types = array('page', 'text');
        $sides = array('top', 'left', 'bottom', 'right');
        $type = array('width' => 4, 'color' => '000000', 'style' => 'single', 'space' => 24);

        if (isset($options['borderStyle'])) {
            if (!(isset($options['border_top_style']))) {
                $options['border_top_style'] = $options['borderStyle'];
            }
            if (!(isset($options['border_right_style']))) {
                $options['border_right_style'] = $options['borderStyle'];
            }
            if (!(isset($options['border_bottom_style']))) {
                $options['border_bottom_style'] = $options['borderStyle'];
            }
            if (!(isset($options['border_left_style']))) {
                $options['border_left_style'] = $options['borderStyle'];
            }
        }

        // set default values
        if (isset($options['zOrder'])) {
            $zOrder = $options['zOrder'];
        } else {
            $zOrder = 1000;
        }
        if (isset($options['display']) && in_array($options['display'], $display_types)) {
            $display = $options['display'];
        } else {
            $display = 'allPages';
        }
        if (isset($options['offsetFrom']) && in_array($options['offsetFrom'], $offset_types)) {
            $offsetFrom = $options['offsetFrom'];
        } else {
            $offsetFrom = 'page';
        }
        foreach ($type as $key => $value) {
            foreach ($sides as $side) {
                if (isset($options['border_' . $side . '_' . $key])) {
                    $opt['border_' . $side . '_' . $key] = $options['border_' . $side . '_' . $key];
                } else if (isset($options['border_' . $key])) {
                    $opt['border_' . $side . '_' . $key] = $options['border_' . $key];
                } else {
                    $opt['border_' . $side . '_' . $key] = $value;
                }
            }
        }

        // if there is any previous pgBorders tag remove it
        if ($sectionNode->getElementsByTagName('pgBorders')->length > 0) {
            $pgBorder = $sectionNode->getElementsByTagName('pgBorders')->item(0);
            $pgBorder->parentNode->removeChild($pgBorder);
        }
        // insert the requested page borders
        $pgBordersNode = $sectionNode->ownerDocument->createDocumentFragment();
        $strNode = '<w:pgBorders ';
        $strNode .= 'xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ';
        $strNode .= 'w:zOrder="' . $zOrder . '" w:display="' . $display . '" w:offsetFrom="' . $offsetFrom . '" >';
        foreach ($sides as $side) {
            $strNode .='<w:' . $side . ' w:val="' . $opt['border_' . $side . '_style'] . '" ';
            $strNode .= 'w:color="' . $opt['border_' . $side . '_color'] . '" ';
            $strNode .= 'w:sz="' . $opt['border_' . $side . '_width'] . '" ';
            $strNode .= 'w:space="' . $opt['border_' . $side . '_space'] . '" />';
        }
        $strNode .= '</w:pgBorders>';
        $pgBordersNode->appendXML($strNode);

        $propIndex = array_search('w:pgBorders', OOXMLResources::$sectionProperties);
        $childNodes = $sectionNode->childNodes;
        $index = false;
        foreach ($childNodes as $node) {
            $index = array_search($node->nodeName, OOXMLResources::$sectionProperties);
            if ($index > $propIndex) {
                $node->parentNode->insertBefore($pgBordersNode, $node);
                break;
            }
        }
        // in case no node was found we should append the node
        if (!$index) {
            $sectionNode->appendChild($pgBordersNode);
        }
    }

    /**
     * Modify a single sectPr property with no XML childs
     *
     * @access protected
     * @param \DOMNode $sectionNode
     * @param string $tag name of the property we want to modify
     * @param array $options the corresponding attribute values
     */
    protected function modifySingleSectionProperty($sectionNode, $tag, $options, $nameSpace = 'w')
    {
        if ($sectionNode->getElementsByTagName($tag)->length > 0) {
            // node exists
            $node = $sectionNode->getElementsByTagName($tag);
            foreach ($options as $key => $value) {
                $node->item(0)->setAttribute($nameSpace . ':' . $key, $value);
            }
        } else {
            // otherwise create it
            $newNode = $sectionNode->ownerDocument->createDocumentFragment();
            $strNode = '<' . $nameSpace . ':' . $tag . ' ';
            foreach ($options as $key => $value) {
                $strNode .= $nameSpace . ':' . $key . '="' . $value . '" ';
            }
            if ($nameSpace == 'w') {
                $strNode .=' xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" ';
            }
            $strNode .='/>';
            $newNode->appendXML($strNode);

            $propIndex = array_search($nameSpace . ':' . $tag, OOXMLResources::$sectionProperties);
            $childNodes = $sectionNode->childNodes;
            $index = false;
            foreach ($childNodes as $node) {
                $name = $node->nodeName;
                $index = array_search($node->nodeName, OOXMLResources::$sectionProperties);
                if ($index > $propIndex) {
                    $node->parentNode->insertBefore($newNode, $node);
                    break;
                }
            }
            // in case no node was found we should append the node
            if (!$index) {
                $sectionNode->appendChild($newNode);
            }
        }
    }

    /**
     * Parse path dir
     *
     * @access protected
     * @param string $dir Directory path
     */
    protected function parsePath($dir)
    {
        $slash = 0;
        $path = '';
        if (($slash = strrpos($dir, '/')) !== false) {
            $slash += 1;
            $path = substr($dir, 0, $slash);
        }
        $punto = strpos(substr($dir, $slash), '.');

        $nombre = substr($dir, $slash, $punto);
        $extension = substr($dir, $punto + $slash + 1);

        // if the extension has more than one dot, get the last one
        if (strpos($extension, '.')) {
            $dotsExtension = explode('.', $extension);
            $extension = $dotsExtension[count($dotsExtension)-1];
        }

        return array(
            'path' => $path, 'nombre' => $nombre, 'extension' => $extension
        );
    }

    /**
     * Parses a WordFragment to be inserted as a footnote or endnote
     *
     * @access protected
     * @param string $type it can be footnote, endnote or comment
     * @param WordFragment $wordFragment
     * @param array $markOptions the note mark options
     * @param array $referenceOptions the note reference options
     * @return string
     */
    protected function parseWordMLNote($type, $wordFragment, $markOptions = array(), $referenceOptions = array())
    {
        $referenceOptions = self::translateTextOptions2StandardFormat($referenceOptions);
        $referenceOptions = self::setRTLOptions($referenceOptions);

        $strFrag = (string) $wordFragment;
        $basePIni = '<w:p><w:pPr><w:pStyle w:val="' . $type . 'TextPHPDOCX"/>';
        if (isset($referenceOptions['bidi']) && $referenceOptions['bidi']) {
            $basePIni .= '<w:bidi />';
        }
        $basePIni .= '</w:pPr>';
        $run = '<w:r><w:rPr><w:rStyle w:val="' . $type . 'ReferencePHPDOCX"/>';
        // parse the referenceMark options
        if (isset($referenceOptions['font'])) {
            $run .= '<w:rFonts w:ascii="' . $referenceOptions['font'] .
                    '" w:hAnsi="' . $referenceOptions['font'] .
                    '" w:eastAsia="' . $referenceOptions['font'] .
                    '" w:cs="' . $referenceOptions['font'] . '"/>';
        }
        if (isset($referenceOptions['b'])) {
            $run .= '<w:b w:val="' . $referenceOptions['b'] . '"/>';
            $run .= '<w:bCs w:val="' . $referenceOptions['b'] . '"/>';
        }
        if (isset($referenceOptions['i'])) {
            $run .= '<w:i w:val="' . $referenceOptions['i'] . '"/>';
            $run .= '<w:iCs w:val="' . $referenceOptions['i'] . '"/>';
        }
        if (isset($referenceOptions['color'])) {
            $run .= '<w:color w:val="' . $referenceOptions['color'] . '"/>';
        }
        if (isset($referenceOptions['backgroundColor'])) {
            $run .= '<w:shd w:val="clear" w:fill="' . $referenceOptions['backgroundColor'] . '"/>';
        }
        if (isset($referenceOptions['highlightColor'])) {
            $run .= '<w:highlight w:val="' . $referenceOptions['highlightColor'] . '"/>';
        }
        if (isset($referenceOptions['u'])) {
            $run .= '<w:u w:val="' . $referenceOptions['u'] . '"/>';
        }
        if (isset($referenceOptions['sz'])) {
            $run .= '<w:sz w:val="' . (2 * $referenceOptions['sz']) . '"/>';
            $run .= '<w:szCs w:val="' . (2 * $referenceOptions['sz']) . '"/>';
        }
        if (isset($referenceOptions['rtl']) && $referenceOptions['rtl']) {
            $basePIni .= '<w:rtl />';
        }
        $run .= '</w:rPr>';
        if (isset($markOptions['customMark'])) {
            $run .= '<w:t>' . $markOptions['customMark'] . '</w:t>';
        } else {
            if ($type != 'comment') {
                $run .= '<w:' . $type . 'Ref/>';
            }
        }
        $run .= '</w:r>';
        $basePEnd = '</w:p>';
        // check if the WordFragment starts with a paragraph
        $startFrag = substr($strFrag, 0, 5);
        if ($startFrag == '<w:p>') {
            $strFrag = preg_replace('/<\/w:pPr>/', '</w:pPr>' . $run, $strFrag, 1);
        } else {
            $strFrag = $basePIni . $run . $basePEnd . $strFrag;
        }
        return $strFrag;
    }

    /**
     * Parses and clean a text string to be added
     *
     * @access protected
     * @param string $content
     * @return string
     */
    protected function parseAndCleanTextString($content)
    {
        $xmlUtilities = new XmlUtilities();
        $content = $xmlUtilities->parseAndCleanTextString($content);

        return $content;
    }

    /**
     * Regenerates a XML content based on its target after doing changes in it
     *
     * @access protected
     * @param string $target document (default), style, lastSection
     * @param \DOMDocument $domDocument DOM document
     */
    protected function regenerateXMLContent($target = 'document', $domDocument = null)
    {
        if ($target == 'style') {
            $styleXML = $this->_wordStylesT->saveXML();
            $this->_wordStylesT = $this->xmlUtilities->generateDomDocument($styleXML);
        } elseif ($target == 'lastSection') {
            $sectionXML = $this->_sectPr->saveXML();
            $this->_sectPr = $this->xmlUtilities->generateDomDocument($sectionXML);
        } elseif ($target == 'document') {
            $stringDoc = $domDocument->saveXML();
            $bodyTag = explode('<w:body>', $stringDoc);
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
            $this->_wordDocumentC = str_replace('<cursor>WordFragment</cursor>', '', $this->_wordDocumentC);
        }
    }

    /**
     * Remove a certain node in the document
     *
     * @access protected
     * @param \DOMDocument $domDocument
     * @param \DOMNode $refNode
     */
    protected function removeContentInDocument($domDocument, $refNode)
    {
        $refNodeXml = $domDocument->saveXML($refNode);
        $stringDoc = $domDocument->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        $pos = strpos($this->_wordDocumentC, $refNodeXml);

        if ($pos !== false) {
            $this->_wordDocumentC = substr_replace($this->_wordDocumentC, '', $pos, strlen($refNodeXml));
        }
    }

    /**
     * Removes an element from settings.xml
     *
     * @access protected
     */
    protected function removeSetting($tag)
    {
        $settingsHeader = $this->_wordSettingsT->documentElement->getElementsByTagName($tag);
        if ($settingsHeader->length > 0) {
            $this->_wordSettingsT->documentElement->removeChild($settingsHeader->item(0));
        }
    }

    /**
     * Recovers as a well formatted string the $_wordDocumentC variable
     *
     * @access protected
     */
    protected function restoreDocumentXML()
    {
        $stringDoc = $this->_tempDocumentDOM->saveXML();
        $bodyTag = explode('<w:body>', $stringDoc);
        if (isset($bodyTag[1])) {
            $this->_wordDocumentC = str_replace('</w:body></w:document>', '', $bodyTag[1]);
        }
    }

    /**
     * Inserts data in different format into the docx template zip
     *
     * @access protected
     * @param mixed $src it can be a string, a DOMDocument object or a SimpleXMLElement object
     * @param string $target path for the created file
     * @param mixed $zip
     * @return void|mixed
     * @throws \Exception error inserting a file in the ZIP
     */
    protected function saveToZip($src, $target, &$zip = '')
    {
        if (!is_object($src) && @is_file(str_replace(chr(0), '', $src))) {
            // insert file into the zip
            try {
                $inserted = $this->_zipDocx->addFile($target, $src);
                if ($inserted === false) {
                    throw new \Exception('Error while inserting the ' . $target . 'into the zip');
                }
            } catch (\Exception $e) {
                PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        } else {
            if (is_string($src)) {
                $XMLData = $src;
            } else if ($src instanceof \DOMDocument) {
                $XMLData = $src->saveXML();
            } else if ($src instanceof \SimpleXMLElement) {
                $XMLData = $src->asXML();
            } else {
                $XMLData = $src;
            }
            // insert the data into the zip
            try {
                $inserted = $this->_zipDocx->addContent($target, $XMLData);
                if ($inserted === false) {
                    throw new \Exception('Error while inserting the ' . $target . 'into the zip');
                }
            } catch (\Exception $e) {
                PhpdocxLogger::logger($e->getMessage(), 'fatal');
            }
        }
    }
}