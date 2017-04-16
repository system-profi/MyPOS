<?php

namespace API\Models\Menu;

use API\Lib\Interfaces\Models\Menu\IMenuExtra;
use API\Lib\Interfaces\Models\Menu\IMenuExtraCollection;
use API\Lib\Interfaces\Models\Menu\IMenuExtraQuery;
use API\Models\ORM\Menu\MenuExtraQuery as MenuExtraQueryORM;
use API\Models\Query;

class MenuExtraQuery extends Query implements IMenuExtraQuery
{
    public function find(): IMenuExtraCollection
    {
        $menuExtras = MenuExtraQueryORM::create()->find();

        $menuExtraCollection = $this->container->get(IMenuExtraCollection::class);
        $menuExtraCollection->setCollection($menuExtras);

        return $menuExtraCollection;
    }

    public function findPk($id): IMenuExtra
    {
        $menuExtra = MenuExtraQueryORM::create()->findPk($id);

        $menuExtraModel = $this->container->get(IMenuExtra::class);
        $menuExtraModel->setModel($menuExtra);

        return $menuExtraModel;
    }
}
