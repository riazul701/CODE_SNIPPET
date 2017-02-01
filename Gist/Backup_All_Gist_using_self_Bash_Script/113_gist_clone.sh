#!/bin/bash

while read line
do
IFS='^'   #It is separator of string
set $line   #Set string for IFS
id=$1
description=$2
git clone https://gist.github.com/riazul704/$id
done <info.txt
