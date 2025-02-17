<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Backend\Config\Version\Controller;

use Gm;
use Gm\Mvc\Module\BaseModule;
use Gm\Panel\Http\Response;
use Gm\Panel\Version\Version;
use Gm\Panel\Widget\TabWidget;
use Gm\Panel\Controller\BaseController;

/**
 * Контроллер версии системы.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Backend\Config\Version\Controller
 * @since 1.0
 */
class Page extends BaseController
{
    /**
     * {@inheritdoc}
     * 
     * @var BaseModule|\Gm\Backend\Config\Version\Extension
     */
    public BaseModule $module;

    /**
     * {@inheritdoc}
     */
    public function translateAction(mixed $params, string $default = null): ?string
    {
        switch ($this->actionName) {
            // просмотр основной страницы
            case $this->defaultAction:
                return $this->t('view system version information');

            default:
                return parent::translateAction($params, $default);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function createWidget(): TabWidget
    {
        /** @var TabWidget $tab */
        $tab = new TabWidget();

        // панель вкладки компонента (Gm.view.tab.Widgets GmJS)
        $tab->id = 'info';
        $tab->title = '#{name}';
        $tab->tooltip = [
            'icon'  => $this->module->getIconUrl(),
            'title' => '#{name}',
            'text'  => '#{description}'
        ];
        $tab->icon = $this->module->getIconUrl('_small');
        $tab->cls = 'g-frame g-panel_background';
        $tab->bodyCls = 'g-frame__body';

        // панель (Ext.panel Sencha ExtJS)
        $tab->items = [
            'html' => $this->renderPartial(
                'page',
                [
                    'language' => Gm::$app->language,
                    'version'  => Gm::$app->version,
                    'edition'  => Gm::$app->version->getEdition(),
                    'panel'    => new Version()
                ]),
            'scrollable' => true
        ];

        $tab->addCss('/page.css');
        return $tab;
    }

    /**
     * Действие "index" выводит версию системы.
     * 
     * @return Response
     */
    public function indexAction(): Response
    {
        /** @var \Gm\Panel\Http\Response $response */
        $response = $this->getResponse();

        /** @var TabWidget|false $widget */
        $widget = $this->getWidget();
        // если была ошибка при формировании виджета
        if ($widget === false) {
            return $response;
        }

        $response
            ->setContent($widget->run())
            ->meta
                ->addWidget($widget);
        return $response;
    }
}
