define(["models/db/Ordering/Order"
], function(Order) {
    "use strict";

    return class OrderModify extends Order
    {
        defaults() {
            return _.extend(super.defaults(), {OrderDetails: new app.collections.Ordering.OrderDetailCollection()});
        }

        urlRoot() {
            return app.API + "Order";
        }
    }
});