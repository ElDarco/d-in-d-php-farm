#!/usr/bin/env bash

#Prereliase script example
#./pre-deploy.sh token

echo "$1" | docker login --username eldarco --password-stdin
docker pull eldarco/code-try:front-latest


