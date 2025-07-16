<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Content\Site\View\Featured;

use Core;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Frontpage View class
 *
 * @since  1.5
 */
class HtmlView extends BaseHtmlView
{
  /**
   * The model state
   *
   * @var  \Joomla\Registry\Registry
   */
  protected $state = null;

  /**
   * The featured articles array
   *
   * @var  \stdClass[]
   */
  protected $items = null;

  /**
   * The pagination object.
   *
   * @var  \Joomla\CMS\Pagination\Pagination
   */
  protected $pagination = null;

  /**
   * The featured articles to be displayed as lead items.
   *
   * @var  \stdClass[]
   */
  protected $lead_items = [];

  /**
   * The featured articles to be displayed as intro items.
   *
   * @var  \stdClass[]
   */
  protected $intro_items = [];

  /**
   * The featured articles to be displayed as link items.
   *
   * @var  \stdClass[]
   */
  protected $link_items = [];

  /**
   * @var    \Joomla\Database\DatabaseDriver
   *
   * @since  3.6.3
   *
   * @deprecated  4.3 will be removed in 6.0
   *              Will be removed without replacement use database from the container instead
   *              Example: Factory::getContainer()->get(DatabaseInterface::class);
   */
  protected $db;

  /**
   * The user object
   *
   * @var \Joomla\CMS\User\User|null
   */
  protected $user = null;

  /**
   * The page class suffix
   *
   * @var    string
   *
   * @since  4.0.0
   */
  protected $pageclass_sfx = '';

  /**
   * The page parameters
   *
   * @var    \Joomla\Registry\Registry|null
   *
   * @since  4.0.0
   */
  protected $params = null;

  /**
   * Execute and display a template script.
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  public function display($tpl = null)
  {
    $document = Factory::getDocument();
    $document->addStyleSheet(Uri::base(true) . 'templates\adminlte\plugins\chart.js\Chart.min.js');
    // $document->addStyleSheet(Uri::base(true) . 'templates\adminlte\plugins\chart.js\Chart.min.js');
    $model = Core::model('Content/Feature');
    $this->moduleName =  $model->getNameModule();
    parent::display($tpl);
  }

  /**
   * Prepares the document.
   *
   * @return  void
   */
  // protected function _prepareDocument()
  // {
  //   // Because the application sets a default page title,
  //   // we need to get it from the menu item itself
  //   $menu = Factory::getApplication()->getMenu()->getActive();

  //   if ($menu) {
  //     $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
  //   } else {
  //     $this->params->def('page_heading', Text::_('JGLOBAL_ARTICLES'));
  //   }

  //   $this->setDocumentTitle($this->params->get('page_title', ''));

  //   if ($this->params->get('menu-meta_description')) {
  //     $this->getDocument()->setDescription($this->params->get('menu-meta_description'));
  //   }

  //   if ($this->params->get('robots')) {
  //     $this->getDocument()->setMetaData('robots', $this->params->get('robots'));
  //   }

  //   // Add feed links
  //   if ($this->params->get('show_feed_link', 1)) {
  //     $link    = '&format=feed&limitstart=';
  //     $attribs = ['type' => 'application/rss+xml', 'title' => htmlspecialchars($this->getDocument()->getTitle())];
  //     $this->getDocument()->addHeadLink(Route::_($link . '&type=rss'), 'alternate', 'rel', $attribs);
  //     $attribs = ['type' => 'application/atom+xml', 'title' => htmlspecialchars($this->getDocument()->getTitle())];
  //     $this->getDocument()->addHeadLink(Route::_($link . '&type=atom'), 'alternate', 'rel', $attribs);
  //   }
  // }
}
