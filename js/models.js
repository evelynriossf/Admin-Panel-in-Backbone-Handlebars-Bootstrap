var AdminItem = Backbone.Model.extend({
	defaults: {
		id: '',
		name: '',
		short_description: '',
		description: '',
		url: '',
		thumbnail: 'no-thumbnail.gif',
		order: '',
		tags: '',
	},

	// initialize: function() {
		// this.set("visibility", this.get("visibility").split(""));
		// for (i=0; i<this.get("visibility").length; i++){
		// 	if (this.get("visibility")[i] == 1){
		// 		this.get("visibility")[i] = "checked";
		// 	}
		// }
		// return this.get("visibility");
// 	}
});

var ChapterItem = Backbone.Model.extend({
	defaults: {
		id:'',
		title: '',
		currentTime: '',
		hours: '',
		minutes: '',
		seconds: '',
	},
});

var AttachItem = Backbone.Model.extend({
	defaults: {
		id:'FakeID',
		title: 'Untitled',
	},
});


// var User = Backbone.Model.extend({
// 	logIn: function(userName, password) {
// 		if(!userName || !password) return;
// 		this.set({userName: userName});
// 		this.set({password: password});
// 	},

// 	isLoggedIn: function() {
// 		return this.has('userName');
// 	},
// });
