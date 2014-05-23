# coding: utf-8

import json
from threading import Thread
from collections import defaultdict

from werkzeug.wrappers import Request, Response
from werkzeug.routing import Map, Rule


def async(func):
    '''A decorator for running task asynchronously.'''
    def wrapper(*args, **kwargs):
        thread = Thread(target=func, args=args, kwargs=kwargs)
        thread.start()

    return wrapper


class Simple(object):
    '''Simple application for listening & handling
    third party push events.
    '''

    #: Response function.
    #: This function will be used to generate response
    #: to the event pusher.
    response_func = Response('Roger that.', mimetype='text/plain')

    def __init__(self):
        #: A dictionary of all registered resolver.
        self.resolvers = {}

        #: A dictionary of all registered repos ~:class:`Repo`.
        self.repos = {}

        # Register some defaults resolver.
        self.register_provider('github')(github)

    @property
    def url_map(self):
        '''A :class:`~werkzeug.routing.Map` for the instance.

        The url map is generated dynamically from resolvers.
        '''
        rules = []
        for name, resolver in self.resolvers.items():
            rules.append(Rule(resolver['pattern'], endpoint=name))

        return Map(rules)

    def register_provider(self, name, pattern=None):
        '''Register a provider resolver.

        :param name: provider's name.
        :param pattern: provider's url pattern. Defaults to ``/{name}``
        '''
        pattern = pattern or '/{0}'.format(name)

        def register(func):
            if name in self.resolvers:
                assert self.resolvers[name]['handler'] is func, \
                    'A resolver\'s name collision occurred between {0} ' \
                    'and {1}. Both share the same name "{2}".'.format(
                        func.__name__,
                        self.resolvers[name]['handler'].__name__,
                        name
                    )
            else:
                self.resolvers[name] = dict(
                    handler=func,
                    pattern=pattern
                )
            return func

        return register

    def register_repo(self, repo):
        '''Register a repository.

        :param repo: repository to be registered.
        '''
        for provider in repo.providers:
            full_name = '{0}/{1}'.format(provider, repo.name)
            self.repos[full_name] = repo
        return self

    def resolve_provider(self, name, request, values):
        '''Run a provider resolver.

        :param name: provider's name.
        :param request: request data.
        :param values: extra values.
        '''
        resolver = self.resolvers[name]['handler']
        event_data = resolver(request, **values)

        # If the resolver doesn't want to handle this event,
        # just return ``None`` to ignore it.
        if event_data is None:
            return

        self.resolve_repo(event_data)

    def resolve_repo(self, event_data):
        '''Run a repository resolver.

        :param event_data: event data.
        '''
        provider = event_data.pop('provider')
        repo = event_data.pop('repo')
        event = event_data.pop('event')

        full_name = '{0}/{1}'.format(provider, repo)
        if full_name not in self.repos:
            return
        self.repos[full_name].resolve_event(event, event_data)

    def run(self, host=None, port=None):
        '''Run application.

        :param host: the hostname to listen on. Defaults to ``'127.0.0.1'``.
        :param port: the port of the webserver. Defaults to ``5678``.
        '''
        from werkzeug.serving import run_simple

        host = host or '127.0.0.1'
        port = int(port or 5678)

        run_simple(host, port, self)

    def dispatch_request(self, request):
        '''Handle incoming request.

        :param request: incoming request,
                        a :class:`~werkzeug.wrappers.Request` instance.
        '''
        adapter = self.url_map.bind_to_environ(request.environ)
        try:
            endpoint, values = adapter.match()
            async(self.resolve_provider)(endpoint, request, values)
        except Exception as e:
            print('Got unhandled exception here: {0}'.format(e))

        return self.response_func

    def wsgi_app(self, environ, start_response):
        request = Request(environ)
        return self.dispatch_request(request)(environ, start_response)

    def __call__(self, environ, start_response):
        '''Shortcut for :attr:`wsgi_app`.'''
        return self.wsgi_app(environ, start_response)


class Repo(object):
    '''Repository register.

    :param name: repository's name
    :param providers: repository's providers list
    '''

    def __init__(self, name, providers):
        self.name = name
        self.providers = providers

        #: A dictionary of all registred events.
        self.events = defaultdict(list)

    def register_event(self, event_name):
        '''Register an event.

        :param event_name: event's name
        '''
        def register(func):
            self.events[event_name].append(func)
            return func

        return register

    def resolve_event(self, event, income_data):
        '''Run event resolvers.

        :param name: event's name.
        :param income_data: provided data.
        '''
        for handler in self.events[event]:
            async(handler)(income_data)

    def __call__(self, event_name):
        '''Shortcut for :attr:`register_event`.'''
        return self.register_event(event_name)


# Here comes some bulitin resolvers.

def github(request):
    '''Resolver for GitHub webhook.'''
    # TODO Handle form format.
    content_type = request.headers.get('content-type')
    if content_type != 'application/json':
        print('Not supported content type: {0}'.format(content_type))
        return

    rv = dict(
        provider='github',
        event=request.headers.get('x-github-event')
    )

    # Just ping back when event is ``ping``.
    if rv['event'] == 'ping':
        return None

    income_data = json.loads(request.data)
    rv['repo'] = income_data['repository']['name']
    rv['branch'] = income_data['ref'].split('/')[-1]
    rv.update(income_data)

    return rv
