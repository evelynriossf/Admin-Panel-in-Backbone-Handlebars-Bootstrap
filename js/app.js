$(document).ready(function() {

	// var currentUser = new User();
	// var loginView = new LoginView({el: $('#loginView'), model: currentUser});

	var app = new AdminListView();

});

Backbone.Collection.prototype.save = function (options) {
	Backbone.sync("patch", this, options);
};

Backbone.View.prototype.selectionChanged = function(e) {
	var field = $(e.currentTarget);
	var value = $("option:selected", field).val();
	var data = {};
	data[field.attr('name')] = value;
	this.model.set(data);
	console.log(data);
};

Backbone.View.prototype.fieldChanged = function(e) {
	var field = $(e.currentTarget);
	var data = {};
	data[field.attr('name')] = field.val();
	this.model.set(data);
	console.log(data);
};

function onYouTubeIframeAPIReady() {
	player = new YT.Player('youtube-video', {
		events: {
			'onReady': onPlayerReady,
            // 'onStateChange': onPlayerStateChange
        }
    });
}
	function onPlayerReady() {
		console.log("'Hey, I'm ready!' sez the YouTube API.");
    //do whatever you want here. Like, player.playVideo();

}
function getYTtime() {
	var currentTime = player.getCurrentTime();
	var hours = Math.floor(currentTime / 3600);
	var minutes = Math.floor((currentTime % 3600) / 60);
	var seconds =  Math.floor(currentTime % 60);
	var timeYT = {'currentTime': currentTime, 'hours': hours, 'minutes': minutes, 'seconds' : seconds};
	return timeYT;
}

