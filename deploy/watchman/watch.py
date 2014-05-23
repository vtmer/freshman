# coding: utf-8

'''
    watch
    ~~~~~

    Watchman for freshman.
'''

from fabric.api import lcd, local

from whysosimple import Simple, Repo


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

    with lcd(codebase_path):
        local('git pull --ff-only origin {0}'.format(branch))
        local('git checkout -f {0}'.format(branch))


if __name__ == '__main__':
    app.register_repo(freshman)

    app.run(host='0.0.0.0', port=9921)
