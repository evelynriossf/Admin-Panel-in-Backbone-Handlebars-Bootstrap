// The Item View
var AdminItemView = Backbone.View.extend({
	tagName: 'div',
	className: 'col-sm-12 item',

	render: function() {
		var template = Handlebars.compile($("#data-template").html());
		var rendered = template(this.model.toJSON());
		this.$el.html(rendered);
		return this;
	},

	events: {
    'click .submit':'submitItem',
    'click .delete': 'deleteItem',
    'click .chapterMarkers' : 'editChapterMarkers',
    'click .stepIn' : 'stepIn'
  },

  submitItem: function(e) {
    e.preventDefault();
    var formData = {};
    $("#" + this.model.id).find(":input.form-control").each(function() {
      formData[ this.name ] = $(this).val().trim();
    });
    this.model.save(formData, {patch: true});
    return false;
  },

  deleteItem: function(e) {
    e.preventDefault();
    var result = confirm("Are you sure you want to delete?");
    if (result==true) {
     this.model.destroy();
      //Delete view from window
      $(this.el)
      .fadeOut("slow")
      .promise()
      .done(function(){
      	this.remove();
      });
    }
  },

  editChapterMarkers: function(e) {
    e.preventDefault();
    var modalTemplate = Handlebars.compile($("#modal-template").html());
    var modalRendered = modalTemplate(this.model.toJSON());
    this.$el.append(modalRendered);
    $('.modal').on('hidden.bs.modal', function (e) {
      $('.modal').remove();
    });
    var chapterMarkers = new ChapterMarkersView();
    return this;
  },

  stepIn: function(e){
   e.preventDefault();
   var itemID = $(e.currentTarget).data('id');
   console.log(itemID);
   location.href = "../edit/"+ itemID;
 }

      }); // End Item View



var AdminListView = Backbone.View.extend({
 el: "#data-wrapper",

 tagname: "div",

 _listItems: null,

 orderAttr: 'order',

 initialize: function() {
  this.collection = new AdminItems();
  this.collection.fetch({reset: true});
  this.listenTo( this.collection, 'reset', this.render);
  this.listenTo( this.collection, 'add', this.renderTop);
},

    // render collection by rendering each item
    //artificially set an order attribute on the models
    render: function() {
    	this._listItems = {};
    	i=0;
    	this.collection.each(function(item){
    		this.renderItem(item);
    	}, this );
    },

    // render an item by creating an ItemView and appending the
    // element it renders to the collection's element
    renderItem: function( item ) {
    	item.set({order: i});
    	i++;
    	var itemView = new AdminItemView({
    		model: item
    	});
    	$('#items-div').sortable({
        forcePlaceholderSize: true,
        opacity: 0.5,

      });
    	$('#items-div').append( itemView.render().el );
    },

    renderTop: function( item ) {
      item.set({order: i});
      i++;
      var itemView = new AdminItemView({
        model: item
      });
      $('#items-div').sortable({
        forcePlaceholderSize: true,
        opacity: 0.5,
      });
      $('#items-div').prepend( itemView.render().el );
      this.trigger('sortupdate');
    },

    events: {
    	'click #add' : 'addItem',
    	'sortupdate' : 'changeSortOrder',
    	'click #attach' : 'attachItem',
    },

    addItem: function(e) {
      e.preventDefault();
      this.collection.create(null, {wait: true});
    },

    attachItem: function(e) {
    	e.preventDefault();
    	var attachItems = new AttachListView();
    },

   /**
   * Respond to the Sortable's update event.
   * Iterate over each view in the list and use its position relative to its siblings to set the ordering attribute on the associated model.
   * This does not appear to trigger a resort on the collection so explicitly do this so downstream processing is working with the
   * right order of the models.
   */

   changeSortOrder: function () {
   	var oatr = this.orderAttr;
   	_.each( this._listItems, function ( v ) {
      console.log(v);
      console.log(v.model);
      console.log(v.$el.index());
      v.model.set(oatr, v.$el.index());
    });
   	this.collection.sort({silent: true});
   },
 });



//**Chapter Marker View **
var ChapterMarkerView = Backbone.View.extend({

  tagName: 'div',
  className: 'chapterContainer',
  template: Handlebars.compile($("#chapters-template").html()),

  render: function() {
        //this.el is what we defined in tagName. use $el to get access to jQuery html() function
        Handlebars.registerHelper('selected', function(time, option) {
        	return time == option ? ' selected' : '';
        });
        this.$el.html(this.template(this.model.toJSON()));
        return this;
      },

      events: {
      	'click .deleteChapter' : 'deleteChapter',
      	"change input": "fieldChanged",
      	"change select": "selectionChanged",
        'click .cue' : 'cue',
      },

      deleteChapter : function(e) {
      	e.preventDefault();
      	var chapterDeleteCheck = confirm("Are you sure you want to delete?");
      	if (chapterDeleteCheck == true) {
          //Delete model from server
          this.model.destroy();
            //Delete view from window
            $(this.el)
            .fadeOut("slow")
            .promise()
            .done(function(){
            	this.remove();
            });
          }
        },

        cue: function(e) {
          e.preventDefault;
          player.seekTo(this.model.get('currentTime'));
        }

      });


//**Chapter Markers View **
var ChapterMarkersView = Backbone.View.extend({
  el: "#chaptersCollection-div",

  initialize: function() {
    this.collection = new ChapterItems();
    this.collection.fetch({reset: true});
    this.render();
    this.listenTo( this.collection, 'reset', this.render);
    this.listenTo( this.collection, 'add', this.renderChapter);
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    var player;
  },

  events: {
    'click #addChapter' : 'addChapterMarker',
    'click #saveChapters' : 'saveChapters',
    'click #addChapterAuto' : 'addChapterAuto',
  },

  render: function() {
    this.collection.each(function( item ) {
      this.renderChapter( item );
    }, this );
  },

  renderChapter: function( item ) {
    var chapterView = new ChapterMarkerView({
      model: item
    });
    this.$el.append( chapterView.render().el );
  },

  reset: function() {
    e.preventDefault();
    Handlebars.registerHelper('selected', function(time, option) {
      return time == option ? ' selected' : '';
    });
    return this;
  },

  addChapterMarker : function(e) {
    e.preventDefault();
    var time = getYTtime();
    this.collection.create(time);
  },

  saveChapters : function(e) {
  	e.preventDefault();
  	this.collection.save();
  },

  addChapterAuto: function(e) {
    e.preventDefault();
  },

  saveChapters : function(e) {
   e.preventDefault();
   this.collection.save({patch: true});
 },
});



// The Attach Item View
var AttachItemView = Backbone.View.extend({
	tagName: 'div',
	className: 'col-sm-12 attachItem',
	events : {
		'click .itemAttach' : 'attachMe',
	},
	render: function() {
		var template = Handlebars.compile($("#attach-template").html());
		var rendered = template(this.model.toJSON());
		this.$el.html(rendered);
		return this;
	},
	attachMe: function (e) {
		id = window.location.pathname.split("/").pop();
		var element = $(e.currentTarget);
		element.addClass('disabled');
		$.ajax({
			url: '/cocoadynamics/C/data/attach/' + id + '/' + this.model.id,
			type: 'post'
		}).done(function() {
			element.html('Success');
		}).fail(function() {
			element.removeClass('disabled');
			element.html('Failed, try again?');
		});
	},
});
      // End Item View



//***The Attach List View***

var AttachListView = Backbone.View.extend({
	el: "#attach-modalContent",
	events: {
		'click #search-attach' : 'searchAttach',
	},
	searchAttach : function (e) {
		this.collection = new AttachItems();
		this.collection.fetch({reset: true});
		this.listenTo( this.collection, 'reset', this.render);
		$('#attach-item-list').empty();
	},
	renderResult : function(result) {
		var resultView = new AttachItemView({
			model : result
		});
		$('#attach-item-list').append(resultView.render().el);
	},
	render : function() {
		this.collection.each(function (result) {
			this.renderResult(result);
		}, this );
	},
});


// var LoginView = Backbone.View.extend({

// 	events: {
// 		"click #logIn": "login"
// 	},

// 	initialize: function() {
// 		this.listenToOnce(this.model, "change", this.render);
// 	},

// 	render: function() {
// 		this.$el.toggleClass("hidden", this.model.isLoggedIn());
// 		var items = new AdminItems();
// 		var adminView = new AdminItemsView({collection: items});
// 		$('.data-wrapper').append(adminView.render().$el);
// 		return this;
// 	},

// 	login: function() {
// 		this.model.logIn(this.$("#userName").val(), this.$("#password").val());
// 	}

// });
