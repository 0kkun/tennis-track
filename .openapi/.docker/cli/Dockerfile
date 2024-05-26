FROM node:16-alpine

WORKDIR /openapi

COPY ./src/package.json /openapi/

RUN npm install

CMD ["tail", "-f", "/dev/null"]