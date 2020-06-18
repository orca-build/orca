# ORCA

[![Build Status](https://travis-ci.org/orca-build/orca.svg?branch=master)](https://travis-ci.org/orca-build/orca)
[![MIT licensed](https://img.shields.io/github/license/orca-build/orca.svg?style=flat-square)](https://github.com/orca-build/orca/blob/master/LICENSE)


Build and maintain many Docker images with the full power of a templating engine and additional developer features.


## How does ORCA work?
Orca is a PHAR executable which is based on the TWIG templating engine.
It allows you to generate different Docker files for building, based on
inheritance and shared components and templates.

The generated isolated Docker files can then be used to build your images when you're ready.

Just roll out global changes on all images and tags by simply adding it to a "global" template.

And the best thing, due to Twig, you're completely flexible in how
you want to build and maintain your image files.

If you're ready, just execute this command:

```ruby
php orca.phar --directory=xyz
```



## Quick reference

Where to get help: https://www.orca-build.io

Where to file issues: https://github.com/orca-build/orca

Documentation: https://orca-build.io/docs

Maintained by: dasistweb GmbH (https://www.dasistweb.de)



## Contribute
ORCA is Open Source - so yes, we'd be happy if you decide to contribute.

You can use the prepared `makefile` to get started.
Just run this command to install everything you need.

```ruby 
make install
```

Unit Tests can be started with:
```ruby 
make test
```


## Copying / License
This repository is distributed under the MIT License (MIT). 
You can find the whole license text in the [LICENSE](LICENSE) file.
