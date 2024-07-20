FROM node:16-alpine

WORKDIR /openapi

COPY ./package.json /openapi/package.json

RUN npm install

CMD ["tail", "-f", "/dev/null"]
