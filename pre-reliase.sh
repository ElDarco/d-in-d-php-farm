#!/usr/bin/env bash

#Prereliase script example
#./pre-reliase.sh token version

echo "$1" | docker login --username eldarco --password-stdin
docker build --compress -t eldarco/code-try:front-"$2" -f docker/nodejs-builder/Dockerfile .
docker tag eldarco/code-try:front-"$2" eldarco/code-try:front-latest
docker push eldarco/code-try:front-"$2"
docker push eldarco/code-try:front-latest


