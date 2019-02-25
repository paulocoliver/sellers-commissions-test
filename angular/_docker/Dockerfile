FROM node:latest as build
WORKDIR /app
COPY ./package.json /app/
RUN npm i npm@latest -g
RUN npm install
COPY . /app/
ARG env=prod
RUN npm run build -- --output-path=./dist/out

FROM nginx:1.15
COPY --from=build /app/dist/out/ /usr/share/nginx/html
COPY ./_docker/nginx-custom.conf /etc/nginx/conf.d/default.conf