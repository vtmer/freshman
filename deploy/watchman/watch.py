# coding: utf-8

'''
    watch
    ~~~~~

    Watchman for freshman.
'''

from os import path

from fabric.api import lcd, local

from whysosimple import Simple, Repo


here = path.dirname(path.abspath(__file__))
base_config_path = path.join(here, 'configs')

CODE_PATHS = {
    'master': '/home/hbc/workshop/freshman/freshman-production',
    'develop': '/home/hbc/workshop/freshman/freshman-develop'
}


freshman = Repo('freshman', providers=['github'])
app = Simple()


@freshman('push')
def redeploy(income_data):
    branch = income_data['branch']
    codebase_path = CODE_PATHS[branch]
    configs_path = path.join(base_config_path, branch)

    with lcd(codebase_path):
        local('git pull --ff-only origin {0}'.format(branch))
        local('git checkout -f {0}'.format(branch))

        with lcd(path.join('backend', 'app', 'config')):
            local('cp -r {0}/* .'.format(configs_path))


if __name__ == '__main__':
    app.register_repo(freshman)

    app.run(host='0.0.0.0', port=9921)
