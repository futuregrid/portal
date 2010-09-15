<?xml version="1.0" encoding="ISO-8859-1"?>

<!-- Namespace decleration and output method -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" encoding="ASCII" omit-xml-declaration="yes"/>

<xsl:param name="titleSuffix"/>  <!-- Text appended to page titles -->

<!-- Import Common Templates -->
<xsl:include href="common.xsl"/>

<xsl:template name="makeImageCSS">
    /* Style for specific inline images */ 
    <xsl:for-each select="/document/kbml/body//image">
        <xsl:text>div.image</xsl:text>
        <xsl:value-of select="@uniqinstance" />
        <xsl:text> { </xsl:text>
        <xsl:choose>
            <xsl:when test="description">
                <xsl:text>text-align: center; margin: auto auto; </xsl:text>
                <xsl:if test="description/@width">
                    <xsl:text>width: </xsl:text>
                    <xsl:value-of select="description/@width" />
                    <xsl:text>em; </xsl:text>
                </xsl:if>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>display: inline; </xsl:text>
            </xsl:otherwise>
        </xsl:choose>
        <xsl:text>}
        </xsl:text>
    </xsl:for-each>
</xsl:template>

<xsl:template name="makeOrderedListCSS">
    /* Style for specific ordered lists */
    <xsl:for-each select="/document/kbml/body//ol">
        <xsl:if test="@type">
            <xsl:text>ol#</xsl:text>
            <xsl:value-of select="@uniqinstance" />
            <xsl:text> { list-style-type: </xsl:text>
            <xsl:choose>
                <xsl:when test="@type = 'a'">
                    <xsl:text>lower-alpha</xsl:text>
                </xsl:when>
                <xsl:when test="@type = 'A'">
                    <xsl:text>upper-alpha</xsl:text>
                </xsl:when>
                <xsl:when test="@type = 'i'">
                    <xsl:text>lower-roman</xsl:text>
                </xsl:when>
                <xsl:when test="@type = 'I'">
                    <xsl:text>upper-roman</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:text>decimal</xsl:text>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:text>; }
            </xsl:text>
        </xsl:if>
    </xsl:for-each>
</xsl:template>

<xsl:template name="makeTableCellCSS">
    /* Style for specific table cells */
    <xsl:for-each select="/document/kbml/body//table/tr/*">
        <xsl:if test="@bgcolor">
            <xsl:text>td#</xsl:text>
            <xsl:value-of select="@uniqinstance" />
            <xsl:text> { background-color: </xsl:text>
            <xsl:value-of select="@bgcolor" />
            <xsl:text>; }
            </xsl:text>
        </xsl:if>
    </xsl:for-each>
</xsl:template>

<xsl:template match="/">
  <title>
    <xsl:call-template name="makeTitlePrefix">
      <xsl:with-param name="refnode" select="/document/metadata"/>
      <xsl:with-param name="span" select="0"/>
    </xsl:call-template>
    <xsl:value-of select="/document/kbml/kbq"/>
    <xsl:text> - </xsl:text>
    <xsl:value-of select="$titleSuffix" />
  </title>

  <style type="text/css">
      <xsl:call-template name="makeImageCSS" />
      <xsl:call-template name="makeOrderedListCSS" />
      <xsl:call-template name="makeTableCellCSS" />
  </style>
</xsl:template>

</xsl:stylesheet>
