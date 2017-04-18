<?php

namespace API\Lib\Interfaces\Models\Ordering;

use API\Lib\Interfaces\Models\IQuery;

interface IOrderDetailQuery extends IQuery {
    function getDistributionUnfinishedByMenuid($menuid) : IOrderDetailCollection;
    function getDistributionUnfinishedByMenuExtraid($menuExtraid) : IOrderDetailCollection;
    function setAvailabilityidByOrderDetailIds(int $availabilityid, array $ids) : int;
    function getVerifiedDistributionUnfinishedWithSpecialExtras(): IOrderDetailCollection;
}