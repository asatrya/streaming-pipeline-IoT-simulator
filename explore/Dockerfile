FROM ubuntu:18.04

# Install tools
RUN apt-get update
RUN apt-get install nano -y
RUN apt-get install ufw -y

# set timezone
ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install apache
RUN apt-get install apache2 -y
RUN apt-get install php libapache2-mod-php php-mysql -y

# Copy conf files
COPY image-files/ /

# Configure SSL
RUN apt-get install software-properties-common -y
RUN add-apt-repository ppa:certbot/certbot
RUN apt-get install python-certbot-apache -y
RUN a2enmod ssl
RUN a2enmod headers
RUN a2ensite default-ssl
RUN a2enconf ssl-params
RUN apache2ctl configtest

# Create app folder
WORKDIR /var/www/html
COPY . .

# Expose port
EXPOSE 80 443

ENTRYPOINT ["apachectl", "-DFOREGROUND"]
# CMD ["tail", "-f", "/dev/null"]