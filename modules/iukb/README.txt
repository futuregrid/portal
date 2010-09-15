
Author: Matthew Lewallen (mlewalle [at] indiana edu, mithril293 [at] gmail com)

  The IUKB module was born out of a need to display Indiana University
Knowledge Base articles using the active theme from a Drupal site. This is
accomplished through remote procedure calls to the KB's SOAP API. The data for
the article is transferred to the Drupal site and then themed using the Drupal
API. For the end user, a knowledge base article can be accessed by a specially
crafted URL of the form: http://www.example.com/kb/XXXX. In this example, XXXX
is the 4 character KB document ID and www.example.com is the hostname of the
Drupal site. There are a couple other features thrown in for good measure.
Two input filters are added. One scans for any <a href=""> values that point
to kb.iu.edu and replaces them with relative links to the site's /kb/ URL. The
other filter scans content for tokens in the form [iukb:XXXX] and replaces
them with the title of the KB article linked to the local /kb/ version.
Knowledge Base searches may also be performed by accessing URLs in the form
/kb/search/TERM (where TERM is the word being searched for). The search feature
paginates the search results and attempts to rewrite any links to the KB itself
with their local counterparts.


