{*
* This module helps administrators to show website notifications regarding cookies used by stores on bottom positions with links to redirect cookie policy pages, management from the back-office with multiple options and show different message based on multiple store language.
*
* NOTICE OF LICENSE
* 
* Each copy of the software must be used for only one production website, it may be used on additional
* test servers. You are not permitted to make copies of the software without first purchasing the
* appropriate additional licenses. This license does not grant any reseller privileges.
* 
* @author    Shahab
* @copyright 2007-2022 Shahab-FK Enterprises
* @license   Prestashop Commercial Module License
*}

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />

<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>

{if $SFKCOMPLIANCETYPE == 'NULL' || $SFKCOMPLIANCETYPE == ''}

<script data-keepinline="true" data-nocompress="true">
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000"
    },
    "button": {
      "background": "#f1d600"
    }
  },
  "theme": "classic",
  "position": "{$SFKPOSITION|escape:'htmlall':'UTF-8'}",
  "content": {
    "message": "{$COOKIEBANNER|escape:'htmlall':'UTF-8'}",
    "link": "{$LEARN_TITLE|escape:'htmlall':'UTF-8'}",
    "dismiss": "{$DECLINE_TITLE|escape:'htmlall':'UTF-8'}",
    "deny": "{$DECLINE_TITLE|escape:'htmlall':'UTF-8'}",
    "allow": "{$CONTINUE_TITLE|escape:'htmlall':'UTF-8'}",
    "href": "{$SFKURL|escape:'htmlall':'UTF-8'}"
  }
});
</script>    

{else}

<script data-keepinline="true" data-nocompress="true">
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000"
    },
    "button": {
      "background": "#f1d600"
    }
  },
  "theme": "classic",
  "position": "{$SFKPOSITION|escape:'htmlall':'UTF-8'}",
  "type": "{$SFKCOMPLIANCETYPE|escape:'htmlall':'UTF-8'}",
  "content": {
    "message": "{$COOKIEBANNER|escape:'htmlall':'UTF-8'}",
    "link": "{$LEARN_TITLE|escape:'htmlall':'UTF-8'}",
    "dismiss": "{$DECLINE_TITLE|escape:'htmlall':'UTF-8'}",
    "deny": "{$DECLINE_TITLE|escape:'htmlall':'UTF-8'}",
    "allow": "{$CONTINUE_TITLE|escape:'htmlall':'UTF-8'}",
    "href": "{$SFKURL|escape:'htmlall':'UTF-8'}"
  }
});
</script> 

{/if}


