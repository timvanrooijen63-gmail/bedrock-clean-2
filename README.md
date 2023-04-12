# WordPress Bedrock example
This is a [Bedrock](https://roots.io/bedrock/) setup example for
[Forest.host](https://forest.host).
The goal of this repository is to provide a WordPress setup that
we can build and deploy on [Forest](https://forest.host) and locally!

**Contents**
1. [Composer & Bedrock](#composer--bedrock)
2. [How to use this setup?](#how-to-use-this-setup)
3. [Deploy on Forest.host](#deploy-on-forest-host)

## Composer & Bedrock
This package uses [Composer](https://getcomposer.org/) to install WordPress,
plugins and themes. The Bedrock setup helps us making more sense of the
environment (configuration, folder setup).

## How to use this setup?
### Starting a new project
Each project needs it's own repository. We use this repository as a blueprint
for that.
1) Fork or copy this repository providing it with the name of the project
2) Edit the file `.env.example`. In this file you want to change:
    1) `WP_HOME` - this is the url of the site
    2) Salts - for security dont forget to create and add keys
3) Make other desired changes

### Editing
To make changes to this site, meaning plugins, themes and configuration and not
content and WordPress admin related stuff, you need to edit this repository.
For more visit [Bedrock](https://roots.io/bedrock).
1) Clone/pull this repository
2) Make desired changes
3) If composer.json was edited run: `composer update`
4) Test:
    - Minimal test run: `composer install --prefer-dist --no-interaction`
    - Full test. Run: `composer install --prefer-dist --no-interaction` and
      setup a (local) server to test the site.
5) Push changes (if connected to Forest, this will be build and deployed)

#### Adding plugins and themes
Plugins and themes are managed by Composer. To add additional plugins and
themes, add them to the Composer file.
Make sure to check if the plugins/themes exist. You can search for their
existence here: https://wpackagist.org/.
After adding plugins and themes run: `composer update` and commit the changes.

#### Adding pro-plugins
Paid plugins are often not part of the WordPress.org repository. Therefore we
need to add the manually. The strategy of this setup is to add them to the
repository.
1) Add the plugin folder to either `web/app/plugins/` or `web/app/mu-plugins/`
    - Note that `mu-plugins` stands for "must use". These plugins cannot be
      turned off and therefore are always activated. In order to deactivate such
      a plugin you'll need to remove it from this repository and redeploy.
2) Add a line to `.gitignore` telling GIT to not ignore this plugin.
    - Say we want to add `wordpress-seo`. In that case the line in `.gitignore`
    will be: `!web/app/plugins/wordpress-seo/`

#### Notes on folder structure
Also good to knows:
- Dont add files to / change files in:
    - `web/wp`
    - `web/app/uploads`
- Dont change the following files:
    - All files in above directories
    - `web/wp-config.php`
    - `web/index.php`


## Deploying on Forest.host
On Forest we have to setup a project and environment. An environment is linked
to a branch in a repository. Thus we can have a single project (`mysite.nl`)
with 2 branches (`master` and `staging`) and 2 environment on Forest (`master`
and `staging`). Both can have their own configuration. By setting `WP_ENV` as an
environment variable on Forest we can tell Bedrock which configuration to use.
The configurations for environments can be found here: `config/environments/`.
So if we set `WP_ENV` to `production` on Forest we tell it to load the
configuration file: `config/environments/production.php`.

Now let's get started setting everything up on Forest:
1) Create a project/environment (give it a name and correct branch)
2) We can pick the `Bedrock on PHP` blueprint as that is fully configured for
this setup already
3) In the `PHP` service tile select this repository
4) Click on `Go to edit mode`
5) We need to add the following build command to the PHP service:
    - `composer install --prefer-dist --no-interaction`
6) The deploy path for this project is: `/`
7) We can now save this by clicking on `Create project` or `Create environment`
8) Navigate to `variables` and add `WP_ENV` as a variable with the value of the
configuration file you want to use. In most cases this will be `production`.

This repository already includes configuration for a `production` and `staging`
environment on Forest (see: `/config/environments/production.php and
staging.php`). Here you'll see that the database credentials are provided as
environment variables by Forest.

Forest has now linked this environment to this repository's given branch.
All we need to do now is deploy!
A deploy is triggered by a new commit the repository. Make some nice changes and
when you do `git push` you'll be seeing the build running on Forest!

### Adding domains
Before you add a domain to your environment on Forest make sure the domain
points to Forest's loadbalancer.
1) Point the domain to `45.135.56.67` (using an A-record or Cname)
2) When the DNS is resolved you can add it to Forest

### Deploy!
Always test locally first! At the very least run Composer (`composer install`) so you know it wont
error when building on Forest.
At this point we have setup our repository with the projects code and an environment on Forest.
GitHub let's Forest know when changes are made to this repository. When Forest
spots a change in the branch that is connected it will clone the code from this
repository, run the build commands and if there are no errors it will deploy
this code.
So to trigger a deploy on Forest, all you need to do is:
`git push origin MY_BRANCH` (Where `MY_BRANCH` is the environment/branch name.
So most of the times this will be `master`, `staging`, or `testing`.

