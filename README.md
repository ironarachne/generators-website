# Generators Website

This is the website that consumes all of the generators produced here.

## Sample Stack File

This is meant to be deployed to Docker. The following is an appropriate stack file:

```YAML
version: '3.3'

services:
  website:
    image: ironarachne/generators-website:latest
    ports:
      - "8080:80"
    environment:
      APP_URL: http://localhost:8080
      CULTUREGENAPI: culturegenapi:9913
      HERALDRYAPI: heraldryapi:7476
      REGIONGENAPI: regiongenapi:7970
      REDISHOST: redis
    networks:
      - ironarachne

  culturegenapi:
    image: ironarachne/culturegend:latest
    networks:
      - ironarachne

  heraldryapi:
    image: ironarachne/armsapi:latest
    networks:
      - ironarachne

  redis:
    image: redis:latest
    networks:
      - ironarachne

  regiongenapi:
    image: ironarachne/regiongend:latest
    networks:
      - ironarachne

networks:
  ironarachne:
```