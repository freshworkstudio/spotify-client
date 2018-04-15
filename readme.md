# E Class Spotify Client

### Installation
Esta aplicación, basada en Laravel, se instala de la siguiente forma: 

```bash
git clone git@github.com:freshworkstudio/spotify-client.git
cd spotify-client
git checkout develop
composer install --prefer-dist
cp .env.example .env
php artisan key:generate
npm i
npm run dev
php artisan serve
```

