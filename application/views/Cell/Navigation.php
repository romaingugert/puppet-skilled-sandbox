<?php
namespace App\View\Cell;

use App\Service\Notification\Model as NotificationModel;

class Navigation extends \Globalis\PuppetSkilled\View\Cell
{
    /**
     * Default Navigation
     * @return string
     */
    public function default()
    {
        // Load lang
        $this->lang->load('navigation/navigation_default');

        $data['footer_nav'] = $this->getFooterNav();
        $data['user'] = $this->authenticationService->user();

        return $this->render(
            'default',
            $data
        );
    }

    public function navbar($data)
    {
        // Load lang
        $this->lang->load('navigation/navigation_default');
        return $this->render(
            'navbar',
            $data
        );
    }

    public function offlineFooter()
    {
        $this->lang->load('navigation/navigation_default');
        $data['footer_nav'] = $this->getFooterNav();

        return $this->render(
            'offline_footer',
            $data
        );
    }

    protected function getFooterNav()
    {
        $footerNav = [];
        return $footerNav;
    }
}
