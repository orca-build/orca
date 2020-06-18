## Image php-image

## docker-compose.yml

```ruby
app:
    container_name: app
    image: dasistweb/php-image:php7.4
    ports:
        - "1000:80"
        - "1022:22"
    environment:
        - XDEBUG_ENABLED=0
```