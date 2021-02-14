#!/bin/bash

rm -rf /home/node/dist/*
yarn build
cp -r /home/node/dist/* /home/dist/