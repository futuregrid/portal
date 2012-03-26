<?xml version="1.0" encoding="ISO-8859-1"?>

<!-- Namespace decleration and output method -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" encoding="ASCII" omit-xml-declaration="yes"/>

<!-- Global Stylesheet parameters -->
<xsl:param name="linkurl">/kb/document/</xsl:param>  <!-- The URL for KB links -->
<xsl:param name="format"/>   <!-- The format for KBHs -->
<xsl:param name="audience"/> <!-- The audience for the KB doc (e.g. ose) -->

<!-- Import Common Templates -->
<xsl:include href="kbxml-preprocess.xsl"/>
<xsl:include href="common.xsl"/>

<!-- ELEMENT TEMPLATES -->

<!-- root element -->
<xsl:template match="/">
    <!-- Get document title from the kbq element, the text contained by the kbq
    element is always correct.  It's set in XMLDocument.pm on SOAP server. -->
<!-- 
    <h2>
        <xsl:call-template name="makeTitlePrefix">
            <xsl:with-param name="refnode" select="/document/metadata"/>
        </xsl:call-template> 
        <xsl:value-of select="/document/kbml/kbq" />
    </h2>

 -->
    <!-- Apply templates to the body, then add refs and docinfo at the end -->
    <xsl:apply-templates select="/document/kbml/body"/>
    <xsl:call-template name="makeRefs"/>
    <xsl:call-template name="makeDocInfo"/>
</xsl:template>

<!-- body element -->
<xsl:template match="body">
    <xsl:apply-templates select="*|text()"/>
</xsl:template>

<!-- text elements -->
<xsl:template match="text()">
    <xsl:value-of select="." />
</xsl:template>

<!-- Common inline elements which can be copied directly -->
<xsl:template 
    match="h3|h4|h5|h6|li|i|u|b|ul|br|strong|em|col|hr|sup|p|cite|code|pre|dd|dt|dl|tt|sub|big|small">
    <xsl:copy>
        <xsl:apply-templates select="*|text()"/>
    </xsl:copy>
</xsl:template>

<xsl:template match="ol">
    <xsl:copy>
        <xsl:attribute name="id">
            <xsl:value-of select="@uniqinstance" />
        </xsl:attribute>
        <xsl:apply-templates select="*|text()" />
    </xsl:copy>
</xsl:template>

<!-- Common block elements which can be copied mostly directly. -->
<xsl:template
    match="blockquote">
    <xsl:copy>
        <p>
        <xsl:apply-templates select="*|text()"/>
        </p>
    </xsl:copy>
</xsl:template>

<!-- example elements should be replaced with span tags -->
<xsl:template match="example">
    <span class="example">
    <xsl:apply-templates select="./*|text()"/>
    </span>
</xsl:template>

<!-- image elements -->
<xsl:template match="image">
    <!-- Output the XHTML for images.  The HTML is a div wrapped around either
    an img element or an anchor element (i.e. inline/non-inline).  An hr
    element and descriptive text follows the image if the description attribute
    was set. -->
    <xsl:choose>
        <xsl:when test="@inline">
            <xsl:call-template name="makeImageInline" />
        </xsl:when>
        <xsl:otherwise>
            <xsl:call-template name="makeImageLink" />
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<!-- image descriptions -->
<xsl:template match="description">
    <br />
    <xsl:apply-templates select="*|text()"/>
</xsl:template>    

<!-- table elements -->
<xsl:template match="table">

    <!-- If the element has a caption element as a child then force the caption
    to be the first child element in the XHTML output. -->
    <xsl:copy>
        <!-- Add a class to the table to determine border type.
        Borders can only be off or on; see
        https://kb-dev.indiana.edu/irclog/kbdev/irclog.20050316.wiki#nidB2ME
        -->
        <xsl:attribute name="class">
            <xsl:choose>
                <xsl:when test="@border = 0">
                    <xsl:text>noborder</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>kbtable</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:attribute>

        <xsl:copy-of select="@cellpadding" />

        <!-- Move a child caption element to the top and process it -->
        <xsl:if test="./child::caption"> 
            <xsl:apply-templates select="*[ancestor-or-self::caption]|text()"/>
        </xsl:if>

        <!-- Process the rest of the non-caption elements normally -->
        <xsl:apply-templates select="./*[not(self::caption)]|text()"/>
    </xsl:copy>
</xsl:template>

<!-- caption elements -->
<xsl:template match="caption">
    <xsl:copy>
        <xsl:apply-templates select=".//*|text()"/>
    </xsl:copy>
</xsl:template>

<!-- anchor elements -->
<xsl:template match="a">
    <!-- Handle <a> elements not embedded in another <a> element -->
    <xsl:if test="not(ancestor::a)">
        <xsl:choose>
            <xsl:when test="starts-with(@href, '#')">
                <xsl:copy>
                    <xsl:copy-of select="@name|@target"/>
                    <xsl:attribute name="href">
                        <xsl:value-of select="$linkurl"/>
                        <xsl:value-of select="/document/metadata/docid"/>
                        <xsl:if test="not($audience='')">
                            <xsl:text>.</xsl:text>
                            <xsl:value-of select="$audience"/>
                        </xsl:if>
                        <xsl:if test="not($format='')">
                            <xsl:text>.</xsl:text>
                            <xsl:value-of select="$format"/>
                        </xsl:if>
                        <xsl:value-of select="@href"/>
                    </xsl:attribute>
                    <xsl:apply-templates select=".//*|text()"/>
                </xsl:copy>
            </xsl:when>
            <xsl:otherwise>
                <xsl:copy>
                    <xsl:copy-of select="@name|@target|@href"/>
                    <xsl:apply-templates select=".//*|text()"/>
                </xsl:copy>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:if>

    <!-- FIXME: If we're embedded in another <a> element then ignore this
    element and get its children.  This happens when we have a <a> element of
    the form:

        <a href="foo">http://www.foo.org</a>

    Inside XMLDocument.pm the text of this link is being heated causing this to
    result:

        <a href="foo"><a href="http://www.foo.org">http://www.foo.org</a></a>

    I've looked at the XPath XMLDocument is using and it looks correct to me.
    I'm not sure why this is happening.  -->
    <xsl:if test="ancestor::a">
        <xsl:apply-templates select="./*|text()"/>
    </xsl:if>
</xsl:template>

<!-- table row elements -->
<xsl:template match="tr">
    <xsl:if test="./*">
        <xsl:copy>
            <xsl:copy-of select="@valign"/>
            <xsl:apply-templates select="*"/>
        </xsl:copy>
    </xsl:if>
</xsl:template>

<!-- boilers elements -->
<xsl:template match="boiler">
    <xsl:apply-templates select="*|text()"/>
</xsl:template>

<!-- hotitem elements (aka kbh elements) -->
<xsl:template match="kbh">
    <xsl:call-template name="kbDocLink">
        <xsl:with-param name="titleText">
            <xsl:value-of select="./text()"/>
        </xsl:with-param>
    </xsl:call-template>
</xsl:template>

<!-- KB anchor elements (aka kba elements) -->
<xsl:template match="kba">
    <xsl:call-template name="kbDocLink">
        <xsl:with-param name="titleText">
            <xsl:call-template name="makeTitlePrefix">
                <xsl:with-param name="refnode" select="."/>
            </xsl:call-template>
            <xsl:value-of select="./title"/>
        </xsl:with-param>
    </xsl:call-template>
</xsl:template>

<xsl:template name="kbDocLink">
    <xsl:param name="titleText" />
    <xsl:choose>
        <xsl:when test="@access='allowed'">
					<xsl:element name="a">
						<xsl:attribute name="href">
							<xsl:value-of select="$linkurl"/>
							<xsl:value-of select="@docid"/>
						</xsl:attribute>
						<xsl:attribute name="class">
								<xsl:text>kb-link</xsl:text>
						</xsl:attribute>
						<xsl:value-of select="$titleText" />
					</xsl:element>
        </xsl:when>
        <xsl:otherwise>
            <xsl:text>[You do not have sufficient permission to view this document.]</xsl:text>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<!-- table alignment elements -->
<xsl:template match="l|r|c|lh|rh|ch">
    <!-- Each one of "l", "r", and "c" are KBML for marking table data and the
    alignment of that table data.  Only one tag is needed because column and
    row information is kept elsewhere.  "lh", "rh", and "ch" are similar,
    except they are headers rather than data cells. -->
    <xsl:variable name="alignment" select="substring(name(), 1, 1)" />
    <xsl:variable name="elementName">
        <xsl:choose>
            <xsl:when test="substring(name(), 2, 1) = 'h'">
                <xsl:text>th</xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>td</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:element name="{$elementName}">
        <xsl:attribute name="align">
            <xsl:choose>
                <xsl:when test="$alignment='c'">
                    <xsl:text>center</xsl:text>
                </xsl:when>
                <xsl:when test="$alignment='r'">
                    <xsl:text>right</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>left</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:attribute>
    
        <xsl:attribute name="class">
            <xsl:choose>
                <xsl:when test="../../@border = 0">
                    <xsl:text>noborder</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>kbtd</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:attribute>
        
        <xsl:attribute name="id">
            <xsl:value-of select="@uniqinstance" />
        </xsl:attribute>

        <!-- Embed anything that was in the table alignment element into a
        regular td element. -->
        <xsl:copy-of select="@colspan|@rowspan|@valign"/>
        <xsl:apply-templates select="*|text()"/>
    </xsl:element>
</xsl:template>

<!-- mi elements -->
<xsl:template match="mi">
    <strong><code><xsl:apply-templates select="*|text()"/></code></strong>
</xsl:template>

<!-- NAMED TEMPLATES -->

<!-- Determine if we need to display an Also See section -->
<xsl:template name="existsAlsoSee">
    <xsl:param name="index" select="0"/>
    <xsl:variable name="refCount"
        select="count(/document/metadata/reference)"/>
    
    <xsl:choose>
        <xsl:when test="$refCount = 0">
            <xsl:value-of select="false()"/>
        </xsl:when>
        <xsl:otherwise>
            <xsl:variable name="refNode"
                select="/document/metadata/reference[$index]"/>
            <xsl:choose>
                <xsl:when test="boolean($kbstaff) or
                    (not(./visibility = 'archived') and $refNode[@access = 'allowed'])">
                    <xsl:value-of select="true()"/>
                </xsl:when>
                <xsl:when test="$index = $refCount">
                    <xsl:value-of select="false()"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:call-template name="existsAlsoSee">
                        <xsl:with-param name="index" select="$index + 1"/>
                    </xsl:call-template>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<!-- Create the list of document references -->
<xsl:template name="makeRefs">
    <xsl:variable name="alsoSee">
        <xsl:call-template name="existsAlsoSee"/>
    </xsl:variable>

    <xsl:if test="$alsoSee = 'true'">
        <h3>Also see:</h3>
        <ul>
            <xsl:for-each
                select="/document/metadata/reference[@access = 'allowed']">
                <xsl:if test="not(visibility = 'archived') or
                              boolean($kbstaff)">
                    <li>
                        <xsl:element name="a">
														<xsl:attribute name="href">
															<xsl:value-of select="$linkurl"/>
															<xsl:value-of select="@docid"/>
														</xsl:attribute>
														<xsl:attribute name="class">
																<xsl:text>kb-link</xsl:text>
														</xsl:attribute>
                            <xsl:call-template name="makeTitlePrefix">
                                <xsl:with-param name="refnode" select="."/>
                            </xsl:call-template>
                            <xsl:value-of select="./title/text()"/>
                        </xsl:element>
                    </li>
                </xsl:if>
            </xsl:for-each>
        </ul>
    </xsl:if>
</xsl:template>

<!-- Create the XHTML for the document's metadata information -->
<xsl:template name="makeDocInfo">
    <div class="documentInfo">
        <xsl:text>This is document </xsl:text>
        <em><xsl:value-of select="/document/metadata/docid/text()"/></em>
        <xsl:text> in </xsl:text>
        <xsl:variable name="domains"
            select="count(/document/metadata/domain)"/> 
        <xsl:choose>
            <xsl:when test="$domains &gt; 1">
                <xsl:text>domains </xsl:text>
                  <xsl:for-each select="/document/metadata/domain/text()">
                    <xsl:choose>
                      <xsl:when test="position() = 1">
                        <em>
                          <xsl:value-of select="."/>
                        </em>
                      </xsl:when>
                      <xsl:when test="position() = $domains">
                        <xsl:if test="not($domains = 2)">
                          <xsl:text>,</xsl:text>
                        </xsl:if>
                        <xsl:text> and </xsl:text>
                        <em>
                          <xsl:value-of select="."/>
                        </em>
                      </xsl:when>
                      <xsl:otherwise>
                        <xsl:text>, </xsl:text>
                        <em>
                          <xsl:value-of select="."/>
                        </em>
                      </xsl:otherwise>
                    </xsl:choose>
                  </xsl:for-each>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>domain </xsl:text>
                <em>
                    <xsl:value-of select="/document/metadata/domain/text()"/>
                </em>
            </xsl:otherwise>
        </xsl:choose>
        <xsl:text>.</xsl:text>
        <xsl:element name="br"/>
        <xsl:text>Last modified on </xsl:text> 
        <em>
            <xsl:call-template name="makeDate">
                <xsl:with-param name="datenode"
                                select="/document/metadata/lastmodified"/>
            </xsl:call-template>
        </em>
        <xsl:text>.</xsl:text>
        <xsl:if test="$kbstaff">
            <xsl:text>  Last approved on </xsl:text>
            <em>
                <xsl:call-template name="makeDate">
                    <xsl:with-param name="datenode"
                                    select="/document/metadata/approved"/>
                </xsl:call-template>
            </em>
            <xsl:text>.</xsl:text>
            <br />
            <xsl:text>This document is owned by </xsl:text>
            <em><xsl:value-of select="/document/metadata/owner" /></em>
            <xsl:text>.</xsl:text>
        </xsl:if>
    </div>
</xsl:template>

<!-- Convert a date node into a string -->
<xsl:template name="makeDate">
    <xsl:param name="datenode"/>
    <xsl:choose>
        <xsl:when test="$datenode/@month = 1">
            <xsl:text>January</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 2">
            <xsl:text>February</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 3">
            <xsl:text>March</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 4">
            <xsl:text>April</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 5">
            <xsl:text>May</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 6">
            <xsl:text>June</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 7">
            <xsl:text>July</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 8">
            <xsl:text>August</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 9">
            <xsl:text>September</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 10">
            <xsl:text>October</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 11">
            <xsl:text>November</xsl:text>
        </xsl:when>
        <xsl:when test="$datenode/@month = 12">
            <xsl:text>December</xsl:text>
        </xsl:when>
    </xsl:choose>
  
    <xsl:text> </xsl:text>
    <xsl:value-of select="$datenode/@day"/>
    <xsl:text>, </xsl:text>
    <xsl:value-of select="$datenode/@year"/>
</xsl:template>

<!-- Make a link for a non-inline KBML image. -->
<xsl:template name="makeImageLink">
    <xsl:element name="div">
        <xsl:attribute name="class">
            <xsl:text>image</xsl:text>
        </xsl:attribute>
        <xsl:element name="a">
            <xsl:attribute name="href">
                <xsl:call-template name="imageUrl"/>
            </xsl:attribute>
            <xsl:choose>
                <xsl:when test="@description">
                    <xsl:value-of select="@description"/>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>See an image depicting what was just described (</xsl:text>
                    <xsl:value-of select="@src"/>
                    <xsl:text>)</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:element>
</xsl:template>

<!-- Make an img element for an inline KB image. -->
<xsl:template name="makeImageInline">
    <xsl:element name="div">
        <xsl:attribute name="class">
            <xsl:text>inlineimage image</xsl:text>
            <xsl:value-of select="@uniqinstance" />
        </xsl:attribute>
        <xsl:choose>
            <xsl:when test="@href">
                <xsl:element name="a">
                    <xsl:attribute name="href">
                        <xsl:value-of select="@href" />
                    </xsl:attribute>
                    <xsl:call-template name="makeImgElement" />
                </xsl:element>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="makeImgElement" />
            </xsl:otherwise>
        </xsl:choose>
        <xsl:apply-templates select="description" />
    </xsl:element>
</xsl:template>

<xsl:template name="makeImgElement">
    <xsl:element name="img">
        <xsl:attribute name="class">
            <xsl:text>noborder</xsl:text>
        </xsl:attribute>

        <!-- Copy directly those attributes for which it's ok -->
        <xsl:copy-of select="@height"/>
        <xsl:copy-of select="@width"/>

        <xsl:attribute name="src">
            <xsl:call-template name="imageUrl"/>
        </xsl:attribute>

        <xsl:attribute name="alt">
            <xsl:value-of select="@alt"/>
        </xsl:attribute>
    </xsl:element>
</xsl:template>


<!-- Construct the URL pointing to a KB image from the src and format
attributes of an image element -->
<xsl:template name="imageUrl">
    <xsl:text>https://media.kb.iu.edu/image/</xsl:text>
    <xsl:value-of select="@src"/>
    <xsl:text>.</xsl:text>
    <xsl:value-of select="@format"/>
</xsl:template>

</xsl:stylesheet>
