<?php


namespace app\Controller;

use app\Model\AjaxValidation;
/**
 * Class RestController
 * @package app\Controller
 */

/**
 * return array data
 * @var AjaxValidation $ajax_valid_model
 */

class RestController extends AbstractController {

    public function ajaxHandleAction () {
        $ajax_validation_model = $this->container->get('AjaxValidation')->ajaxHandle($this->request);

        if ($ajax_validation_model !== false) {
            return $this->response->json($ajax_validation_model);
        }
        return $this->container->get('NotFoundResponse');
    }
}