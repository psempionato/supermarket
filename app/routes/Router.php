<?php 

namespace app\routes;

use app\helpers\Request;
use app\helpers\Uri;
use Exception;
use Product;
use ProductController;

class Router
{

    const CONTROLLER_NAMESPACE = 'app\\controllers';

    public static function load(string $controller, string $method)
    {
        try {

            $controllerNamespace = self::CONTROLLER_NAMESPACE.'\\'.$controller;
            if (!class_exists($controllerNamespace)) {
                throw new Exception("O Controller {$controller} não existe" );
            }

            $controllerInstance = new $controllerNamespace;

            if (!method_exists($controllerInstance, $method)) {
                throw new Exception("O método {$method} não existe no Controller {$controller}" );
            }

            $controllerInstance->$method((object)$_REQUEST);

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public static function routes():array
    {
        return [
            'get' => [
                '/' => fn () => self::load('HomeController', 'index'),

                '/products' => fn () => self::load('ProductController', 'index'),
                '/add-product' => fn () => self::load('ProductController', 'create'),

                '/get-product-by-name' => fn () => self::load('ProductController', 'getProductByName'),

                '/product_types' => fn () => self::load('ProductTypeController', 'index'),
                '/add-product-type' => fn () => self::load('ProductTypeController', 'create'),


                '/taxes' => fn () => self::load('TaxController', 'index'),
                '/add-taxes' => fn () => self::load('TaxController', 'create'),

                '/sales' => fn () => self::load('SaleController', 'index'),
                
            ],

            'post' => [
                '/store-product' => fn () => self::load('ProductController', 'store'),
                '/delete-product' => fn () => self::load('ProductController', 'delete'),

                '/store-product-type' => fn () => self::load('ProductTypeController', 'store'),

                '/store-tax' => fn () => self::load('TaxController', 'store'),
                '/delete-tax' => fn () => self::load('TaxController', 'delete'),

                '/store-sale' => fn () => self::load('SaleController', 'store'),
            ],
        ];
    }

    public static function execute()
    {
        try {

            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

            if (!isset($routes[$request])) {
                throw new Exception("A rota não existe");
            }

            if (!array_key_exists($uri, $routes[$request])) {
                throw new Exception("A rota não existe");
            }

            $router = $routes[$request][$uri];

            if (!is_callable($router)){
                throw new Exception("A URI {$uri} não é executável");
            }

            $router();

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}