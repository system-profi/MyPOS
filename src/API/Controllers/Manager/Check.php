<?php

namespace API\Controllers\Manager;

use API\Lib\Interfaces\Helpers\IJsonToModel;
use API\Lib\Interfaces\Helpers\IValidate;
use API\Lib\Interfaces\IAuth;
use API\Lib\Interfaces\Models\Event\IEventBankinformationQuery;
use API\Lib\Interfaces\Models\Event\IEventContactQuery;
use API\Lib\Interfaces\Models\IConnectionInterface;
use API\Lib\Interfaces\Models\Invoice\IInvoice;
use API\Lib\Interfaces\Models\Invoice\IInvoiceItem;
use API\Lib\Interfaces\Models\Invoice\IInvoiceQuery;
use API\Lib\Interfaces\Models\Ordering\IOrderDetailQuery;
use API\Lib\Interfaces\Models\User\IUserQuery;
use API\Lib\SecurityController;
use const API\USER_ROLE_MANAGER_CALLBACK;
use const API\USER_ROLE_MANAGER_CHECK_SPECIAL_ORDER;
use DateTime;
use Respect\Validation\Validator as v;
use Slim\App;
use Symfony\Component\Config\Definition\Exception\Exception;
use const API\USER_ROLE_INVOICE_ADD;
use const API\USER_ROLE_INVOICE_OVERVIEW;

class Check extends SecurityController
{
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->security = ['GET' => USER_ROLE_MANAGER_CHECK_SPECIAL_ORDER];

        $this->container->get(IConnectionInterface::class);
    }

    public function get() : void
    {
        $auth = $this->container->get(IAuth::class);
        $orderDetailQuery = $this->container->get(IOrderDetailQuery::class);
        $user = $auth->getCurrentUser();

        $orderDetails = $orderDetailQuery->getUnverifiedOrders($this->args['verified'], $user->getEventUsers()->getFirst()->getEventid());

        $this->withJson($orderDetails->toArray());
    }

}