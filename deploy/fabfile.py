# coding: utf-8

from fabric.api import env, task, require
from fabric.api import cd, run, sudo, put


env.nginx_conf_dir = '/etc/nginx/sites-enabled'
env.www = '/var/www/freshman'


@task
def production():
    env.hosts = ['106.186.120.207']
    env.name = 'production'
    env.codebase = '~/workshop/freshman/freshman-production'
    env.nginx_conf = 'server.nginx.conf'


@task
def develop():
    env.hosts = ['106.186.120.207']
    env.name = 'develop'
    env.codebase = '~/workshop/freshman/freshman-develop'
    env.nginx_conf = 'server.dev.nginx.conf'


@task
def update():
    require('codebase')
    with cd(env.codebase):
        run('git reset --hard HEAD')
        run('git pull')

        with cd('backend'):
            run('~/workshop/bin/composer update')


@task
def bootstrap():
    require('www')
    require('codebase')
    require('nginx_conf')
    require('nginx_conf_dir')

    # Setup directories.
    storage_dir = '{0}/app/storage'.format(env.name)

    sudo('mkdir -p {0}'.format(env.www))
    with cd(env.www):
        sudo('rm -rf {0}'.format(env.name))
        sudo('cp -r {0}/backend {1}'.format(env.codebase, env.name))
        sudo('rm -rf {0}/vendor'.format(env.name))
        sudo('ln -s {0}/backend/vendor {1}/vendor'.format(env.codebase,
                                                          env.name))
        sudo('rm -rf {0}/app/config'.format(env.name))
        sudo('ln -s {0}/backend/app/config {1}/app/config'.format(env.codebase,
                                                                  env.name))

        sudo('chown {0}:www-data {1}'.format(env.user, env.name))
        sudo('chmod -R 755 {0}'.format(env.name))
        sudo('chmod -R 777 {0}'.format(storage_dir))

    # Setup nginx.
    with cd(env.nginx_conf_dir):
        put('conf/{0}'.format(env.nginx_conf), env.nginx_conf, use_sudo=True)
    sudo('service nginx restart')
