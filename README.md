# Generators Website

This is the website that consumes all of the generators produced here.

## Sample Stack File

This is meant to be deployed to Docker. The following is an appropriate stack file:

```
version: '3.3'

services:
  website:
    image: ironarachne/generators-website:latest
    networks:
      - ironarachne

  culturegenapi:
    image: ironarachne/culturegend:latest
    networks:
      - ironarachne

  db:
    image: mariadb:10.3
    restart: always
    networks:
      - ironarachne
    environment:
      MYSQL_ROOT_PASSWORD: "${MYSQL_ROOT_PASSWORD}"

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