## About Choto URL
It's a url shortner application where you can short your url easily
- clone the repository
 ```
git clone https://github.com/anikweb/choto-url.git
 ```

- install dependencies
```
composer install
```

- install npm packages
```
npm i
```

- create a copy of your .env file
````
cp  .env.example .env
````

- Generate an app encryption key
````
php artisan key:generate
````

- Run the local development server
```
php artisan serve
```

- Run Vite server
```
npm run build && npm run dev
```
- visit http://localhost:8000 in your browser

## License
The Choto URL is open-sourced software licensed under the MIT License
