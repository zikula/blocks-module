<?php

declare(strict_types=1);

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\BlocksModule\Container;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;

class LinkContainer implements LinkContainerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PermissionApiInterface
     */
    private $permissionApi;

    public function __construct(
        TranslatorInterface $translator,
        RouterInterface $router,
        PermissionApiInterface $permissionApi
    ) {
        $this->translator = $translator;
        $this->router = $router;
        $this->permissionApi = $permissionApi;
    }

    public function getLinks(string $type = LinkContainerInterface::TYPE_ADMIN): array
    {
        if (LinkContainerInterface::TYPE_ADMIN === $type) {
            return $this->getAdmin();
        }

        return [];
    }

    /**
     * Get the admin links for this extension.
     */
    private function getAdmin(): array
    {
        $links = [];

        if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_EDIT)) {
            $links[] = [
                'url' => $this->router->generate('zikulablocksmodule_admin_view'),
                'text' => $this->translator->trans('Blocks list'),
                'icon' => 'table'
            ];
        }

        if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADD)) {
            $links[] = [
                'url' => $this->router->generate('zikulablocksmodule_block_new'),
                'text' => $this->translator->trans('Create new block'),
                'icon' => 'plus'
            ];

            $links[] = [
                'url' => $this->router->generate('zikulablocksmodule_position_edit'),
                'text' => $this->translator->trans('Create new block position'),
                'icon' => 'plus'
            ];
        }
        if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('zikulablocksmodule_config_config'),
                'text' => $this->translator->trans('Settings'),
                'icon' => 'wrench'
            ];
        }

        return $links;
    }

    public function getBundleName(): string
    {
        return 'ZikulaBlocksModule';
    }
}
