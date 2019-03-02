#!/bin/bash

# check if sassc is available
if ! hash sassc 2>/dev/null; then
   echo >&2 "'sassc' not installed. Aborting."; exit 1;
else
   echo "Compiling css...";
fi

# prism
sassc prism/hvitur-prism-dark.scss                ../css/hvitur-prism-dark.css
sassc prism/hvitur-prism-dark.scss  -t compressed ../css/hvitur-prism-dark.min.css
sassc prism/hvitur-prism-light.scss               ../css/hvitur-prism-light.css
sassc prism/hvitur-prism-light.scss -t compressed ../css/hvitur-prism-light.min.css

# hvitur/bootstrap
sassc hvitur/hvitur.scss               ../css/hvitur.css
sassc hvitur/hvitur.scss -t compressed ../css/hvitur.min.css

echo "Finished"; exit 0;
