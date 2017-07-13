var feedItemTemplate = require('../feed-item/feed-item.pug');

var _ = _ || {};
_.each = require('lodash.foreach');
_.flatten = require('lodash.flatten');
_.groupBy = require('lodash.groupby');
_.map = require('lodash.map');
_.maxBy = require('lodash.maxby');
_.sortBy = require('lodash.sortby');

var he = require('he');

var moment = require('moment');
moment.locale('fr');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.feed = (function(){

	function module(selector){
		var $el = $(selector),
			$content,
			apiUrls = {},
			maxItems = 8, // ?
			data = {
				items: []
			};

		function init(){
			$content = $el.find('.feed-items');
			var userId = $el.data('userId');
			//userId = 21236; //debug compte Mathias

			// Get the URL to the API from the data-* attribute
			apiUrls = {
				actualites: 'http://localhost/test/wp-json/wp/v2/posts?author=' + userId + '&_embed',
				observations: 'https://api.tela-botanica.org/service:del:0.1/observations?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&masque.auteur=' + userId,
				images: 'https://api.tela-botanica.org/service:del:0.1/images?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&format=CRS&masque.auteur=' + userId,
				_observations: 'http://localhost/service:del:0.1/observations?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&masque.auteur=' + userId,
				_images: 'http://localhost/service:del:0.1/images?navigation.depart=0&navigation.limite=50&tri=date_transmission&ordre=desc&format=CRS&masque.auteur=' + userId
			};

			loadData();
		}

		function loadData(){
			// Call the APIs
			$.when(loadActualites(), loadObservations(), loadImages())
				.done(renderContent)
				.fail(function(){
					console.log('FAIL');
				});
		}

		function loadActualites() {
			return $.getJSON(apiUrls.actualites, function(json){
				_.each(json, function (item) {
					var categories = 'wp:term' in item._embedded ? _.map(item._embedded['wp:term'][0], function(term) {
						return term.name;
					}) : [];
					categories = categories.join(', ');
					data.items.push({
						type: 'feed-item',
						article: true,
						href: item.link,
						image: 'wp:featuredmedia' in item._embedded ? item._embedded['wp:featuredmedia'][0].media_details.sizes.thumbnail.source_url : false,
						title: he.decode(item.title.rendered),
						date: item.modified,
						day: item.modified.substring(0,10),
						text: item.excerpt.rendered,
						meta: {
							categories: categories
						}
					});
				});
			});
		}

		function loadObservations() {
			return $.getJSON(apiUrls.observations, function(json){
				_.each(json.resultats, function (item) {
					data.items.push({
						type: 'feed-item',
						href: 'http://www.tela-botanica.org/appli:identiplante#obs~' + item.id_observation,
						target: '_blank',
						image: ('images' in item && item.images.length) ? item.images[0]['binaire.href'].replace('XL.', 'CRXS.') : false,
						title: item['determination.ns'],
						date: item.date_transmission,
						day: item.date_transmission.substring(0,10),
						text: "Nouvelle observation ajoutée au Carnet en Ligne",
						meta: {
							place: item.zone_geo
						}
					});
				});
			});
		}

		function loadImages() {
			return $.getJSON(apiUrls.images, function(json){
				var images = [];
				_.each(json.resultats, function (item) {
					var date = item.observation.date_transmission;
					images.push({
						date: date,
						day: date.substring(0,10),
						image: item['binaire.href']
					});
				});

				// grouper par jour
				var imagesByDay = _.groupBy(images, 'day');

				// pousser des multi-items
				_.each(imagesByDay, function (item, day) {
					data.items.push({
						type: 'feed-item',
						href: 'http://www.tela-botanica.org/appli:cel',
						target: '_blank',
						images: _.map(item, 'image').slice(0,maxItems),
						title: item.length + ' photo' + (item.length > 1 ? 's' : '') + ' ajoutée' + (item.length > 1 ? 's' : ''),
						date: _.maxBy(item, 'date').date,
						day: item[0].day,
						text: 'Au Carnet en Ligne',
						meta: {
							text: ''
						}
					});
				});
			});
		}

		function renderContent(){
			data.items = _.sortBy(data.items, 'date');
			data.items = data.items.reverse();
			data.items = _.groupBy(data.items, 'day');
			var groupedItems = [];
			for (var day in data.items) {
				var d = data.items[day];
				groupedItems.push({
					type: 'feed-date',
					text: moment(d[0].date).calendar()
				});
				groupedItems.push(data.items[day]);
			}
			data.items = _.flatten(groupedItems);

			var content = '';
			_.each(data.items, function(item){
				content += feedItemTemplate({data: item});
			});
			$content.append(content);
		}


		init();

		return $el;
	}

	return function(selector){
		return $(selector).each(function(){
			module(this);
		});
	};

})();

$(document).ready(function(){
	Tela.modules.feed('.feed');
});
