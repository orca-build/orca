# ORCA

The Docker Image Generator allows you to define a template
for your docker image and generate various tags and versions from it.
This is done by adding blocks and variables for each tag.

Thus you do not have to maintain different and duplicate versions
of your image. You do only need to adjust what is actually different within certain tags.

This command will turn your template into all defined versions
like `php5.6`, `php7.1` and more:

```ruby
php orca.phar --directory=xyz
```


## Quick reference

Where to get help: https://www.orca-build.io

Where to file issues: https://github.com/orca-build/orca

Documentation: https://orca-build.io/docs

Maintained by: dasistweb GmbH (https://www.dasistweb.de)



## Copying / License
This repository is distributed under the MIT License (MIT). You can find the whole license text in the [LICENSE](LICENSE) file.
