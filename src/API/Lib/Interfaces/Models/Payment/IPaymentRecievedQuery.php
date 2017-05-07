<?php

namespace API\Lib\Interfaces\Models\Payment;

use API\Lib\Interfaces\Models\IQuery;

interface IPaymentRecievedQuery extends IQuery {

    public function getDetailsForInvoice(int $invoiceid): IPaymentRecievedCollection;
}