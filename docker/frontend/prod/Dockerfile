FROM node:12 as builder

RUN mkdir /usr/src/cache
WORKDIR /usr/src/cache

COPY /src/frontend/package.json .
COPY /src/frontend/yarn.lock .

RUN yarn install

WORKDIR /home/node

COPY /src/frontend /home/node
COPY .env /home/node/.env

RUN cp -r /usr/src/cache/node_modules/. /home/node/node_modules/

RUN yarn run vue-cli-service build


FROM nginx:1.19

COPY /docker/frontend/prod/templates /etc/nginx/templates

COPY --from=builder /home/node/dist /var/www/frontend/dist

CMD ["nginx-debug", "-g", "daemon off;"]