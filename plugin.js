(function () {
	tinymce.create('tinymce.plugins.overline', {

		init: function (ed, url) {
            ed.onInit.add(function() {
                ed.formatter.register('overline', {
                    inline: 'span',
                    styles: { textDecoration: 'overline' },
                    exact: true
                });
            });

			ed.addButton('overline', {
				cmd: 'overline',
				title: 'Overline',
                onclick: function() {
                    ed.formatter.toggle('overline');
                }
			});

			ed.onNodeChange.add(function(ed, cm, el, s) {
                cm.setActive('overline', ed.formatter.match('overline'));
			});
		},

		getInfo : function() {
			return {
				longname : 'Overline Button Plugin',
				author : 'h0tw1r3',
				authorurl : 'http://github.com/h0tw1r3/',
				infourl : 'http://github.com/h0tw1r3/wp-tinymce-overline',
				version : '1.0'
			};
		}

	});

	tinymce.PluginManager.add('overline', tinymce.plugins.overline);

}());
