FROM devilbox/php-fpm:7.4-work

WORKDIR /var/www/application

EXPOSE 9000

CMD ["supervisord"]
