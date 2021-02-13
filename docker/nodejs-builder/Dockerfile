FROM node:12 as builder

RUN mkdir /usr/src/cache
WORKDIR /usr/src/cache

COPY /src/frontend/package.json .
COPY /src/frontend/yarn.lock .

RUN yarn install

WORKDIR /home/node
COPY .env /home/node/.env

COPY /src/frontend /home/node
RUN cp -r /usr/src/cache/node_modules/. /home/node/node_modules/

CMD [ "yarn", "build" ]