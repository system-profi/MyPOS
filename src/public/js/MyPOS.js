// Login Model
// ----------

//Includes file dependencies
define(["app", "underscore", "jquery"], function(app) {
	"use strict";

	var MyPOS = {};

	MyPOS.RenderPageTemplate = function(View, Name, Template, Datas)
	{
	    // Sets the view's template property
            View.template = _.template(Template);

            var page = $('#' + Name);

            if(page.length > 0) {
                    page.remove();
            }

		//append the new page onto the end of the body
	    View.$el.append('<div data-role="page" id="' + Name + '">' + View.template(Datas) + '</div>');

		//initialize the new page
	    $.mobile.initializePage();

	};

	MyPOS.RenderDialogeTemplate = function(View, Name, Template, Datas)
	{
	    // Sets the view's template property
            View.template = _.template(Template);

            var page = $('#' + Name);

            if(page.length > 0) {
                    page.html(View.template(Datas));
            } else {
                    //append the new page onto the end of the body
                var dialoge = View.$el.append('<div data-role="page" id="' + Name + '" data-dialog="true" data-close-btn="none">' + View.template(Datas) + '</div>');

                //initialize the new page
                $.mobile.initializePage();
            }
	};

	MyPOS.ChangePage = function(View, options)
	{
		Backbone.history.navigate(View, true);
	}

	MyPOS.UnloadWebsite = function(result)
	{
		location.reload(true);
	}

	MyPOS.DisplayError = function(errorMessage)
	{
		alert(errorMessage);
	}

	MyPOS.KeepSessionAlive = function()
	{
		$.ajax({url: app.API + 'Utility/KeepSessionAlive/',
	        	dataType: 'json'
	    });
	}

	return MyPOS;

} );