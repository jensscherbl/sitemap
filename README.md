# Magento 2: Sitemap

Adds the home page to the [XML sitemap][1] in [Magento 2][2].

## Intro

Providing search engines with a sitemap in a [machine readable format][3] is a SEO best practice for many years now, and Magento already offers such functionality out of the box.

Unfortunately, Magento also [excludes so called utility CMS pages][5], [including the home page][6], from the generated XML sitemaps, which is considered a big mistake among SEO experts.

This extension explicitly adds the store’s home page when generating an XML sitemap, using the store’s [base URL][7] as configured. On a side note, the home page can be accessed with and without its URL key in Magento, so the extension also adds a [canonical tag][8] to the home page to avoid duplicate pages.

![Screenshot: Magento admin interface for generating sitemaps.][4] 

## How to install

Simply require the extension via [Composer][9].

```sh
$ composer require smaex/sitemap ^1.0
```

Finally, enable the module via [Magento’s CLI][10].

```sh
$ magento module:enable Smaex_Sitemap
```

## How to use

The extension works pretty much out of the box without further configuration. However, it also provides a new system configuration for fine-tuning.

![Screenshot: Magento admin interface for generating sitemaps.][11]

## We’re hiring!

We’re currently looking for interested ~~masochists~~ **PHP & Magento developers** to join our small, friendly and experienced Magento Team **in Munich**. Just drop me a line via [j.scherbl@techdivision.com][12]

 [1]: https://support.google.com/webmasters/answer/183668
 [2]: https://github.com/magento/magento2
 [3]: https://www.sitemaps.org/protocol.html
 [4]: https://user-images.githubusercontent.com/1640033/58386314-26bf4200-7ffe-11e9-94f6-70dfe80efccd.png
 [5]: https://github.com/magento/magento2/blob/2.3/app/code/Magento/Sitemap/Model/ResourceModel/Cms/Page.php#L106
 [6]: https://github.com/magento/magento2/blob/2.3/app/code/Magento/Cms/Model/GetUtilityPageIdentifiers.php#L53
 [7]: https://docs.magento.com/m2/ce/user_guide/stores/store-urls.html
 [8]: https://support.google.com/webmasters/answer/139066
 [9]: https://getcomposer.org
[10]: https://devdocs.magento.com/guides/v2.3/install-gde/install/cli/install-cli-subcommands-enable.html
[11]: https://user-images.githubusercontent.com/1640033/58386461-68e98300-8000-11e9-991e-802ace2b99d3.png
[12]: mailto:j.scherbl@techdivision.com
