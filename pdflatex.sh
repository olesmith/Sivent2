#!/bin/sh

/data/phpexec/pdflatex -interaction nonstopmode -output-directory $1 $1/$2 > $1/latex.log  2>&1

#/usr/bin/pdflatex  -output-directory $1 $1/$2 > $1/latex.log 2>&1


