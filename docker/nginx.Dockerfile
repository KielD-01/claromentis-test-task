FROM nginx:stable

ARG HOSTNAME
RUN sed -i "s/server__name__replace/${HOSTNAME}/g" /etc/nginx/conf.d/default.conf

EXPOSE 80