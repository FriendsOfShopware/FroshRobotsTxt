# FroshRobotsTxt

[![Twitter Follow](https://img.shields.io/twitter/follow/ShopwareFriends?style=flat-square&logo=twitter)](https://twitter.com/ShopwareFriends)
[![Slack](https://img.shields.io/badge/Slack-%23friendsofshopware-blue?style=flat-square&logo=Slack)](https://slack.shopware.com)

This plugin provides a `robots.txt` for a Shopware 6 shop. Currently it is not possible to distinguish different user-agents. Note that in general only the `robots.txt` at the root [will be considered](https://developers.google.com/search/docs/advanced/robots/create-robots-txt#format_location).

## `Allow` and `Disallow` rules
Currently there exist the following default rules
```
Allow: /
Disallow: /*?
Allow: /*theme/
```
If you need to modify them this should be done by a template modification. If there are other general rules which are useful for others, consider creating a pull request.

It is possible to configure the `Disallow` and `Allow` rules in the plugin configuration. Each line needs to start with `Allow:` or `Disallow:` followed by the URI-path. The generated `robots.txt` will contain each path prefixed with the absolute base path.

For example suppose you have two "domains" configured for a sales channel `example.com` and `example.com/en` and the plugin configuration
```
Disallow: /account/
Disallow: /checkout/
Disallow: /widgets/
Allow: /widgets/cms/
Allow: /widgets/menu/offcanvas
```
The `robots.txt` at `example.com/robots.txt` contains:
```
Disallow: /en/account/
Disallow: /en/checkout/
Disallow: /en/widgets/
Allow: /en/widgets/cms/
Allow: /en/widgets/menu/offcanvas
Disallow: /account/
Disallow: /checkout/
Disallow: /widgets/
Allow: /widgets/cms/
Allow: /widgets/menu/offcanvas
```

## Sitemaps
In addition to the rules the sitemaps containing the domain will be linked. Again suppose we have the domains `example.com` and `example.com/en` configured, the `robots.txt` will contain
```
Sitemap: https://example.com/en/sitemap.xml
Sitemap: https://example.com/sitemap.xml
```
