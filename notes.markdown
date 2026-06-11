# Bloco de Notas

## Campos
- [ ] Lista 1
- [x] Lista 2

> Citação

Ideias Dashboard
Lista de Imoveis mais vistos
Relatórios e Graficos - Total de Imoveis

# Comands
composer install

bun i 
bun run build

php artisan migrate
php artisan db:seed

php artisan key:generate



Bootstrap/app.php deve ficar assim
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
