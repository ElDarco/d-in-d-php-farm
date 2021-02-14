FROM node:12 as builder

RUN mkdir /usr/src/cache
WORKDIR /usr/src/cache

COPY /src/frontend/package.json .
COPY /src/frontend/yarn.lock .

RUN yarn install

WORKDIR /home/node

COPY /src/frontend /home/node
COPY .env.orig /home/node/.env

RUN cp -r /usr/src/cache/node_modules/. /home/node/node_modules/

RUN rm -rf /home/node/dist/*

RUN yarn run vue-cli-service build