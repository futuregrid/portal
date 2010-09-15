<?xml version="1.0" encoding="ISO-8859-1"?>

<!-- Namespace decleration and output method -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<!-- Common Variables -->
<xsl:param name="kbstaff"/>    <!-- Is the user 'kbstaff'? -->

<!-- Named Templates -->

<!-- Convert a String to Uppercase -->
<xsl:template name="toUpper">
  <xsl:param name="instr"/>
  <xsl:value-of select="translate($instr, 'abcdefghijklmnopqrstuvwxyz',
    'ABCDEFGHIJKLMNOPQRSTUVWXYZ')"/>
</xsl:template>

<!-- Determine if a Document is INTERNAL or not -->
<!-- NOTE: the xsl:value-of element ALWAYS returns a string, so later when
     we evaluate the return of this template, compare it to the STRING
     'true' or 'false', not the boolean value (the boolean of a non-empty
     string will always return true). -->
<xsl:template name="isInternal">
  <xsl:param name="refnode"/>
  <xsl:param name="domnode" select="0"/>

  <xsl:choose>
    <xsl:when test="$domnode > count(/document/config/internal_domains)">
      <xsl:value-of select="false()"/>
    </xsl:when>
    <xsl:when test="$refnode/domain[position() = $domnode] = 
      /document/config/internal_domains/text()">
      <xsl:value-of select="true()"/>
    </xsl:when>
    <xsl:otherwise>
      <xsl:call-template name="isInternal">
        <xsl:with-param name="refnode" select="$refnode"/>
        <xsl:with-param name="domnode" select="$domnode + 1"/>
      </xsl:call-template>
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>

<!-- Generate INTERNAL and/or visibility prefixes for a title -->
<xsl:template name="_createTitlePrefix">
  <xsl:param name="refnode"/>
  <xsl:variable name="vis" select="$refnode/visibility/text()"/>
  <xsl:variable name="visUpr">
    <xsl:call-template name="toUpper">
      <xsl:with-param name="instr" select="$vis"/>
    </xsl:call-template>
  </xsl:variable>

  <xsl:variable name="found">
    <xsl:call-template name="isInternal">
      <xsl:with-param name="refnode" select="$refnode"/>
    </xsl:call-template>
  </xsl:variable>

  <xsl:if test="not($visUpr = 'VISIBLE')">
    <xsl:choose>
      <xsl:when test="$visUpr = 'NOSEARCH'">
        <xsl:if test="boolean($kbstaff)">
          <xsl:text>NOSEARCH: </xsl:text>
        </xsl:if>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$visUpr"/>
        <xsl:text>: </xsl:text>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:if>
  <xsl:if test="$found = 'true'">
      <xsl:text>INTERNAL (</xsl:text>
      <xsl:for-each select="$refnode/domain/text()">
        <xsl:if test="not(position() = 1)">
          <xsl:text>, </xsl:text>
        </xsl:if>
        <xsl:call-template name="toUpper">
          <xsl:with-param name="instr" select="current()"/>
        </xsl:call-template>
      </xsl:for-each>
      <xsl:text>): </xsl:text>
  </xsl:if>
</xsl:template>

<!-- Make a Title Prefix, with an optional SPAN Tag -->
<xsl:template name="makeTitlePrefix">
    <xsl:param name="refnode"/>
    <xsl:param name="span" select="1"/>
    
    <xsl:variable name="titlePrefix">
        <xsl:call-template name="_createTitlePrefix">
            <xsl:with-param name="refnode" select="$refnode"/>
        </xsl:call-template>
    </xsl:variable>
    
    <xsl:if test="string-length($titlePrefix) &gt; 0">
        <xsl:choose>
            <xsl:when test="boolean($span)">
                <xsl:element name="span">
                    <xsl:attribute name="class">
                        <xsl:text>titleprefix</xsl:text>
                    </xsl:attribute>
                    <xsl:value-of select="$titlePrefix"/>
                </xsl:element>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="$titlePrefix"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:if>
</xsl:template>

</xsl:stylesheet>
