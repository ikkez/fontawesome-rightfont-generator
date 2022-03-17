## Font Awesome 5 Pro IconSet Generator for RightFont 5

![RightFont5](https://ikkez.de/linked/fontawesome-gen.png)


This package is used for generating [Font Awesome 5 Pro](https://github.com/FortAwesome/Font-Awesome-Pro) font library files for the [RightFont](https://rightfontapp.com/) font manager app on MacOS.
That way you can use all Pro icons in your design and prototyping tools with ease.

#### Usage:

1.  Download this package. This script is written in PHP, so you need PHP installed on your machine.

2.  Download FontAwesome Pro. You need a pro licence to get access to that.

3.  From the  `fontawesome-pro-5.x.x-web` package, copy the `metadata/icons.yml` into the root directory of this project.

4.  Run in your terminal: `composer install` to setup the package.

5.  Run in your terminal: `php index.php generate` to generate the icon package for RightFont.

6.  Copy all generated `.rightfontmetadata` files to your icon font library at: `~/RightFont/Icon Fonts.rightfontlibrary/metadata/fonts/`

7.  Copy the font-awesome font files (`fa-brands-400.ttf`, `fa-duotone-900.ttf`, `fa-light-300.ttf`, `fa-thin-100.ttf`, `fa-regular-400.ttf`, `fa-solid-900.ttf`) to `~/RightFont/Icon Fonts.rightfontlibrary/fonts/Font Awesome 6 Pro/`

8.  Restart RightFont. Enjoy.

---

I should have made this in python, sry 😅

---

Licence GPLv3
