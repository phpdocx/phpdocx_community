<?php
namespace Phpdocx\Resources;
/**
 * This class contains a series of static variables with useful OOXML structure info
 *
 * @category   Phpdocx
 * @package    Resources
 * @copyright  Copyright (c) Narcea Labs SL
 *             (https://www.narcealabs.com)
 * @license    phpdocx Community License
 * @link       https://www.phpdocx.com
 */
class OOXMLResources
{
    /**
     * @access public
     * @var string
     * @static
     */
    public static $commentsXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:comments mc:Ignorable="w14 w15 wp14" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape">
                                    </w:comments>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $commentsExtendedXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w15:commentsEx mc:Ignorable="w14 w15 wp14" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape">
                                    </w15:commentsEx>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $customProperties = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
                                        <Properties xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"
                                        xmlns="http://schemas.openxmlformats.org/officeDocument/2006/custom-properties">
                                        </Properties>';

    /**
     * @access public
     * @var array
     * @static
     */
    public static $defaultPHPDOCXStyles = array('Default Paragraph Font PHPDOCX', //This is the default paragraph font style used in multiple places
        'List Paragraph PHPDOCX', //This is the style used for the defolt ordered and unorderd lists
        'Title PHPDOCX', //This style is used by the addTitle method
        'Subtitle PHPDOCX', //This style is used by the addTitle method
        'Normal Table PHPDOCX', //This style is used for the basic table
        'Table Grid PHPDOCX', //This style is for basic tables and is also used to embed HTML tables with border="1"
        'footnote Text PHPDOCX', //This style is used for default footnotes
        'footnote text Car PHPDOCX', //The character style for footnotes
        'footnote Reference PHPDOCX', // The style for the footnote
        'endnote Text PHPDOCX', //This style is used for default endnotes
        'endnote text Car PHPDOCX', //The character style for endnotes
        'endnote Reference PHPDOCX', // The style for the endnote
        'annotation reference PHPDOCX', //styles for comments
        'annotation text PHPDOCX', //styles for comments
        'Comment Text Char PHPDOCX', //styles for comments
        'annotation subject PHPDOCX', //styles for comments
        'Comment Subject Char PHPDOCX', //styles for comments
        'Balloon Text PHPDOCX', //styles for comments
        'Balloon Text Char PHPDOCX'); //styles for comments
    /**
     * @access public
     * @var string
     * @static
     */
    public static $endnotesXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:endnotes xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                    xmlns:o="urn:schemas-microsoft-com:office:office"
                                    xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                    xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                    xmlns:v="urn:schemas-microsoft-com:vml"
                                    xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                    xmlns:w10="urn:schemas-microsoft-com:office:word"
                                    xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                    xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">
                                        <w:endnote w:type="separator" w:id="-1">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:separator/>
                                                </w:r>
                                            </w:p>
                                        </w:endnote>
                                        <w:endnote w:type="continuationSeparator" w:id="0">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:continuationSeparator/>
                                                </w:r>
                                            </w:p>
                                        </w:endnote>
                                    </w:endnotes>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $item1CustomXML = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <b:Sources SelectedStyle="\APA.XSL" StyleName="APA" xmlns="http://schemas.openxmlformats.org/officeDocument/2006/bibliography" xmlns:b="http://schemas.openxmlformats.org/officeDocument/2006/bibliography"/>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $item1PropsCustomXML = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
        <ds:datastoreItem ds:itemID="{BB324958-CBFB-4DB0-B37D-BF649D31B7BE}" xmlns:ds="http://schemas.openxmlformats.org/officeDocument/2006/customXml"><ds:schemaRefs><ds:schemaRef ds:uri="http://schemas.openxmlformats.org/officeDocument/2006/bibliography"/></ds:schemaRefs></ds:datastoreItem>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $item1RelsCustomXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
        <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Target="itemProps1.xml" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/customXmlProps"/></Relationships>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $notesXMLRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                                </Relationships>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $footnotesXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                    <w:footnotes xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006"
                                    xmlns:o="urn:schemas-microsoft-com:office:office"
                                    xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
                                    xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math"
                                    xmlns:v="urn:schemas-microsoft-com:vml"
                                    xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing"
                                    xmlns:w10="urn:schemas-microsoft-com:office:word"
                                    xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
                                    xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">
                                        <w:footnote w:type="separator" w:id="-1">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:separator/>
                                                </w:r>
                                            </w:p>
                                        </w:footnote>
                                        <w:footnote w:type="continuationSeparator" w:id="0">
                                            <w:p w:rsidR="006E0FDA" w:rsidRDefault="006E0FDA" w:rsidP="006E0FDA">
                                                <w:pPr>
                                                    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                                </w:pPr>
                                                <w:r>
                                                    <w:continuationSeparator/>
                                                </w:r>
                                            </w:p>
                                        </w:footnote>
                                    </w:footnotes>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $footersXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:ftr xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">%s</w:ftr>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $headersXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><w:hdr xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml">%s</w:hdr>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $newXMLContent = '<w:root xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mo="http://schemas.microsoft.com/office/mac/office/2008/main" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:mv="urn:schemas-microsoft-com:mac:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:w16="http://schemas.microsoft.com/office/word/2018/wordml" xmlns:w16cex="http://schemas.microsoft.com/office/word/2018/wordml/cex" xmlns:w16cid="http://schemas.microsoft.com/office/word/2016/wordml/cid" xmlns:w16du="http://schemas.microsoft.com/office/word/2023/wordml/word16du" xmlns:w16sdtdh="http://schemas.microsoft.com/office/word/2020/wordml/sdtdatahash" xmlns:w16se="http://schemas.microsoft.com/office/word/2015/wordml/symex" mc:Ignorable="w14 wp14 w15 w16se w16cid w16 w16cex w16sdtdh">%s</w:root>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $notesRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                                <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                                </Relationships>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $pageNumber = '<w:sdt><w:sdtPr><w:id w:val="__ID__PAGENUMBER__SDTPR__"/><w:docPartObj><w:docPartGallery w:val="Page Numbers (Bottom of Page)"/><w:docPartUnique/></w:docPartObj></w:sdtPr><w:sdtContent><w:sdt><w:sdtPr><w:id w:val="__ID__PAGENUMBER__SDTCONTENT__"/><w:docPartObj><w:docPartGallery w:val="Page Numbers (Top of Page)"/><w:docPartUnique/></w:docPartObj></w:sdtPr><w:sdtContent><w:p w:rsidR="00AB222B" w:rsidRDefault="00AB222B"><w:pPr><w:pStyle w:val="__PSTYLE__PAGENUMBER__PPR__"/><w:jc w:val="__JC__PAGENUMBER__PPR__"/></w:pPr><w:r><w:t xml:space="preserve">Page </w:t></w:r><w:r><w:fldChar w:fldCharType="begin"/></w:r><w:r><w:instrText xml:space="preserve">PAGE </w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r><w:t>1</w:t></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r><w:r><w:t xml:space="preserve"> of </w:t></w:r><w:r><w:fldChar w:fldCharType="begin"/></w:r><w:r><w:instrText xml:space="preserve">NUMPAGES  </w:instrText></w:r><w:r><w:fldChar w:fldCharType="separate"/></w:r><w:r><w:t>1</w:t></w:r><w:r><w:fldChar w:fldCharType="end"/></w:r></w:p></w:sdtContent></w:sdt></w:sdtContent></w:sdt>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $peopleXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w15:people mc:Ignorable="w14 w15 wp14" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape"></w15:people>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $PHPDOCXStyles = '<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:style w:type="character" w:styleId="DefaultParagraphFontPHPDOCX">
                                            <w:name w:val="Default Paragraph Font PHPDOCX"/>
                                            <w:uiPriority w:val="1"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="ListParagraphPHPDOCX">
                                            <w:name w:val="List Paragraph PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:uiPriority w:val="34"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:ind w:left="720"/>
                                                <w:contextualSpacing/>
                                            </w:pPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="TitlePHPDOCX">
                                            <w:name w:val="Title PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:next w:val="Normal"/>
                                            <w:link w:val="TitleCarPHPDOCX"/>
                                            <w:uiPriority w:val="10"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:pBdr>
                                                    <w:bottom w:val="single" w:sz="8" w:space="4" w:color="4F81BD" w:themeColor="accent1"/>
                                                </w:pBdr>
                                                <w:spacing w:after="300" w:line="240" w:lineRule="auto"/>
                                                <w:contextualSpacing/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:color w:val="17365D" w:themeColor="text2" w:themeShade="BF"/>
                                                <w:spacing w:val="5"/>
                                                <w:kern w:val="28"/>
                                                <w:sz w:val="52"/>
                                                <w:szCs w:val="52"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="TitleCarPHPDOCX">
                                            <w:name w:val="Title Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="TitlePHPDOCX"/>
                                            <w:uiPriority w:val="10"/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:color w:val="17365D" w:themeColor="text2" w:themeShade="BF"/>
                                                <w:spacing w:val="5"/>
                                                <w:kern w:val="28"/>
                                                <w:sz w:val="52"/>
                                                <w:szCs w:val="52"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="SubtitlePHPDOCX">
                                            <w:name w:val="Subtitle PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:next w:val="Normal"/>
                                            <w:link w:val="SubtitleCarPHPDOCX"/>
                                            <w:uiPriority w:val="11"/>
                                            <w:qFormat/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:pPr>
                                                <w:numPr>
                                                    <w:ilvl w:val="1"/>
                                                </w:numPr>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:i/>
                                                <w:iCs/>
                                                <w:color w:val="4F81BD" w:themeColor="accent1"/>
                                                <w:spacing w:val="15"/>
                                                <w:sz w:val="24"/>
                                                <w:szCs w:val="24"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="SubtitleCarPHPDOCX">
                                            <w:name w:val="Subtitle Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="SubtitlePHPDOCX"/>
                                            <w:uiPriority w:val="11"/>
                                            <w:rsid w:val="00DF064E"/>
                                            <w:rPr>
                                                <w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/>
                                                <w:i/>
                                                <w:iCs/>
                                                <w:color w:val="4F81BD" w:themeColor="accent1"/>
                                                <w:spacing w:val="15"/>
                                                <w:sz w:val="24"/>
                                                <w:szCs w:val="24"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="table" w:styleId="NormalTablePHPDOCX">
                                            <w:name w:val="Normal Table PHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:qFormat/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:tblPr>
                                                <w:tblInd w:w="0" w:type="dxa"/>
                                                <w:tblCellMar>
                                                    <w:top w:w="0" w:type="dxa"/>
                                                    <w:left w:w="108" w:type="dxa"/>
                                                    <w:bottom w:w="0" w:type="dxa"/>
                                                    <w:right w:w="108" w:type="dxa"/>
                                                </w:tblCellMar>
                                            </w:tblPr>
                                        </w:style>
                                        <w:style w:type="table" w:styleId="TableGridPHPDOCX">
                                            <w:name w:val="Table Grid PHPDOCX"/>
                                            <w:uiPriority w:val="59"/>
                                            <w:rsid w:val="00493A0C"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:tblPr>
                                                <w:tblInd w:w="0" w:type="dxa"/>
                                                <w:tblBorders>
                                                    <w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:insideH w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                    <w:insideV w:val="single" w:sz="4" w:space="0" w:color="auto"/>
                                                </w:tblBorders>
                                                <w:tblCellMar>
                                                    <w:top w:w="0" w:type="dxa"/>
                                                    <w:left w:w="108" w:type="dxa"/>
                                                    <w:bottom w:w="0" w:type="dxa"/>
                                                    <w:right w:w="108" w:type="dxa"/>
                                                </w:tblCellMar>
                                            </w:tblPr>
                                        </w:style>
                                        <w:style w:type="character" w:styleId="CommentReferencePHPDOCX">
                                            <w:name w:val="annotation reference PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:sz w:val="16"/>
                                                <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="CommentTextPHPDOCX">
                                            <w:name w:val="annotation text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="CommentTextCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:pPr>
                                                <w:spacing w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="CommentTextCharPHPDOCX">
                                            <w:name w:val="Comment Text Char PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="CommentTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="CommentSubjectPHPDOCX">
                                            <w:name w:val="annotation subject PHPDOCX"/>
                                            <w:basedOn w:val="CommentTextPHPDOCX"/>
                                            <w:next w:val="CommentTextPHPDOCX"/>
                                            <w:link w:val="CommentSubjectCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:b/>
                                                <w:bCs/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="CommentSubjectCharPHPDOCX">
                                            <w:name w:val="Comment Subject Char PHPDOCX"/>
                                            <w:basedOn w:val="CommentTextCharPHPDOCX"/>
                                            <w:link w:val="CommentSubjectPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:b/>
                                                <w:bCs/>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="BalloonTextPHPDOCX">
                                            <w:name w:val="Balloon Text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="BalloonTextCharPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Tahoma" w:hAnsi="Tahoma" w:cs="Tahoma"/>
                                                <w:sz w:val="16"/>
                                            <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="BalloonTextCharPHPDOCX">
                                            <w:name w:val="Balloon Text Char PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="BalloonTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="00E139EA"/>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Tahoma" w:hAnsi="Tahoma" w:cs="Tahoma"/>
                                                <w:sz w:val="16"/>
                                                <w:szCs w:val="16"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="paragraph" w:styleId="footnoteTextPHPDOCX">
                                            <w:name w:val="footnote Text PHPDOCX"/>
                                            <w:basedOn w:val="Normal"/>
                                            <w:link w:val="footnoteTextCarPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:unhideWhenUsed/>
                                            <w:rsid w:val="006E0FDA"/>
                                            <w:pPr>
                                                <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:customStyle="1" w:styleId="footnoteTextCarPHPDOCX">
                                            <w:name w:val="footnote Text Car PHPDOCX"/>
                                            <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                            <w:link w:val="footnoteTextPHPDOCX"/>
                                            <w:uiPriority w:val="99"/>
                                            <w:semiHidden/>
                                            <w:rsid w:val="006E0FDA"/>
                                            <w:rPr>
                                                <w:sz w:val="20"/>
                                                <w:szCs w:val="20"/>
                                            </w:rPr>
                                        </w:style>
                                        <w:style w:type="character" w:styleId="footnoteReferencePHPDOCX">
                                        <w:name w:val="footnote Reference PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:vertAlign w:val="superscript"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="paragraph" w:styleId="endnoteTextPHPDOCX">
                                        <w:name w:val="endnote Text PHPDOCX"/>
                                        <w:basedOn w:val="Normal"/>
                                        <w:link w:val="endnoteTextCarPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:pPr>
                                            <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
                                        </w:pPr>
                                        <w:rPr>
                                            <w:sz w:val="20"/>
                                            <w:szCs w:val="20"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="character" w:customStyle="1" w:styleId="endnoteTextCarPHPDOCX">
                                        <w:name w:val="endnote Text Car PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:link w:val="endnoteTextPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:sz w:val="20"/>
                                            <w:szCs w:val="20"/>
                                        </w:rPr>
                                    </w:style>
                                    <w:style w:type="character" w:styleId="endnoteReferencePHPDOCX">
                                        <w:name w:val="endnote Reference PHPDOCX"/>
                                        <w:basedOn w:val="DefaultParagraphFontPHPDOCX"/>
                                        <w:uiPriority w:val="99"/>
                                        <w:semiHidden/>
                                        <w:unhideWhenUsed/>
                                        <w:rsid w:val="006E0FDA"/>
                                        <w:rPr>
                                            <w:vertAlign w:val="superscript"/>
                                        </w:rPr>
                                    </w:style>
                                 </w:styles>';

    /**
     * @access public
     * @var array
     * @static
     */
    public static $PHPDOCXMSWORDDefaultStyles = array(
        'DefaultParagraphFont' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:default="1" w:styleId="DefaultParagraphFont"><w:name w:val="Default Paragraph Font"/><w:uiPriority w:val="1"/><w:semiHidden/><w:unhideWhenUsed/></w:style>',
        'CommentReference' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:styleId="CommentReference"><w:name w:val="annotation reference"/><w:basedOn w:val="DefaultParagraphFont"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:rPr><w:sz w:val="16"/><w:szCs w:val="16"/></w:rPr></w:style>',
        'CommentText' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="CommentText"><w:name w:val="annotation text"/><w:basedOn w:val="Normal"/><w:link w:val="CommentTextChar"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:line="240" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'CommentTextChar' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="CommentTextChar"><w:name w:val="Comment Text Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="CommentText"/><w:uiPriority w:val="99"/><w:semiHidden/><w:rsid w:val="00292E23"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'EndnoteText' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="EndnoteText"><w:name w:val="endnote text"/><w:basedOn w:val="Normal"/><w:link w:val="EndnoteTextChar"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'EndnoteTextChar' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="EndnoteTextChar"><w:name w:val="Endnote Text Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="EndnoteText"/><w:uiPriority w:val="99"/><w:semiHidden/><w:rsid w:val="00292E23"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'EndnoteReference' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:styleId="EndnoteReference"><w:name w:val="endnote reference"/><w:basedOn w:val="DefaultParagraphFont"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:rPr><w:vertAlign w:val="superscript"/></w:rPr></w:style>',
        'FootnoteText' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="FootnoteText"><w:name w:val="footnote text"/><w:basedOn w:val="Normal"/><w:link w:val="FootnoteTextChar"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/></w:pPr><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'FootnoteTextChar' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="FootnoteTextChar"><w:name w:val="Footnote Text Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="FootnoteText"/><w:uiPriority w:val="99"/><w:semiHidden/><w:rsid w:val="00292E23"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:style>',
        'FootnoteReference' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:styleId="FootnoteReference"><w:name w:val="footnote reference"/><w:basedOn w:val="DefaultParagraphFont"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:rPr><w:vertAlign w:val="superscript"/></w:rPr></w:style>',
        'Heading1' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading1Char"/><w:uiPriority w:val="9"/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="240" w:after="0"/><w:outlineLvl w:val="0"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style>',
        'Heading2' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading2Char"/><w:uiPriority w:val="9"/><w:unhideWhenUsed/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="40" w:after="0"/><w:outlineLvl w:val="1"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/><w:sz w:val="26"/><w:szCs w:val="26"/></w:rPr></w:style>',
        'Heading3' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading3"><w:name w:val="heading 3"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading3Char"/><w:uiPriority w:val="9"/><w:unhideWhenUsed/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="40" w:after="0"/><w:outlineLvl w:val="2"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="1F3763" w:themeColor="accent1" w:themeShade="7F"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:style>',
        'Heading4' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading4"><w:name w:val="heading 4"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading4Char"/><w:uiPriority w:val="9"/><w:unhideWhenUsed/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="40" w:after="0"/><w:outlineLvl w:val="3"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:i/><w:iCs/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/></w:rPr></w:style>',
        'Heading5' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading5"><w:name w:val="heading 5"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading5Char"/><w:uiPriority w:val="9"/><w:unhideWhenUsed/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="40" w:after="0"/><w:outlineLvl w:val="4"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/></w:rPr></w:style>',
        'Heading6' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Heading6"><w:name w:val="heading 6"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="Heading6Char"/><w:uiPriority w:val="9"/><w:unhideWhenUsed/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:keepNext/><w:keepLines/><w:spacing w:before="40" w:after="0"/><w:outlineLvl w:val="5"/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="1F3763" w:themeColor="accent1" w:themeShade="7F"/></w:rPr></w:style>',
        'Heading1Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading1Char"><w:name w:val="Heading 1 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading1"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/><w:sz w:val="32"/><w:szCs w:val="32"/></w:rPr></w:style>',
        'Heading2Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading2Char"><w:name w:val="Heading 2 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading2"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/><w:sz w:val="26"/><w:szCs w:val="26"/></w:rPr></w:style>',
        'Heading3Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading3Char"><w:name w:val="Heading 3 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading3"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="1F3763" w:themeColor="accent1" w:themeShade="7F"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:style>',
        'Heading4Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading4Char"><w:name w:val="Heading 4 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading4"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:i/><w:iCs/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/></w:rPr></w:style>',
        'Heading5Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading5Char"><w:name w:val="Heading 5 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading5"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="2F5496" w:themeColor="accent1" w:themeShade="BF"/></w:rPr></w:style>',
        'Heading6Char' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="Heading6Char"><w:name w:val="Heading 6 Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Heading6"/><w:uiPriority w:val="9"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:color w:val="1F3763" w:themeColor="accent1" w:themeShade="7F"/></w:rPr></w:style>',
        'Hyperlink' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:styleId="Hyperlink"><w:name w:val="Hyperlink"/><w:basedOn w:val="DefaultParagraphFont"/><w:uiPriority w:val="99"/><w:unhideWhenUsed/><w:rsid w:val="00292E23"/><w:rPr><w:color w:val="0563C1" w:themeColor="hyperlink"/><w:u w:val="single"/></w:rPr></w:style>',
        'NoList' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="numbering" w:default="1" w:styleId="NoList"><w:name w:val="No List"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/></w:style>',
        'NoSpacing' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="NoSpacing"><w:name w:val="No Spacing"/><w:uiPriority w:val="1"/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/></w:pPr></w:style>',
        'TableGrid' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="table" w:styleId="TableGrid"><w:name w:val="Table Grid"/><w:basedOn w:val="TableNormal"/><w:uiPriority w:val="39"/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/></w:pPr><w:tblPr><w:tblBorders><w:top w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:left w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:bottom w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:right w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:insideH w:val="single" w:sz="4" w:space="0" w:color="auto"/><w:insideV w:val="single" w:sz="4" w:space="0" w:color="auto"/></w:tblBorders></w:tblPr></w:style>',
        'TableNormal' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="table" w:default="1" w:styleId="TableNormal"><w:name w:val="Normal Table"/><w:uiPriority w:val="99"/><w:semiHidden/><w:unhideWhenUsed/><w:tblPr><w:tblInd w:w="0" w:type="dxa"/><w:tblCellMar><w:top w:w="0" w:type="dxa"/><w:left w:w="108" w:type="dxa"/><w:bottom w:w="0" w:type="dxa"/><w:right w:w="108" w:type="dxa"/></w:tblCellMar></w:tblPr></w:style>',
        'Title' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="TitleChar"/><w:uiPriority w:val="10"/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/><w:contextualSpacing/></w:pPr><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:spacing w:val="-10"/><w:kern w:val="28"/><w:sz w:val="56"/><w:szCs w:val="56"/></w:rPr></w:style>',
        'TitleChar' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="TitleChar"><w:name w:val="Title Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Title"/><w:uiPriority w:val="10"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:asciiTheme="majorHAnsi" w:eastAsiaTheme="majorEastAsia" w:hAnsiTheme="majorHAnsi" w:cstheme="majorBidi"/><w:spacing w:val="-10"/><w:kern w:val="28"/><w:sz w:val="56"/><w:szCs w:val="56"/></w:rPr></w:style>',
        'Subtitle' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="paragraph" w:styleId="Subtitle"><w:name w:val="Subtitle"/><w:basedOn w:val="Normal"/><w:next w:val="Normal"/><w:link w:val="SubtitleChar"/><w:uiPriority w:val="11"/><w:qFormat/><w:rsid w:val="00292E23"/><w:pPr><w:numPr><w:ilvl w:val="1"/></w:numPr></w:pPr><w:rPr><w:rFonts w:eastAsiaTheme="minorEastAsia"/><w:color w:val="5A5A5A" w:themeColor="text1" w:themeTint="A5"/><w:spacing w:val="15"/></w:rPr></w:style>',
        'SubtitleChar' => '<w:style xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" w:type="character" w:customStyle="1" w:styleId="SubtitleChar"><w:name w:val="Subtitle Char"/><w:basedOn w:val="DefaultParagraphFont"/><w:link w:val="Subtitle"/><w:uiPriority w:val="11"/><w:rsid w:val="00292E23"/><w:rPr><w:rFonts w:eastAsiaTheme="minorEastAsia"/><w:color w:val="5A5A5A" w:themeColor="text1" w:themeTint="A5"/><w:spacing w:val="15"/></w:rPr></w:style>',
    );

    /**
     * @access public
     * @var string
     * @static
     */
    public static $unorderedListStyle = '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:multiLevelType w:val="hybridMultilevel"/>
                                        <w:lvl w:ilvl="0" w:tplc="">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="720" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="1" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="1440" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="2" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2160" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="3" w:tplc="0C0A0001" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2880" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="4" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="3600" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="5" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="4320" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="6" w:tplc="0C0A0001" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5040" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Symbol" w:hAnsi="Symbol" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="7" w:tplc="0C0A0003" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val="o"/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5760" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Courier New" w:hAnsi="Courier New" w:cs="Courier New" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="8" w:tplc="0C0A0005" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="bullet"/>
                                            <w:lvlText w:val=""/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="6480" w:hanging="360"/>
                                            </w:pPr>
                                            <w:rPr>
                                                <w:rFonts w:ascii="Wingdings" w:hAnsi="Wingdings" w:hint="default"/>
                                            </w:rPr>
                                        </w:lvl>
                                    </w:abstractNum>';

    /**
     * @access public
     * @var string
     * @static
     */
    public static $orderedListStyle = '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" >
                                        <w:multiLevelType w:val="hybridMultilevel"/>
                                        <w:lvl w:ilvl="0" w:tplc="">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%1."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="720" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="1" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%2."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="1440" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="2" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%3."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="2160" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="3" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%4."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="2880" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="4" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%5."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="3600" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="5" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%6."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="4320" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="6" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="decimal"/>
                                            <w:lvlText w:val="%7."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5040" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="7" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerLetter"/>
                                            <w:lvlText w:val="%8."/>
                                            <w:lvlJc w:val="left"/>
                                            <w:pPr>
                                                <w:ind w:left="5760" w:hanging="360"/>
                                            </w:pPr>
                                        </w:lvl>
                                        <w:lvl w:ilvl="8" w:tplc="" w:tentative="1">
                                            <w:start w:val="1"/>
                                            <w:numFmt w:val="lowerRoman"/>
                                            <w:lvlText w:val="%9."/>
                                            <w:lvlJc w:val="right"/>
                                            <w:pPr>
                                                <w:ind w:left="6480" w:hanging="180"/>
                                            </w:pPr>
                                        </w:lvl>
                                    </w:abstractNum>';

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $paragraphProperties = array('w:pStyle',
        'w:keepNext',
        'w:keepLines',
        'w:pageBreakBefore',
        'w:framePr',
        'w:widowControl',
        'w:numPr',
        'w:suppressLineNumbers',
        'w:pBdr',
        'w:shd',
        'w:tabs',
        'w:suppressAutoHyphens',
        'w:kinsoku',
        'w:wordWrap',
        'w:overflowPunct',
        'w:topLinePunct',
        'w:autoSpaceDE',
        'w:autoSpaceDN',
        'w:bidi',
        'w:adjustRightInd',
        'w:snapToGrid',
        'w:spacing',
        'w:ind',
        'w:contextualSpacing',
        'w:mirrorIndents',
        'w:suppressOverlap',
        'w:jc',
        'w:textDirectio',
        'w:textAlignment',
        'w:textboxTightWrap',
        'w:outlineLvl',
        'w:divId',
        'w:cnfStyle',
        'w:rPr',
        'w:sectPr',
        'w:pPrChange'
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $runProperties = array('w:rStyle',
        'w:rFonts',
        'w:b',
        'w:bCs',
        'w:i',
        'w:iCs',
        'w:caps',
        'w:smallCaps',
        'w:strike',
        'w:dstrike',
        'w:outline',
        'w:shadow',
        'w:emboss',
        'w:imprint',
        'w:noProof',
        'w:snapToGrid',
        'w:vanish',
        'w:webHidden',
        'w:color',
        'w:spacin',
        'w:w',
        'w:kern',
        'w:position',
        'w:sz',
        'w:szCs',
        'w:highlight',
        'w:u',
        'w:effect',
        'w:bdr',
        'w:shd',
        'w:fitText',
        'w:vertAlign',
        'w:rtl',
        'w:cs',
        'w:em',
        'w:lang',
        'w:eastAsianLayout',
        'w:specVanish',
        'w:oMath'
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $sectionProperties = array('w:footnotePr',
        'w:endnotePr',
        'w:type',
        'w:pgSz',
        'w:pgMar',
        'w:paperSrc',
        'w:pgBorders',
        'w:lnNumType',
        'w:pgNumType',
        'w:cols',
        'w:formProt',
        'w:vAlign',
        'w:noEndnote',
        'w:titlePg',
        'w:textDirection',
        'w:bidi',
        'w:rtlGutter',
        'w:docGrid',
        'w:printerSettings',
        'w:sectPrChange'
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $pageLayoutPaperTypes = array(
        'A4',
        'A3',
        'letter',
        'legal',
        'A4-landscape',
        'A3-landscape',
        'letter-landscape',
        'legal-landscape',
        'custom',
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $pageLayoutOptions = array(
        'width',
        'height',
        'numberCols',
        'orient',
        'code',
        'marginTop',
        'marginRight',
        'marginBottom',
        'marginLeft',
        'marginHeader',
        'marginFooter',
        'gutter',
        'bidi',
        'rtlGutter'
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $pageLayoutReferenceSizes = array(
        'A4' => array(
            'width' => '11906',
            'height' => '16838',
            'numberCols' => '1',
            'orient' => 'portrait',
            'code' => '9',
            'marginTop' => '1417',
            'marginRight' => '1701',
            'marginBottom' => '1417',
            'marginLeft' => '1701',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'A4-landscape' => array(
            'width' => '16838',
            'height' => '11906',
            'numberCols' => '1',
            'orient' => 'landscape',
            'code' => '9',
            'marginTop' => '1701',
            'marginRight' => '1417',
            'marginBottom' => '1701',
            'marginLeft' => '1417',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'A3' => array(
            'width' => '16839',
            'height' => '23814',
            'numberCols' => '1',
            'orient' => 'portrait',
            'code' => '8',
            'marginTop' => '1417',
            'marginRight' => '1701',
            'marginBottom' => '1417',
            'marginLeft' => '1701',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'A3-landscape' => array(
            'width' => '23814',
            'height' => '16839',
            'numberCols' => '1',
            'orient' => 'landscape',
            'code' => '8',
            'marginTop' => '1701',
            'marginRight' => '1417',
            'marginBottom' => '1701',
            'marginLeft' => '1417',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'letter' => array(
            'width' => '12240',
            'height' => '15840',
            'numberCols' => '1',
            'orient' => 'portrait',
            'code' => '1',
            'marginTop' => '1417',
            'marginRight' => '1701',
            'marginBottom' => '1417',
            'marginLeft' => '1701',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'letter-landscape' => array(
            'width' => '15840',
            'height' => '12240',
            'numberCols' => '1',
            'orient' => 'landscape',
            'code' => '1',
            'marginTop' => '1701',
            'marginRight' => '1417',
            'marginBottom' => '1701',
            'marginLeft' => '1417',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'legal' => array(
            'width' => '12240',
            'height' => '20160',
            'numberCols' => '1',
            'orient' => 'portrait',
            'code' => '5',
            'marginTop' => '1417',
            'marginRight' => '1701',
            'marginBottom' => '1417',
            'marginLeft' => '1701',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
        'legal-landscape' => array(
            'width' => '20160',
            'height' => '12240',
            'numberCols' => '1',
            'orient' => 'landscape',
            'code' => '5',
            'marginTop' => '1701',
            'marginRight' => '1417',
            'marginBottom' => '1701',
            'marginLeft' => '1417',
            'marginHeader' => '708',
            'marginFooter' => '708',
            'gutter' => '0'
        ),
    );

    /**
     *
     * @access public
     * @static
     * @var array
     */
    public static $settings = array('w:writeProtection',
        'w:view',
        'w:zoom',
        'w:removePersonalInformation',
        'w:removeDateAndTime',
        'w:doNotDisplayPageBoundaries',
        'w:displayBackgroundShape',
        'w:printPostScriptOverText',
        'w:printFractionalCharacterWidth',
        'w:printFormsData',
        'w:embedTrueTypeFonts',
        'w:embedSystemFonts',
        'w:saveSubsetFonts',
        'w:saveFormsData',
        'w:mirrorMargins',
        'w:alignBordersAndEdges',
        'w:bordersDoNotSurroundHeader',
        'w:bordersDoNotSurroundFooter',
        'w:gutterAtTop',
        'w:hideSpellingErrors',
        'w:hideGrammaticalErrors',
        'w:activeWritingStyle',
        'w:proofState',
        'w:formsDesign',
        'w:attachedTemplate',
        'w:linkStyles',
        'w:stylePaneFormatFilter',
        'w:stylePaneSortMethod',
        'w:documentType',
        'w:mailMerge',
        'w:revisionView',
        'w:trackRevisions',
        'w:doNotTrackMoves',
        'w:doNotTrackFormatting',
        'w:documentProtection',
        'w:autoFormatOverride',
        'w:styleLockTheme',
        'w:styleLockQFSet',
        'w:defaultTabStop',
        'w:autoHyphenation',
        'w:consecutiveHyphenLimit',
        'w:hyphenationZone',
        'w:doNotHyphenateCaps',
        'w:showEnvelope',
        'w:summaryLength',
        'w:clickAndTypeStyle',
        'w:defaultTableStyle',
        'w:evenAndOddHeaders',
        'w:bookFoldRevPrinting',
        'w:bookFoldPrinting',
        'w:bookFoldPrintingSheets',
        'w:drawingGridHorizontalSpacing',
        'w:drawingGridVerticalSpacing',
        'w:displayHorizontalDrawingGridEvery',
        'w:displayVerticalDrawingGridEvery',
        'w:doNotUseMarginsForDrawingGridOrigin',
        'w:drawingGridHorizontalOrigin',
        'w:drawingGridVerticalOrigin',
        'w:doNotShadeFormData',
        'w:noPunctuationKerning',
        'w:characterSpacingControl',
        'w:printTwoOnOne',
        'w:strictFirstAndLastChars',
        'w:noLineBreaksAfter',
        'w:noLineBreaksBefore',
        'w:savePreviewPicture',
        'w:doNotValidateAgainstSchema',
        'w:saveInvalidXml',
        'w:ignoreMixedContent',
        'w:alwaysShowPlaceholderText',
        'w:doNotDemarcateInvalidXml',
        'w:saveXmlDataOnly',
        'w:useXSLTWhenSaving',
        'w:saveThroughXslt',
        'w:showXMLTags',
        'w:alwaysMergeEmptyNamespace',
        'w:updateFields',
        'w:hdrShapeDefaults',
        'w:footnotePr',
        'w:endnotePr',
        'w:compat',
        'w:docVars',
        'w:rsids',
        'm:mathPr',
        'w:uiCompat97To2003',
        'w:attachedSchema',
        'w:themeFontLang',
        'w:clrSchemeMapping',
        'w:doNotIncludeSubdocsInStats',
        'w:doNotAutoCompressPictures',
        'w:forceUpgrade',
        'w:captions',
        'w:readModeInkLockDown',
        'w:smartTagType',
        'sl:schemaLibrary',
        'w:shapeDefaults',
        'w:doNotEmbedSmartTags',
        'w:decimalSymbol',
        'w:listSeparator'
    );

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $wordListChunk = '<w:p><w:pPr><w:rPr><w:b/></w:rPr></w:pPr>
    <w:r><w:rPr><w:b/></w:rPr><w:t>SAMPLE CODE:</w:t></w:r>
    </w:p><w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
    <w:shd w:val="clear" w:color="auto" w:fill="DDD9C3"/>
    <w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid>
    <w:gridCol w:w="8644"/></w:tblGrid><w:tr><w:tc>
    <w:tcPr><w:tcW w:w="8644" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="DCDAC4"/>
    </w:tcPr><w:p><w:pPr><w:spacing w:before="200"/></w:pPr>
    <w:r><w:t>$</w:t></w:r><w:r>
    <w:t>myList</w:t></w:r><w:r>
    <w:t xml:space="preserve"> = array(\'item 1\', </w:t>
    </w:r><w:r>
    <w:br/>
    <w:t xml:space="preserve">                             </w:t>
    </w:r><w:r>
    <w:t xml:space="preserve">\'item 2\', </w:t>
    </w:r><w:r><w:br/>
    <w:t xml:space="preserve">                             </w:t>
    </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>subitem</w:t>
    </w:r><w:r>
    <w:t xml:space="preserve"> 2_1\', </w:t></w:r><w:r><w:br/>
    <w:t xml:space="preserve">                                        </w:t>
    </w:r><w:r><w:t>\'</w:t>
    </w:r><w:r><w:t>subitem</w:t></w:r><w:r>
    <w:t xml:space="preserve"> 2_2\'), </w:t></w:r><w:r><w:br/>
    <w:t xml:space="preserve">                             </w:t>
    </w:r><w:r><w:t xml:space="preserve">\'item 3\', </w:t></w:r>
    <w:r><w:br/>
    <w:t xml:space="preserve">                             </w:t>
    </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>subitem</w:t>
    </w:r><w:r><w:t xml:space="preserve"> 3_1\', </w:t></w:r>
    <w:r><w:br/>
    <w:t xml:space="preserve">                                        </w:t>
    </w:r><w:r><w:t>\'</w:t></w:r><w:r><w:t>subitem</w:t></w:r>
    <w:r><w:t xml:space="preserve"> 3_2\', </w:t></w:r><w:r><w:br/>
    <w:t xml:space="preserve">                                        </w:t>
    </w:r><w:r><w:t>array(\'</w:t></w:r><w:r><w:t>sub_subitem</w:t></w:r><w:r>
    <w:t xml:space="preserve"> 3_2_1\', </w:t></w:r><w:r><w:br/>
    <w:t xml:space="preserve">                                                   </w:t>
    </w:r><w:r><w:t>\'</w:t></w:r><w:r><w:t>sub_subitem</w:t></w:r><w:r>
    <w:t xml:space="preserve"> 3_2_1\')),</w:t></w:r><w:r><w:br/>
    <w:t xml:space="preserve">                             </w:t>
    </w:r><w:r><w:t xml:space="preserve"> \'item 4\');</w:t></w:r></w:p>
    <w:p><w:pPr><w:spacing w:before="200"/></w:pPr>
    <w:r><w:t>addList</w:t></w:r><w:r><w:t>($</w:t></w:r>
    <w:r><w:t>myList</w:t></w:r><w:r><w:t>, NUMID</w:t></w:r>
    <w:r><w:t>))</w:t></w:r></w:p></w:tc></w:tr></w:tbl><w:p><w:pPr></w:pPr>
    </w:p>
    <w:p><w:pPr><w:rPr><w:b/></w:rPr></w:pPr>
    <w:r><w:rPr><w:b/></w:rPr><w:t>SAMPLE RESULT:</w:t></w:r>
    </w:p>';

    /**
     *
     * @access public
     * @static
     * @var string
     */
    public static $wordMLChunk = '<w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
    </w:tblPr><w:tblGrid><w:gridCol w:w="4322"/><w:gridCol w:w="4322"/>
    </w:tblGrid><w:tr><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="BD1503"/>
    </w:tcPr><w:p><w:pPr><w:spacing w:after="0"/><w:rPr>
    <w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r><w:rPr>
    <w:color w:val="FFFFFF"/></w:rPr><w:t>NAME:</w:t></w:r></w:p>
    </w:tc><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="BD1503"/></w:tcPr>
    <w:p><w:pPr><w:spacing w:after="0"/><w:rPr><w:color w:val="FFFFFF"/>
    </w:rPr></w:pPr><w:r><w:rPr><w:color w:val="FFFFFF"/>
    </w:rPr><w:t>' . '%s' . '</w:t></w:r></w:p></w:tc>
    </w:tr><w:tr><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Type</w:t>
    </w:r><w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr>
    <w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>' . '%s' . '</w:t></w:r></w:p></w:tc></w:tr>
    <w:tr><w:tc><w:tcPr>
    <w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>ID:</w:t></w:r></w:p></w:tc><w:tc>
    <w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>' . '%s' . '</w:t></w:r></w:p></w:tc></w:tr><w:tr><w:tc><w:tcPr>
    <w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/></w:tcPr>
    <w:p><w:pPr><w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Default:</w:t></w:r>
    </w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr>
    <w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>' . '%s' . '</w:t></w:r></w:p></w:tc></w:tr><w:tr>
    <w:tc><w:tcPr><w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr>
    <w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>Custom</w:t>
    </w:r><w:r><w:rPr><w:color w:val="FFFFFF"/></w:rPr>
    <w:t>:</w:t></w:r></w:p></w:tc><w:tc><w:tcPr>
    <w:tcW w:w="4322" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="3E3E42"/>
    </w:tcPr><w:p><w:pPr>
    <w:spacing w:after="0" w:line="240" w:lineRule="auto"/>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr></w:pPr><w:r>
    <w:rPr><w:color w:val="FFFFFF"/></w:rPr><w:t>' . '%s' . '</w:t>
    </w:r></w:p></w:tc></w:tr></w:tbl>
    <w:p w:rsidR="000F6147" w:rsidRDefault="000F6147" w:rsidP="00B42E7D">
    <w:pPr><w:spacing w:after="0"/></w:pPr></w:p>
    <w:p w:rsidR="00DC3ACE" w:rsidRDefault="00DC3ACE">
    <w:pPr><w:rPr><w:b/></w:rPr></w:pPr><w:r>
    <w:rPr><w:b/></w:rPr><w:t>SAMPLE CODE:</w:t></w:r></w:p>
    <w:tbl><w:tblPr><w:tblW w:w="0" w:type="auto"/>
    <w:shd w:val="clear" w:color="auto" w:fill="DDD9C3"/>
    </w:tblPr><w:tblGrid><w:gridCol w:w="8644"/>
    </w:tblGrid><w:tr><w:tc><w:tcPr><w:tcW w:w="8644" w:type="dxa"/>
    <w:shd w:val="clear" w:color="auto" w:fill="DCDAC4"/></w:tcPr>
    <w:p w:rsidR="00DC3ACE" w:rsidRDefault="00DC3ACE">
    <w:pPr><w:spacing w:before="200" /></w:pPr><w:r>
    <w:t>CODEX</w:t></w:r></w:p></w:tc></w:tr></w:tbl><w:p/><w:p>
    <w:pPr><w:rPr><w:b/></w:rPr></w:pPr><w:r><w:rPr><w:b/>
    </w:rPr><w:t>SAMPLE RESULT:</w:t></w:r></w:p>
    ';

    /**
     * Class constructor
     */
    public function __construct()
    {

    }

    /**
     * Class destructor
     */
    public function __destruct()
    {

    }

    /**
     * @access public
     * @static
     * @param int $integer
     * @param bool $uppercase
     * @return string
     */
    public static function integer2Letter($integer, $uppercase = false)
    {
        $letter = '';
        $integer = $integer - 1;
        $letter = chr(($integer % 26) + 97);
        $letter .= (floor($integer / 26) > 0) ? str_repeat($letter, (int)floor($integer / 26)) : '';
        if ($uppercase) {
            $letter = strtoupper($letter);
        }
        return $letter;
    }

    /**
     * @access public
     * @static
     * @param int $integer
     * @param bool $uppercase
     * @return string
     */
    public static function integer2RomanNumeral($integer, $uppercase = false)
    {
        $roman = '';
        $baseTransform = array('m' => 1000,
            'cm' => 900,
            'd' => 500,
            'cd' => 400,
            'c' => 100,
            'xc' => 90,
            'l' => 50,
            'xl' => 40,
            'x' => 10,
            'ix' => 9,
            'v' => 5,
            'iv' => 4,
            'i' => 1);
        foreach ($baseTransform as $key => $value) {
            $result = floor($integer / $value);
            $roman .= str_repeat($key, (int)$result);
            $integer = $integer % $value;
        }
        if ($uppercase) {
            $roman = strtoupper($roman);
        }
        return $roman;
    }

    /**
     * @access public
     * @param \DOMNode $targetNode this is the node where we want to insert the new child
     * @param \DOMNode $sourceNode the child to be inserted
     * @param array $XMLSequence the sequence of childs given by the corresponding Schema for the target node
     * @param $type it can be ignore (if the node already exists jus leave silently, default value) or replace to overwrite the current node
     * @static
     */
    public static function insertNodeIntoSequence($targetNode, $sourceNode, $XMLSequence, $type = 'ignore')
    {
        //make sure that the $newNode belongs to the same DOM document as the $targetNode
        $newNode = $targetNode->ownerDocument->importNode($sourceNode, true);
        $nodeName = $newNode->nodeName;
        if ($nodeName == '#document-fragment') {
            $baseString = $newNode->ownerDocument->saveXML($newNode);
            $fragArray = explode(' ', $baseString);
            $nodeName = trim(str_replace('<', '', $fragArray[0]));
        }
        $sequenceIndex = array_search($nodeName, $XMLSequence);
        if (empty($sequenceIndex)) {
            //PhpdocxLogger::logger('The new node does not belong to the  given XML sequence', 'fatal');
        }
        $childNodes = $targetNode->childNodes;
        $append = true;
        foreach ($childNodes as $node) {
            $name = $node->nodeName;
            $index = array_search($node->nodeName, $XMLSequence);
            if ($index == $sequenceIndex) {
                if ($type == 'ignore') {
                    $append = false;
                    break;
                } else {
                    $node->parentNode->insertBefore($newNode, $node);
                    $node->parentNode->removeChild($node);
                    $append = false;
                    break;
                }
            } else if ($index > $sequenceIndex) {
                $node->parentNode->insertBefore($newNode, $node);
                $append = false;
                break;
            }
        }
        //in case no node was found we should append the node
        if ($append) {
            $targetNode->appendChild($newNode);
        }
    }

    /**
     * The child elements of the second node are added to the first node. If overwrite is set to true coincident nodes
     * will be overwritten
     * @access public
     * @param \DOMNode $firstNode
     * @param \DOMNode $secondNode
     * @param array $XMLSequence the sequence of childs given by the corresponding Schema for the given nodes
     * @param mixed $overwrite can take the values:
     * ignore (if the node already exists jus leave silently, default value) or replace to overwrite the current node
     * @param array $exceptions exceptions to teh overwrite rule
     * @static
     */
    public static function mergeXMLNodes($firstNode, $secondNode, $XMLSequence, $overwrite = false, $exceptions = array())
    {
        $childs = $secondNode->childNodes;
        foreach ($childs as $child) {
            $name = $child->nodeName;
            if ($overwrite) {
                if (!in_array($name, $exceptions)) {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence, $type = 'replace');
                } else {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence);
                }
            } else {
                if (!in_array($name, $exceptions)) {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence);
                } else {
                    OOXMLResources::insertNodeIntoSequence($firstNode, $child, $XMLSequence, $type = 'replace');
                }
            }
        }
    }

    /**
     * Translate table option arrays to a predefined format
     * @param array $options
     * @access public
     * @static
     * @return array
     */
    public static function translateTableOptions2StandardFormat($options)
    {
        // general border options
        if (isset($options['borderColor'])) {
            $options['border_color'] = $options['borderColor'];
        }
        if (isset($options['borderSpacing'])) {
            $options['border_spacing'] = $options['borderSpacing'];
        }
        if (isset($options['borderWidth'])) {
            $options['border_sz'] = $options['borderWidth'];
            $options['border_width'] = $options['borderWidth'];
        }
        if (isset($options['borderSettings'])) {
            $options['border_settings'] = $options['borderSettings'];
        }
        // individual side options
        if (isset($options['borderTop'])) {
            $options['border_top'] = $options['borderTop'];
            $options['border_top_style'] = $options['borderTop'];
        }
        if (isset($options['borderRight'])) {
            $options['border_right'] = $options['borderRight'];
            $options['border_right_style'] = $options['borderRight'];
        }
        if (isset($options['borderBottom'])) {
            $options['border_bottom'] = $options['borderBottom'];
            $options['border_bottom_style'] = $options['borderBottom'];
        }
        if (isset($options['borderLeft'])) {
            $options['border_left'] = $options['borderLeft'];
            $options['border_left_style'] = $options['borderLeft'];
        }
        if (isset($options['borderTopWidth'])) {
            $options['border_top_sz'] = $options['borderTopWidth'];
            $options['border_top_width'] = $options['borderTopWidth'];
        }
        if (isset($options['borderRightWidth'])) {
            $options['border_right_sz'] = $options['borderRightWidth'];
            $options['border_right_width'] = $options['borderRightWidth'];
        }
        if (isset($options['borderBottomWidth'])) {
            $options['border_bottom_sz'] = $options['borderBottomWidth'];
            $options['border_bottom_width'] = $options['borderBottomWidth'];
        }
        if (isset($options['borderLeftWidth'])) {
            $options['border_left_sz'] = $options['borderLeftWidth'];
            $options['border_left_width'] = $options['borderLeftWidth'];
        }
        if (isset($options['borderTopColor'])) {
            $options['border_top_color'] = $options['borderTopColor'];
        }
        if (isset($options['borderRightColor'])) {
            $options['border_right_color'] = $options['borderRightColor'];
        }
        if (isset($options['borderBottomColor'])) {
            $options['border_bottom_color'] = $options['borderBottomColor'];
        }
        if (isset($options['borderLeftColor'])) {
            $options['border_left_color'] = $options['borderLeftColor'];
        }
        if (isset($options['borderTopSpacing'])) {
            $options['border_top_spacing'] = $options['borderTopSpacing'];
        }
        if (isset($options['borderRightSpacing'])) {
            $options['border_right_spacing'] = $options['borderRightSpacing'];
        }
        if (isset($options['borderBottomSpacing'])) {
            $options['border_bottom_spacing'] = $options['borderBottomSpacing'];
        }
        if (isset($options['borderLeftSpacing'])) {
            $options['border_left_spacing'] = $options['borderLeftSpacing'];
        }
        // column sizes
        if (isset($options['columnWidths'])) {
            $options['size_col'] = $options['columnWidths'];
        }
        // text margins
        if (isset($options['float']['tableMarginTop'])) {
            $options['float']['textMargin_top'] = $options['float']['tableMarginTop'];
        }
        if (isset($options['float']['tableMarginRight'])) {
            $options['float']['textMargin_right'] = $options['float']['tableMarginRight'];
        }
        if (isset($options['float']['tableMarginBottom'])) {
            $options['float']['textMargin_bottom'] = $options['float']['tableMarginBottom'];
        }
        if (isset($options['float']['tableMarginLeft'])) {
            $options['float']['textMargin_left'] = $options['float']['tableMarginLeft'];
        }
        // styles
        if (isset($options['tableAlign'])) {
            $options['jc'] = $options['tableAlign'];
        }
        if (isset($options['tableStyle'])) {
            $options['TBLSTYLEval'] = $options['tableStyle'];
        }
        if (isset($options['backgroundColor'])) {
            $options['background_color'] = $options['backgroundColor'];
        }
        return $options;
    }

    /**
     * Translate table option arrays to a predefined format
     * @param array $options
     * @access public
     * @static
     * @return array
     */
    public static function translateTextOptions2StandardFormat($options)
    {
        if (is_array($options)) {
            // general border options
            if (isset($options['border']) && $options['border'] == 'none') {
                $options['border'] = 'nil';
            }
            if (isset($options['borderColor'])) {
                $options['border_color'] = $options['borderColor'];
            }
            if (isset($options['borderSpacing'])) {
                $options['border_spacing'] = $options['borderSpacing'];
            }
            if (isset($options['borderWidth'])) {
                $options['border_sz'] = $options['borderWidth'];
            }
            if (isset($options['borderSettings'])) {
                $options['border_settings'] = $options['borderSettings'];
            }
            // individual side options
            if (isset($options['borderTop'])) {
                $options['border_top'] = $options['borderTop'];
                $options['border_top_style'] = $options['borderTop'];
            }
            if (isset($options['borderRight'])) {
                $options['border_right'] = $options['borderRight'];
                $options['border_right_style'] = $options['borderRight'];
            }
            if (isset($options['borderBottom'])) {
                $options['border_bottom'] = $options['borderBottom'];
                $options['border_bottom_style'] = $options['borderBottom'];
            }
            if (isset($options['borderLeft'])) {
                $options['border_left'] = $options['borderLeft'];
                $options['border_left_style'] = $options['borderLeft'];
            }
            if (isset($options['borderTopWidth'])) {
                $options['border_top_sz'] = $options['borderTopWidth'];
            }
            if (isset($options['borderRightWidth'])) {
                $options['border_right_sz'] = $options['borderRightWidth'];
            }
            if (isset($options['borderBottomWidth'])) {
                $options['border_bottom_sz'] = $options['borderBottomWidth'];
            }
            if (isset($options['borderLeftWidth'])) {
                $options['border_left_sz'] = $options['borderLeftWidth'];
            }
            if (isset($options['borderTopColor'])) {
                $options['border_top_color'] = $options['borderTopColor'];
            }
            if (isset($options['borderRightColor'])) {
                $options['border_right_color'] = $options['borderRightColor'];
            }
            if (isset($options['borderBottomColor'])) {
                $options['border_bottom_color'] = $options['borderBottomColor'];
            }
            if (isset($options['borderLeftColor'])) {
                $options['border_left_color'] = $options['borderLeftColor'];
            }
            if (isset($options['borderTopSpacing'])) {
                $options['border_top_spacing'] = $options['borderTopSpacing'];
            }
            if (isset($options['borderRightSpacing'])) {
                $options['border_right_spacing'] = $options['borderRightSpacing'];
            }
            if (isset($options['borderBottomSpacing'])) {
                $options['border_bottom_spacing'] = $options['borderBottomSpacing'];
            }
            if (isset($options['borderLeftSpacing'])) {
                $options['border_left_spacing'] = $options['borderLeftSpacing'];
            }
            // reassigned variables
            if (isset($options['indentLeft'])) {
                $options['indent_left'] = $options['indentLeft'];
            }
            if (isset($options['indentRight'])) {
                $options['indent_right'] = $options['indentRight'];
            }
            if (!empty($options['bold']) && $options['bold'] !== 'off') {
                $options['b'] = 'on';
            } else if (isset($options['bold']) && $options['bold'] === false) {
                $options['b'] = 'off';
            }
            if (!empty($options['italic']) && $options['italic'] !== 'off') {
                $options['i'] = 'on';
            } else if (isset($options['italic']) &&  $options['italic'] === false) {
                $options['i'] = 'off';
            }

            if (!empty($options['lineSpacing'])) {
                //$options['lineSpacing'] = ceil($options['lineSpacing'] * 240);
            }

            if (isset($options['fontSize'])) {
                $options['sz'] = $options['fontSize'];
            }
            if (isset($options['underline'])) {
                $options['u'] = $options['underline'];
            }
            if (isset($options['textAlign'])) {
                $options['jc'] = $options['textAlign'];
            }
            // translate to boolean
            if (!empty($options['bidi']) && $options['bidi'] !== 'off') {
                $options['bidi'] = 'on';
            } else if (isset($options['bidi']) && $options['bidi'] === false) {
                $options['bidi'] = 'off';
            }
            if (!empty($options['caps']) && $options['caps'] !== 'off') {
                $options['caps'] = 'on';
            } else if (isset($options['caps']) && $options['caps'] === false) {
                $options['caps'] = 'off';
            }
            if (!empty($options['keepLines']) && $options['keepLines'] !== 'off') {
                $options['keepLines'] = 'on';
            } else if (isset($options['keepLines']) && $options['keepLines'] === false) {
                $options['keepLines'] = 'off';
            }
            if (!empty($options['keepNext']) && $options['keepNext'] !== 'off') {
                $options['keepNext'] = 'on';
            } else if (isset($options['keepNext']) && $options['keepNext'] === false) {
                $options['keepNext'] = 'off';
            }
            if (!empty($options['pageBreakBefore']) && $options['pageBreakBefore'] !== 'off') {
                $options['pageBreakBefore'] = 'on';
            } else if (isset($options['pageBreakBefore']) && $options['pageBreakBefore'] === false) {
                $options['pageBreakBefore'] = 'off';
            }
            if (!empty($options['smallCaps']) && $options['smallCaps'] !== 'off') {
                $options['smallCaps'] = 'on';
            } else if (isset($options['smallCaps']) && $options['smallCaps'] === false) {
                $options['smallCaps'] = 'off';
            }
            if (!empty($options['widowControl']) && $options['widowControl'] !== 'off') {
                $options['widowControl'] = 'on';
            } else if (isset($options['widowControl']) && $options['widowControl'] === false) {
                $options['widowControl'] = 'off';
            }
            if (!empty($options['wordWrap']) && $options['wordWrap'] !== 'off') {
                $options['wordWrap'] = 'on';
            } else if (isset($options['wordWrap']) && $options['wordWrap'] === false) {
                $options['wordWrap'] = 'off';
            }
        }
        return $options;
    }
}