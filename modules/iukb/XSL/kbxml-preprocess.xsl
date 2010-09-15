<?xml version="1.0" encoding="ISO-8859-1"?>

<!-- Namespace decleration and output method -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" encoding="ASCII" omit-xml-declaration="no"/>

<!-- This is the identity transformation from the W3C's XSLT spec;
see http://www.w3.org/TR/xslt#element-copy. -->
<xsl:template match="@*|node()">
    <xsl:copy>
        <xsl:attribute name="uniqinstance">
            <xsl:value-of select="generate-id()" />
        </xsl:attribute>
        <xsl:apply-templates select="@*|node()"/>
    </xsl:copy>
</xsl:template>

</xsl:stylesheet>
