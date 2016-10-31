define([
    "models/db/Event/Event",
    "app"    
], function(Event){
    "use strict";

    return class DistributionPlaceGroup extends Backbone.Model {

        idAttribute() { return 'DistributionPlaceid'; }
        
        defaults() {
            return {DistributionPlaceid: 0,
                    Eventid: 0,
                    Name: ''};
        }

        parse(response)
        {
            if('Event' in response)
            {
                response.Event = new Event(response.Event, {parse: true});
            }
            
            return super.response(response);
        }
    }
});