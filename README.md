#ThinFrame CommandLine

CLI support for PHP applications.

[![Latest Stable Version](https://poser.pugx.org/thinframe/command_line/v/stable.png)](https://packagist.org/packages/thinframe/command_line)
[![Latest Unstable Version](https://poser.pugx.org/thinframe/command_line/v/unstable.png)](https://packagist.org/packages/thinframe/command_line)
[![License](https://poser.pugx.org/thinframe/command_line/license.png)](https://packagist.org/packages/thinframe/command_line)

##Features

* Easy install via composer
* Chained commands with unlimited levels
    * `thinframe command childcommand1 childcommand2 ...`
* Bash integration (`/usr/bin` command and completion support)
* Integration with Symfony2 DiC
* Input/Output support
* Styled output using shortcodes
    * `[format foreground='red' background='white' effects='bold blink']Your text[/format]`
    * `[center]Your text[/center]`
    * `[sideways]Some service %MIDDLE% Running[/sideways]`

##Installation

* Via composer: `composer require thinframe/command-line`
* Via git: `git clone https://github.com/thinframe/command-line`

##Copyright

* MIT License - Sorin Badea <sorin.badea91@gmail.com>