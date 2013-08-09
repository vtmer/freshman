$(document).ready(function() {
    var qa_tmpl = _.template($('#qa-tmpl').html());

    var QAModel = Backbone.Model.extend({
        question: '', 
        answer: ''
    });

    var FAQCollection = Backbone.Collection.extend({
        model: QAModel
    });

    var QAView = Backbone.View.extend({
        tagName: 'li',
        template: qa_tmpl,

        events: {
            'click .title': 'toggle'
        },

        toggle: function() {
            var article = $('article', this.$el);

            if (article.hasClass('open')) {
                article.removeClass('open');
                $('.icon-minus-circled', article)
                    .removeClass('icon-minus-circled')
                    .addClass('icon-plus-circled');
            } else {
                article.addClass('open');
                $('.icon-plus-circled', article)
                    .removeClass('icon-plus-circled')
                    .addClass('icon-minus-circled');
            }

            return this;
        },

        render: function() {
            this.$el.html(this.template(this.model.attributes));

            return this;
        }
    });

    var QAListView = Backbone.View.extend({
        el: '#faq-list .list',
        qas: [],

        initialize: function() {
            this.listenTo(this.collection, 'change', this.render);
            this.listenTo(this.collection, 'add', this.addSubView);

            this.collection.fetch({ url: '/static/front/faq/faq.json' });
        },

        addSubView: function(model, collection, options) {
            var newQA = new QAView({ model: model });

            this.qas.push(newQA);
            this.$el.prepend(newQA.render().$el);
        },

        render: function() {
            return this;
        }
    });

    var faq = new FAQCollection();
    new QAListView({ collection: faq });
});
