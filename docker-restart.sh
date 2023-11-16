#!/bin/bash
# Navigate to the directory containing your docker-compose.yml file
docker-compose down

# Run docker-compose up
docker-compose up --build
