<?php
/**
 * ArchFramework (ArchFW in short) is modern, new, fast and dedicated framework for most my modern projects
 * 
 * Visit https://github.com/okbrcz/ArchFW/ for more info.
 *
 * PHP version 7.2
 *
 * @category  Framework
 * @package   ArchFW
 * @author    Oskar Barcz <kontakt@archi-tektur.pl>
 * @copyright 2018 Oskar 'archi_tektur' Barcz
 * @license   MIT
 * @version   4.0
 * @link      https://github.com/archi-tektur/ArchFW/
 */

namespace ArchFW\Base;

use ArchFW\Controller\Error;


abstract class View
{    
    private $_loader;
    private $_twig;

    protected function _render($wrapperfile, $templatefile)
    {
        try {
            $this->_loader = new \Twig_Loader_Filesystem(CONFIG['twigConfig']['twigTemplatesPath']);

            $this->_twig = new \Twig_Environment($this->_loader);
            $template = $this->_twig->load($templatefile);

            $vars = CONFIG['metaConfig'];
            $vars += [
                'stylesheets'=>CONFIG['stylesheets']
            ];

            $vars += require_once CONFIG['twigConfig']['twigWrappersPath'] . $wrapperfile;
            echo $template->render($vars);
        } catch (Exception $t) {
            new Error(602, "Twig Error: $t->getMessage()", Error::PLAIN);
        }
    }
}