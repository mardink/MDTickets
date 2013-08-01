<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 1-8-13
 * Time: 20:32
 * To change this template use File | Settings | File Templates.
 */
// Load the CSS file
FOFTemplateUtils::addCSS('media://com_mdtickets/css/mdtickets.css');

// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');
// Load custom js file
$document = JFactory::getDocument();
$document->addScript('media/com_mdtickets/js/mdtickets.js');


$viewTemplate = $this->getRenderedForm();
echo $viewTemplate;
?>