<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Content\Site\Controller;

use Core;
use Exception;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Versioning\VersionableControllerTrait;
use Joomla\Utilities\ArrayHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Content feature class copy from ArticleController .
 *
 * @since  1.6.0
 */
class FeatureController extends FormController
{

  public function getTongTheoNamCTL()
  {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    $phuongxa_id = isset($json['phuongxa']) ? $json['phuongxa'] : null;

    $model = Core::model('Content/Feature');

    try {
      $data =  $model->getTongTheoNam($phuongxa_id);
    } catch (Exception $e) {
      $data = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    jexit();
  }
  
  public function getDataChart ()
  {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    $phuongxa_id = isset($json['phuongxa']) ? $json['phuongxa'] : null;

    $model = Core::model('Content/Feature');

    try {
      $data =  $model->getTongHopLuyKe($phuongxa_id);
    } catch (Exception $e) {
      $data = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    jexit();
  }
}
