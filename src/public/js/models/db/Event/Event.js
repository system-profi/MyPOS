define([
    "app"
], function(){
    "use strict";

    return class Event extends Backbone.Model {
        
        idAttribute() { return 'Eventid'; }

        defaults() {
            return {Eventid: 0,
                    Name: '',
                    Date: '',
                    Active: ''};
        }

    }
});