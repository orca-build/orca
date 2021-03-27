## Image simple

## docker-compose.yml

```ruby
app:
    container_name: app
    image: dasistweb/simple:latest
    ports:
        - "1000:80"
        - "1022:22"
    environment:
        - XDEBUG_ENABLED=0
```