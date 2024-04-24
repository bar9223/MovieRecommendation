# SSL setup guide with apache on host

1. Make sure that you have installed apache2 and certbot on host.
2. Enable proxy on host: `sudo a2enmod proxy_http`
3. Copy default config file `000-default-example.conf`to `000-default.conf` and make required changes
4. Copy certificate files into directory `ssl`
5. Configure domain on host:

```
<VirtualHost *:443>
    ServerName {DOMAIN_NAME}
    ServerAdmin webmaster@localhost

    ProxyPreserveHost On
    ProxyPass        "/" "https://127.0.0.1:{DOCKER_SSL_PORT}/"
    ProxyPassReverse "/" "https://127.0.0.1:{DOCKER_SSL_PORT}/"
    SSLProxyEngine On
    SSLProxyVerify none
    SSLProxyCheckPeerCN off
    SSLProxyCheckPeerName off
    SSLProxyCheckPeerExpire off

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    SSLCertificateFile /etc/letsencrypt/live/{DOMAIN_NAME}/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/{DOMAIN_NAME}/privkey.pem
    Include /etc/letsencrypt/options-ssl-apache.conf
    
</VirtualHost>

```

6. Restart container & apache2