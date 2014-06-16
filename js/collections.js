var AdminItems = Backbone.Collection.extend({
	model: AdminItem,
	comparator: 'order',

	initialize: function(){
		id = window.location.pathname.split("/").pop();
	},

	url: function(){
		return "/cocoadynamics/C/data/id/" + id;
	},

	// initialize: function () {_(this).bindAll('syncCollection');},

	// syncCollection: function() {
	// 	Backbone.sync('create', this);
	// },

	// updateModel: function(AdminItem) {
	// 	//console.log(AdminItem);
	// 	var inputName = '#'+AdminItem.get('inputName');
	// 	var userInput = $(inputName).val();
	// 	//console.log(userInput);
	// 	AdminItem.set({value: userInput});
	// },

});

var ChapterItems = Backbone.Collection.extend({
	model: ChapterItem,

	initialize: function(){
		console.log($('#modalLabel').data('pid'));
	},

	url: function(){
		return "/cocoadynamics/C/data/chapters/" + encodeURIComponent($('#modalLabel').data('pid'));
	},
});

var AttachItems = Backbone.Collection.extend({
	model: AttachItem,

	initialize: function(){
		id = window.location.pathname.split("/").pop();
	},

	url: function(){
		var filter = $('#search-text-attach').val();
		return "/cocoadynamics/C/data/search/" + encodeURIComponent(filter);
	},

});