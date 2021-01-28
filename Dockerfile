FROM laravel:1.0
WORKDIR /app/api
COPY api /app
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]