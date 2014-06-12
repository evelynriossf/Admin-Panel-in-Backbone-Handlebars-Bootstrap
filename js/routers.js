AdminApp.Router = Backbone.Router.extend({
	routes: {
		"": "defaultRoute"
	},

	defaultRoute: function(){
		console.log("defaultRoute");
		AdminApp.nodes = new AdminApp.Collections.Nodes();
		var nodeview = new AdminApp.Views.Nodes({collection: AdminApp.nodes});
		AdminApp.nodes.fetch();
		console.log(AdminApp.nodes.length);
	}
})

var appRouter = new AdminApp.Router();
Backbone.history.start();


// var items = new AdminItems();
// var adminView = new AdminApp.Views.Movies({collection: nodes});
