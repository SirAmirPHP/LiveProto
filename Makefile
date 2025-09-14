# Makefile for Telegram Music Recognition Bot

.PHONY: help install test setup clean backup monitor security logs admin version

# Default target
help:
	@echo "Telegram Music Recognition Bot - Available Commands:"
	@echo ""
	@echo "  install    - Install the bot and dependencies"
	@echo "  test       - Run tests"
	@echo "  setup      - Setup bot configuration"
	@echo "  clean      - Clean temporary files"
	@echo "  backup     - Create database backup"
	@echo "  monitor    - Show system monitoring"
	@echo "  security   - Check security status"
	@echo "  logs       - Show system logs"
	@echo "  admin      - Open admin panel"
	@echo "  version    - Show version information"
	@echo "  docker     - Build and run with Docker"
	@echo "  stop       - Stop Docker containers"
	@echo ""

# Install bot
install:
	@echo "Installing bot..."
	php install.php

# Run tests
test:
	@echo "Running tests..."
	php test.php

# Setup bot
setup:
	@echo "Setting up bot..."
	php setup.php

# Clean temporary files
clean:
	@echo "Cleaning temporary files..."
	php cron.php

# Create backup
backup:
	@echo "Creating backup..."
	php backup.php

# Show monitoring
monitor:
	@echo "Showing system monitoring..."
	php monitor.php

# Check security
security:
	@echo "Checking security..."
	php security.php

# Show logs
logs:
	@echo "Showing logs..."
	php logs.php

# Open admin panel
admin:
	@echo "Opening admin panel..."
	php admin.php

# Show version
version:
	@echo "Showing version information..."
	php version.php

# Docker commands
docker:
	@echo "Building and running with Docker..."
	docker-compose up --build -d

# Stop Docker containers
stop:
	@echo "Stopping Docker containers..."
	docker-compose down

# Development server
dev:
	@echo "Starting development server..."
	php -S localhost:8000

# Full setup
full-setup: install setup test
	@echo "Full setup completed!"

# Production deployment
deploy: clean backup
	@echo "Production deployment completed!"

# Help
.DEFAULT_GOAL := help